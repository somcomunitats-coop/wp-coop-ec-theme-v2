<?php
add_action('init', 'wpct_create_model_news');
function wpct_create_model_news()
{
    register_post_type(
        'ce-news',
        [
            'labels' => [
                'name' => __('Notícies', 'wp-coop-ce-theme'),
                'singular_name' => __(
                    'Notícia',
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
                'comments',
                'tags'
            ],
            'rewrite' => [
                'slug' => 'ce-news'
            ],
            // 'map_meta_cap' => true,
            // 'capabilities' => array(),
            // 'map_meta_cap' => true
        ]
    );

    register_taxonomy('post_tag', 'ce-news', [
        'labels' => [
            'name' => __('Tags'),
            'singular_name' => __('Tag'),
            'search_items' =>  __('Search Tags'),
            'popular_items' => __('Popular Tags'),
            'all_items' => __('All Tags'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit Tag'),
            'update_item' => __('Update Tag'),
            'add_new_item' => __('Add New Tag'),
            'new_item_name' => __('New Tag Name'),
            'separate_items_with_commas' => __('Separate tags with commas'),
            'add_or_remove_items' => __('Add or remove tags'),
            'choose_from_most_used' => __('Choose from the most used tags'),
            'menu_name' => __('Tags'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => ['slug' => 'post_tag'],
        'has_archive' => true,
    ]);
}
