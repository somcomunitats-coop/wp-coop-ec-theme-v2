<?php
add_action('init', 'wpct_create_model_news');
// add_action('init', 'insert_default_category_term');
function wpct_create_model_news()
{
    register_post_type(
        'ce-news',
        [
            'labels' => [
                'name' => __('Notícies', 'wpct-ce'),
                'singular_name' => __('Notícia', 'wpct-ce')
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
            ],
            'rewrite' => [
                'slug' => 'noticies'
            ],
            'taxonomies' => ['post_tag', 'category'],
            // 'map_meta_cap' => true,
            // 'capabilities' => [],
            // 'map_meta_cap' => true
        ]
    );
}
