<?php

$WPCT_CE_TYPE_TAX = 'ce-type';
$WPCT_CE_TYPE_TERMS = [
    [
        'name' => 'Ciutadania',
        'slug' => 'citizen'
    ],
    [
        'name' => 'Empresa i industria',
        'slug' => 'industrial',
    ],
];

add_action('init', 'wpct_register_ce_type_tax', 5);
function wpct_register_ce_type_tax()
{
    if (defined('WP_CLI') && WP_CLI) return;

    global $WPCT_CE_TYPE_TAX;

    register_taxonomy($WPCT_CE_TYPE_TAX, 'ce-landing', [
        'labels' => [
            'name' => __('Servei', 'wpct'),
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
            'menu_name' => __('Serveis', 'wpct'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'servei'],
        'has_archive' => true,
    ]);

    // wpct_lock_ce_type_taxonomy();
}

function wpct_lock_ce_type_taxonomy()
{
    global $WPCT_CE_TYPE_TAX;
    global $WPCT_CE_TYPE_TERMS;

    $options = array_map(function ($option) {
        return $option['slug'];
    }, $WPCT_CE_TYPE_TERMS);

    $terms = get_terms($WPCT_CE_TYPE_TAX, [
        'hide_empty' => false,
        'taxonomy' => $WPCT_CE_TYPE_TAX
    ]);

    foreach ($terms as $term) {
        if (!in_array($term->slug, $options)) {
            wp_delete_term($term->term_id, $WPCT_CE_TYPE_TAX);
        }
    }
}

// register_activation_hook(__FILE__, 'wpct_init_type_tax_terms');
add_action('init', 'wpct_init_ce_type_terms', 99);
function wpct_init_ce_type_terms()
{
    if (defined('WP_CLI') && WP_CLI) return;

    global $WPCT_CE_TYPE_TAX;
    global $WPCT_CE_TYPE_TERMS;

    foreach ($WPCT_CE_TYPE_TERMS as $term) {
        $term = wp_insert_term($term['name'], $WPCT_CE_TYPE_TAX, [
            'slug' => $term['slug']
        ]);
    }
}

// register_deactivation_hook(__FIlE__, 'wpct_unregister_ce_type_terms');
// add_action('init', 'wpct_unregister_ce_type_terms', 10);
function wpct_unregister_ce_type_terms()
{
    global $WPCT_CE_TYPE_TAX;
    global $WPCT_CE_TYPE_TERMS;

    $terms = get_terms([
        'taxonomy' => $WPCT_CE_TYPE_TAX,
        'hide_empty' => false
    ]);

    $term_slugs = array_reduce($terms, function ($acum, $term) {
        $acum[$term->slug] = $term->term_id;
        return $acum;
    }, []);

    foreach ($WPCT_CE_TYPE_TERMS as $term) {
        if (isset($term_slugs[$term['slug']])) {
            $term_id = $term_slugs[$term['slug']];
            wp_delete_term($term_id, $WPCT_CE_TYPE_TAX);
        }
    }
}

function wpct_ce_type_icon($slug)
{
    if ($slug === 'citizen') {
        return '<i class="fa fa-building"></i>';
    } else if ($slug === 'industrial') {
        return '<i class="fa fa-industry"></i>';
    } else {
        return '';
    }
}
