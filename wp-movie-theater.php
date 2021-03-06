<?php

/*
Plugin Name: WP Movie Theater
Plugin URI: https://github.com/chipete/wp-movie-theater
Description: Custom post type “films” and “sessions” (with ticket links) which can then be displayed as a sortable list on a page, and also individually as posts.  Content can be automatically generated and updated from ticket server json feed.
Version: 1.8.1
Author: Chris, Ryan
Author URI: http://lightmarkcreative.com
License: GPL2
*/

date_default_timezone_set('America/New_York');

//=========================== Includes =======================//

require_once ( 'classes/class-wpmt-session.php' );
require_once ( 'classes/class-wpmt-film.php' );
require_once ( 'classes/class-wpmt-performance.php' );
require_once ( 'classes/class-wpmt-tmdb.php' );

require_once ( 'inc/custom-post-types.php' );
require_once ( 'inc/custom-fields.php' );
require_once ( 'inc/load-ticket-servers.php' );
require_once ( 'inc/settings-panel.php' );
require_once ( 'inc/display-film.php' );

//=========================== Actions & Filters ==============//


// when the plugin is activated, add runMovieTheater to the wp-cron schedule hourly:
register_activation_hook( __FILE__, 'wpmt_activation' );

function wpmt_activation() {
    wp_schedule_event( time(), 'hourly', 'wpmt_update_posts' );
}

add_action( 'wpmt_update_posts', 'wpmt_run' );

// clean the scheduler on deactivation:
register_deactivation_hook( __FILE__, 'wpmt_deactivation' );

function wpmt_deactivation() {
	wp_clear_scheduled_hook( 'wpmt_update_posts' );
}

// add the image crop sizes to WP
add_image_size( 'wpmt_poster', 134, 193 );
add_image_size( 'wpmt_image', 480, 290 );
add_image_size( 'wpmt_slider_thumb', 170, 112, true );
add_image_size( 'wpmt_thumb_280x112', 280, 112, true );
add_image_size( 'wpmt_thumb_280x158', 280, 158, true );

add_filter( 'image_size_names_choose', 'wpmt_custom_image_sizes');

function wpmt_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'wpmt_poster'          => __( 'WPMT Poster (250x366)' ),
        'wpmt_image'           => __( 'WPMT Image (480x290)' ),
        'wpmt_slider_thumb'    => __( 'WPMT Slider Thumb (170x112)' ),
        'wpmt_thumb_280x112'   => __( 'WPMT Slider Thumb (280x112)' ),
        'wpmt_thumb_280x158'   => __( 'WPMT Slider Thumb (280x158)' ),

    ) );
}


//=========================== Functions ======================//

//main function that runs everything

function wpmt_run() {

    $my_token                     = esc_attr( get_option( 'wpmt_veezi_token' ) );
    $veezi_access_token           = 'VeeziAccessToken: ' . $my_token;
    $session_data                 = call_service( 'https://api.us.veezi.com/v1/websession', $veezi_access_token );
    $film_and_performance_data    = call_service( 'https://api.us.veezi.com/v1/film', $veezi_access_token );

    //1. delete all sessions
    wpmt_delete_all_posts( 'wpmt_session' );

    //1-B. for testing, delete all films. This should be commented-out
    //wpmt_delete_all_posts( 'wpmt_film' );

    //2. if all sessions have been deleted, add the new ones
    if ( NULL == get_posts( array( 'post_type'=> 'wpmt_session' ) ) ) {
        wpmt_add_sessions( $session_data );
    }

    //3. update all films & performances
    wpmt_update_posts( $film_and_performance_data );
}


function wpmt_update_posts( $post_data ) {

    $performance_genres = array (
        'Alternative Content',
        'Comedy',
        'Concert',
        'Dance',
        'Family',
        'Live Show',
        'Live Sports Broadcast',
        'Musical'
    );

    $post_data_as_array = wpmt_object_to_array( $post_data );

    for ( $i = 0; $i < count( $post_data_as_array ); $i++ ) {

        // do not import festival films
        if ( $post_data_as_array[$i]["Genre"] != "Festival" ) {

            // if the format is 'not a film' and is a performance genre, then make it a performance
            if ( $post_data_as_array[$i]["Format"] == "Not a Film" && in_array( $post_data_as_array[$i]["Genre"], $performance_genres ) ) {
                $performance = new WPMT_Performance;
                $performance->assign_values( $post_data_as_array, $i );

                if ( ( $performance->status == "Inactive" ) || ( $performance->status == "Deleted" ) ) {

                    $inactive_performances = get_posts( array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'wpmt_performance',
                        'meta_key'          => 'wpmt_performance_id',
                        'meta_value'        => $performance->id
                    ) );
                    foreach ( $inactive_performances as $my_post ) {
                        wp_delete_post( $my_post->ID, true );
                        // Set to False if you want to send them to Trash.
                    }

                } elseif ( null == get_posts( array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'wpmt_performance',
                        'meta_key'          => 'wpmt_performance_id',
                        'meta_value'        => $performance->id
                    ) )
                    ) {
                        $post_id = wpmt_add_post( $performance->title, 'wpmt_performance' );
                        $performance->update_fields( $post_id );
                 }
                //If option is checked to overwrite film or performance format
                elseif (( null != get_posts( array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'wpmt_performance',
                        'meta_key'          => 'wpmt_performance_id',
                        'meta_value'        => $performance->id
                    ) )
                  ) && (esc_attr( get_option( 'wpmt_overwrite_format' ) ) != "No")) {
                    $posts = get_posts( array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'wpmt_performance',
                        'meta_key'          => 'wpmt_performance_id',
                        'meta_value'        => $performance->id
                    ));
                    foreach ($posts as $post) {
                        $performance->update_performance_format( $post->ID);
                    }

                }

            // if the format or genre is anything else, make a film
            } else {
                $film = new WPMT_Film;
	            $tmdb = new WPMT_Tmdb;

                $film->assign_values( $post_data_as_array, $i );

                if ( $film->status == "Inactive"  || $film->status == "Deleted" ) {

                    $inactive_films = get_posts( array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'wpmt_film',
                        'meta_key'          => 'wpmt_film_id',
                        'meta_value'        => $film->id
                    ) );
                    foreach ( $inactive_films as $my_post ) {
                        wp_delete_post( $my_post->ID, true );
                        // Set to False if you want to send them to Trash.
                    }

                } elseif ( null == get_posts( array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'wpmt_film',
                        'meta_key'          => 'wpmt_film_id',
                        'meta_value'        => $film->id
                    ) ) ) {
                    $post_id = wpmt_add_post( $film->title, 'wpmt_film' );
                    $film->update_fields( $post_id );
	                $tmdb->update_fields( $post_id );
                }
                elseif (( null != get_posts( array(
                            'posts_per_page'    => -1,
                            'post_type'         => 'wpmt_film',
                            'meta_key'          => 'wpmt_film_id',
                            'meta_value'        => $film->id
                        ) )
                    ) && (esc_attr( get_option( 'wpmt_overwrite_format' ) ) != "No")) {
                    $posts = get_posts( array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'wpmt_film',
                        'meta_key'          => 'wpmt_film_id',
                        'meta_value'        => $film->id
                    ));
                    foreach ($posts as $post) {
                        $film->update_film_format( $post->ID);
                    }

                }

            }//end else
        }//end if

    } //end $post_data_as_array for loop

}


function wpmt_delete_all_posts( $post_type ) {

    // deletes all posts within a post_type
    $my_custom_posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1 ) );

    foreach( $my_custom_posts as $my_post ) {
        wp_delete_post( $my_post->ID, true );
        // Set to False if you want to send them to Trash.
    }
}


function wpmt_add_sessions( $session_data )
{
    $session_data_as_array = wpmt_object_to_array( $session_data );

    $session = new WPMT_Session;

    for ( $i = 0; $i < count( $session_data_as_array ); $i++ ) {

        $session->assign_values( $session_data_as_array, $i );

        $post_id = wpmt_add_post( $session->title, 'wpmt_session' );
        $session->update_fields( $post_id );
    }
}


function wpmt_add_post( $title, $post_type ) {
//helper function to add a new post

    // Setup the author
    $author_id = 1;

    $post_id = wp_insert_post( array(
        'comment_status'=>	'closed',
        'ping_status'	=>	'closed',
        'post_author'	=>	$author_id,
        'post_title'	=>	$title,
        'post_status'	=>	'publish',
        'post_type'		=>	$post_type
        ) );

    return $post_id;
}


function wpmt_display_film_shortcode( $content ) {

    global $post;

    if ( get_post_type() == 'wpmt_film' ) {

        wpmt_display_film();
    }

    return $content;

}

// add_filter( 'the_content', 'wpmt_display_film_shortcode' );


function wpmt_display_films_shortcode( $atts, $content = null ) {

    $args = array(
        'post_type'         => 'wpmt_film',
        'posts_per_page'    => '-1',
        'meta_key'          => 'wpmt_film_opening_date',
        'orderby'           => 'meta_value',
        'order'             => 'ASC'
    );

    $my_query = new WP_Query( $args );

    if ( $my_query->have_posts() ) {

        while ( $my_query->have_posts() ) {
            $my_query->the_post();
            if ( wpmt_sessions_exist( get_field( 'wpmt_film_id' ) ) || esc_attr( get_option( 'wpmt_hide_films_with_no_sessions') ) == "No" ) {
                //first checks to make sure there are sessions before displaying the film or ignores if the option to allow all films is selected
                //the displays the film
                wpmt_display_film();
            }
        }
    }

    return $content;

}

add_shortcode( 'wpmt_films', 'wpmt_display_films_shortcode' );


function wpmt_sessions_exist ( $wpmt_film_id ) {

    $args = array(
        'post_type'         => 'wpmt_session',
        'meta_key'          => 'wpmt_session_film_id',
        'meta_value'        => $wpmt_film_id
    );

    $my_query2 = new WP_Query( $args );

    if ( $my_query2->have_posts() ) {
        return true;
    }
    else {
        return false;
    }
}


function wpmt_get_ticket_server_url () {
    return 'http://ticketing.us.veezi.com/sessions/?siteToken=TxTIIqmyZE6D2x7lOm%2fRiQ%3d%3d';
}