<?php
add_action('init', 'wpct_register_social_form_cat');
function wpct_register_social_form_cat()
{
    register_taxonomy('ce-social-form', 'ce-landing', [
        'labels' => [
            'name' => __('Formes socials', 'wpct'),
            'singular_name' => __('Forma social', 'wpct'),
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
            'menu_name' => __('Forma social', 'wpct'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'ce-social-form'],
        'has_archive' => true,
    ]);
}
