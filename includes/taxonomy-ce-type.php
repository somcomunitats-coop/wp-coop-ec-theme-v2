<?php

add_action('init', 'wpct_ce_register_type_tax', 20);
function wpct_ce_register_type_tax()
{
    if (defined('WP_CLI') && WP_CLI) return;

    $config = [
        'labels' => [
            'name' => __('Modalitat', 'wpct-ce'),
            'singular_name' => __('Modalitat', 'wpct-ce'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'servei'],
        'has_archive' => true,
    ];

    register_taxonomy(WPCT_CE_REST_TYPE_TAX, WPCT_CE_LANDING_POST_TYPE, $config);
    register_taxonomy(WPCT_CE_REST_TYPE_TAX, WPCT_CE_COORD_POST_TYPE, $config);

    // wpct_ce_lock_type_taxonomy();
}

function wpct_ce_lock_type_taxonomy()
{
    $options = array_map(function ($option) {
        return $option['slug'];
    }, WPCT_CE_REST_TYPE_TERMS);

    $terms = get_terms(WPCT_CE_REST_TYPE_TAX, [
        'hide_empty' => false,
        'taxonomy' => WPCT_CE_REST_TYPE_TAX
    ]);

    foreach ($terms as $term) {
        if (!in_array($term->slug, $options)) {
            wp_delete_term($term->term_id, WPCT_CE_REST_TYPE_TAX);
        }
    }
}

add_action('init', 'wpct_ce_register_type_terms', 30);
function wpct_ce_register_type_terms()
{
    if (defined('WP_CLI') && WP_CLI) {
        return;
    }

    foreach (WPCT_CE_REST_TYPE_TERMS as $term) {
        $term = wp_insert_term($term['name'], WPCT_CE_REST_TYPE_TAX, [
            'slug' => $term['slug']
        ]);
    }
}
