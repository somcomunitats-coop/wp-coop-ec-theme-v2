<?php

$WPCT_SERVICE_TAX_TERMS = [
    [
        'name' => 'Ciutadania',
        'slug' => 'ciutadania'
    ],
    [
        'name' => 'Empresa i industria',
        'slug' => 'empresa',
    ],
];

add_action('init', 'wpct_register_service_tax', 5);
function wpct_register_service_tax()
{
    if (defined('WP_CLI') && WP_CLI) return;

    $tax_name = 'ce-service';

    register_taxonomy($tax_name, 'ce-landing', [
        'labels' => [
            'name' => __('Serveis', 'wpct'),
            'singular_name' => __('Servei', 'wpct'),
            'search_items' =>  __('Cerca items', 'wpct'),
            'popular_items' => __('Items populars', 'wpct'),
            'all_items' => __('Tots els items', 'wpct'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edita l\'ítem', 'wpct'),
            'update_item' => __('Actualitza l\'ítem', 'wpct'),
            'add_new_item' => __('Crea un nou item', 'wpct'),
            'new_item_name' => __('Nou nom de l\'ítem', 'wpct'),
            'separate_items_with_commas' => __('Separa els items amb comes', 'wpct'),
            'add_or_remove_items' => __('Afegeix o esborra items', 'wpct'),
            'choose_from_most_used' => __('Escull entre els valors més populars', 'wpct'),
            'menu_name' => __('Servei', 'wpct'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'servei'],
        'has_archive' => true,
    ]);

    wpct_lock_service_taxonomy();
}

function wpct_lock_service_taxonomy()
{
    $tax_name = 'ce-service';

    global $WPCT_SERVICE_TAX_TERMS;
    $options = array_map(function ($option) {
        return $option['slug'];
    }, $WPCT_SERVICE_TAX_TERMS);

    $terms = get_terms($tax_name, [
        'hide_empty' => false,
        'taxonomy' => $tax_name
    ]);

    foreach ($terms as $term) {
        if (!in_array($term->slug, $options)) {
            wp_delete_term($term->term_id, $tax_name);
        }
    }
}

// register_activation_hook(__FILE__, 'wpct_init_service_tax_terms');
add_action('init', 'wpct_init_service_tax_terms', 99);
function wpct_init_service_tax_terms()
{
    if (defined('WP_CLI') && WP_CLI) return;

    global $WPCT_SERVICE_TAX_TERMS;
    $tax_name = 'ce-service';

    foreach ($WPCT_SERVICE_TAX_TERMS as $term) {
        $term = wp_insert_term($term['name'], $tax_name, [
            'slug' => $term['slug']
        ]);
    }
}

// register_deactivation_hook(__FIlE__, 'wpct_unregister_service_tax_terms');
function wpct_unregister_service_tax_terms()
{
    global $WPCT_SERVICE_TAX_TERMS;
    $tax_name = 'ce-service';

    $terms = get_terms([
        'taxonomy' => $tax_name,
        'hide_empty' => false
    ]);

    $term_slugs = array_reduce($terms, function ($acum, $term) {
    }, []);

    foreach ($WPCT_SERVICE_TAX_TERMS as $term) {
        if (isset($term_slugs[$term['slug']])) {
            $term_id = $term_slugs[$term['slug']];
            wp_delete_term($term_id, $tax_name);
        }
    }
}

add_action('wp_insert_post', 'wpct_default_landing_service_term', 10);
function wpct_default_landing_service_term($post_id)
{
    if (get_post_type($post_id) !== 'ce-landing') return;

    $tax_name = 'ce-service';

    $terms = get_terms([
        'taxonomy' => $tax_name,
        'hide_empty' => false
    ]);

    $name = $terms[0]->name;

    wp_set_post_terms($post_id, $name, $tax_name);
}
