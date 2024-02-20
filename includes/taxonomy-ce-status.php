<?php

add_action('init', 'wpct_rest_ce_register_status_tax', 20);
function wpct_rest_ce_register_status_tax()
{
    if (defined('WP_CLI') && WP_CLI) return;

    register_taxonomy(WPCT_REST_CE_STATUS_TAX, WPCT_REST_CE_POST_TYPE, [
        'labels' => [
            'name' => __('Situació', 'wpct-rest-ce-landings'),
            'singular_name' => __('Situació', 'wpct-rest-ce-landings'),
            'search_items' =>  __('Cerca items', 'wpct-rest-ce-landings'),
            'popular_items' => __('Items populars', 'wpct-rest-ce-landings'),
            'all_items' => __('Tots els items', 'wpct-rest-ce-landings'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edita l\'ítem', 'wpct-rest-ce-landings'),
            'update_item' => __('Actualitza l\'ítem', 'wpct-rest-ce-landings'),
            'add_new_item' => __('Crea un nou item', 'wpct-rest-ce-landings'),
            'new_item_name' => __('Nou nom de l\'ítem', 'wpct-rest-ce-landings'),
            'separate_items_with_commas' => __('Separa els items amb comes', 'wpct-rest-ce-landings'),
            'add_or_remove_items' => __('Afegeix o esborra items', 'wpct-rest-ce-landings'),
            'choose_from_most_used' => __('Escull entre els valors més populars', 'wpct-rest-ce-landings'),
            'menu_name' => __('Situacions', 'wpct-rest-ce-landings'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'estat'],
        'has_archive' => true,
    ]);

    // wpct_rest_ce_lock_status_taxonomy();
}

function wpct_rest_ce_lock_status_taxonomy()
{
    $options = array_map(function ($option) {
        return $option['slug'];
    }, WPCT_REST_CE_STATUS_TERMS);

    $terms = get_terms(WPCT_REST_CE_STATUS_TAX, [
        'hide_empty' => false,
        'taxonomy' => WPCT_REST_CE_STATUS_TAX
    ]);

    foreach ($terms as $term) {
        if (!in_array($term->slug, $options)) {
            wp_delete_term($term->term_id, WPCT_REST_CE_STATUS_TAX);
        }
    }
}

add_action('init', 'wpct_rest_ce_register_status_terms', 30);
function wpct_rest_ce_register_status_terms()
{
    if (defined('WP_CLI') && WP_CLI || !get_option('wpct-rest-ce-after-activation')) return;

    foreach (WPCT_REST_CE_STATUS_TERMS as $term) {
        $term = wp_insert_term($term['name'], WPCT_REST_CE_STATUS_TAX, [
            'slug' => $term['slug']
        ]);
    }
}

add_action('wpct_rest_ce_deactivate', 'wpct_rest_ce_unregister_status_terms', 30);
function wpct_rest_ce_unregister_status_terms()
{
    $terms = get_terms([
        'taxonomy' => WPCT_REST_CE_STATUS_TAX,
        'hide_empty' => false
    ]);

    if (is_wp_error($terms)) return;

    $term_slugs = array_reduce($terms, function ($acum, $term) {
        $acum[$term->slug] = $term->term_id;
        return $acum;
    }, []);

    foreach (WPCT_REST_CE_STATUS_TERMS as $term) {
        if (isset($term_slugs[$term['slug']])) {
            $term_id = $term_slugs[$term['slug']];
            wp_delete_term($term_id, WPCT_REST_CE_STATUS_TAX);
        }
    }
}
