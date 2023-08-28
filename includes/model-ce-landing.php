<?php
add_action('init', 'wpct_create_model_landing');
function wpct_create_model_landing()
{
    register_post_type(
        'ce-landing',
        [
            'labels' => [
                'name' => __('CE Landings', 'wp-coop-ce-theme'),
                'singular_name' => __(
                    'CE Landing',
                    'wp-coop-ce-theme'
                )
            ],

            // Frontend
            'has_archive' => true,
            'public' => true,
            'publicly_queryable' => true,

            // Admin
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-admin-home',
            'menu_position' => 28,
            'query_var' => true,
            'show_in_menu' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'supports' => [
                'title',
                'thumbnail',
                'excerpt',
                'author',
                'editor',
                'custom-fields'
            ],
            'rewrite' => [
                'slug' => 'ce'
            ],
            'taxonomies' => ['category', 'post_tag']
            // 'map_meta_cap' => true,
            // 'capabilities' => [],
            // 'map_meta_cap' => true
        ]
    );
}
