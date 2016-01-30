<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 1/29/16
 * Time: 12:39 PM
 */

if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_wpmt-session-fields',
        'title' => 'WPMT Session Fields',
        'fields' => array (
            array (
                'key' => 'field_56a12595938bf',
                'label' => 'Session Start',
                'name' => 'wpmt_session_start',
                'type' => 'text',
                'instructions' => 'in veezi: FeatureStartTime
	sample: 2016-01-14T18:30:00',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a1261d938c0',
                'label' => 'Session End',
                'name' => 'wpmt_session_end',
                'type' => 'text',
                'instructions' => 'Veezi field: FeatureEndTime
	sample: 2016-01-14T19:04:00',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a12574938be',
                'label' => 'Film ID',
                'name' => 'wpmt_session_film_id',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a12677938c1',
                'label' => 'Film Title',
                'name' => 'wpmt_session_film_title',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a126f7938c4',
                'label' => 'Session Status',
                'name' => 'wpmt_session_status',
                'type' => 'text',
                'instructions' => 'valid values:
	Open
	Closed
	Planned',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56ab9c1f2bc2c',
                'label' => 'Screen ID',
                'name' => 'wpmt_session_screen_id',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a126bb938c3',
                'label' => 'Seats Available',
                'name' => 'wpmt_session_seats_available',
                'type' => 'number',
                'instructions' => 'SeatsAvailable',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'wpmt_session',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'custom_fields',
                4 => 'discussion',
                5 => 'comments',
                6 => 'revisions',
                7 => 'slug',
                8 => 'author',
                9 => 'format',
                10 => 'featured_image',
                11 => 'categories',
                12 => 'tags',
                13 => 'send-trackbacks',
            ),
        ),
        'menu_order' => 0,
    ));
    register_field_group(array (
        'id' => 'acf_wpmt-film-admin-fields',
        'title' => 'WPMT Film Admin Fields',
        'fields' => array (
            array (
                'key' => 'field_56a10c7a26578',
                'label' => 'Ticket Server Film ID',
                'name' => 'wpmt_film_id',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a10d337a3d1',
                'label' => 'Ticket Server Short Name',
                'name' => 'wpmt_film_short_name',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a111df1ffab',
                'label' => 'Ticket Server status',
                'name' => 'wpmt_film_status',
                'type' => 'text',
                'instructions' => 'veezi valid values:
	Active
	Inactive
	Deleted',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a118f80afd1',
                'label' => 'Ticket Server opening date',
                'name' => 'wpmt_film_opening_date',
                'type' => 'text',
                'instructions' => 'sample:
	2014-08-15T00:00:00',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'wpmt_film',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
                array (
                    'param' => 'user_type',
                    'operator' => '==',
                    'value' => 'administrator',
                    'order_no' => 1,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'custom_fields',
                4 => 'discussion',
                5 => 'comments',
                6 => 'revisions',
                7 => 'slug',
                8 => 'author',
                9 => 'format',
                10 => 'featured_image',
                11 => 'categories',
                12 => 'tags',
                13 => 'send-trackbacks',
            ),
        ),
        'menu_order' => 1,
    ));
    register_field_group(array (
        'id' => 'acf_wpmt-film-fields',
        'title' => 'WPMT Film Fields',
        'fields' => array (
            array (
                'key' => 'field_56ab9761e9e1e',
                'label' => 'Film Format',
                'name' => 'wpmt_film_format',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a10e0618f4a',
                'label' => 'Synopsis',
                'name' => 'wpmt_film_synopsis',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_56a10e1918f4b',
                'label' => 'Genre',
                'name' => 'wpmt_film_genre',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a10e3118f4c',
                'label' => 'Rating',
                'name' => 'wpmt_film_rating',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a10eb518f4e',
                'label' => 'Duration',
                'name' => 'wpmt_film_duration',
                'type' => 'number',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array (
                'key' => 'field_56a11844f6114',
                'label' => 'Distributor',
                'name' => 'wpmt_film_distributor',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a10ef718f50',
                'label' => 'Language',
                'name' => 'wpmt_film_audio_language',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a1185ff6115',
                'label' => 'Director',
                'name' => 'wpmt_film_director',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a11869f6116',
                'label' => 'Actors',
                'name' => 'wpmt_film_actors',
                'type' => 'text',
                'instructions' => 'list actors here (optional) separate by commas',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a119ad9561d',
                'label' => 'Content Advisory',
                'name' => 'wpmt_film_content_advisory',
                'type' => 'text',
                'instructions' => 'ie: Rated PG-13 for a mature thematic image and some sci-fi action/violence.
	 ',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'wpmt_film',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'custom_fields',
                4 => 'discussion',
                5 => 'comments',
                6 => 'revisions',
                7 => 'slug',
                8 => 'author',
                9 => 'format',
                10 => 'featured_image',
                11 => 'categories',
                12 => 'tags',
                13 => 'send-trackbacks',
            ),
        ),
        'menu_order' => 3,
    ));
    register_field_group(array (
        'id' => 'acf_wpmt-film-custom-fields',
        'title' => 'WPMT Film Custom Fields',
        'fields' => array (
            array (
                'key' => 'field_56a113b2b02a2',
                'label' => 'Film Poster',
                'name' => 'wpmt_film_poster',
                'type' => 'image',
                'instructions' => 'vertical poster approx. 250x366',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_56a1147cb02a3',
                'label' => 'Film Key Image',
                'name' => 'wpmt_film_image',
                'type' => 'image',
                'instructions' => 'film featured image. Approx. 480x290',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_56a11673b02a5',
                'label' => 'Hide this film from website',
                'name' => 'wpmt_film_hide',
                'type' => 'true_false',
                'instructions' => 'check this box if you want to prevent this film from showing up on the website.	Useful for test veezi entries, etc.',
                'message' => '',
                'default_value' => 0,
            ),
            array (
                'key' => 'field_56a11735b02a6',
                'label' => 'free',
                'name' => 'wpmt_film_free',
                'type' => 'true_false',
                'instructions' => 'only check this if all screenings of this film are free',
                'message' => '',
                'default_value' => 0,
            ),
            array (
                'key' => 'field_56a1178eb02a7',
                'label' => 'youtube trailer URL',
                'name' => 'wpmt_film_youtube_url',
                'type' => 'text',
                'instructions' => 'full URL from youtube trailer',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_56a117eab02a8',
                'label' => 'reviews',
                'name' => 'wpmt_film_reviews',
                'type' => 'textarea',
                'instructions' => 'copy and paste reviews here (optional)',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'wpmt_film',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 4,
    ));
}