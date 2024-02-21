<?php

add_action('init', 'wpct_ce_register_status_tax', 20);
function wpct_ce_register_status_tax()
{
    if (defined('WP_CLI') && WP_CLI) return;

    register_taxonomy(WPCT_CE_REST_STATUS_TAX, WPCT_CE_LANDING_POST_TYPE, [
        'labels' => [
            'name' => __('Situació', 'wpct-ce'),
            'singular_name' => __('Situació', 'wpct-ce'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'estat'],
        'has_archive' => true,
    ]);

    // wpct_ce_lock_status_taxonomy();
}

function wpct_ce_lock_status_taxonomy()
{
    $options = array_map(function ($option) {
        return $option['slug'];
    }, WPCT_CE_REST_STATUS_TERMS);

    $terms = get_terms(WPCT_CE_REST_STATUS_TAX, [
        'hide_empty' => false,
        'taxonomy' => WPCT_CE_REST_STATUS_TAX
    ]);

    foreach ($terms as $term) {
        if (!in_array($term->slug, $options)) {
            wp_delete_term($term->term_id, WPCT_CE_REST_STATUS_TAX);
        }
    }
}

add_action('init', 'wpct_ce_register_status_terms', 30);
function wpct_ce_register_status_terms()
{
    if (defined('WP_CLI') && WP_CLI) {
        return;
    }

    foreach (WPCT_CE_REST_STATUS_TERMS as $term) {
        $term = wp_insert_term($term['name'], WPCT_CE_REST_STATUS_TAX, [
            'slug' => $term['slug']
        ]);
    }
}
