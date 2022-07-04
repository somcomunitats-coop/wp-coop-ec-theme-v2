<?php
add_action( 'init', 'wpct_create_model_community' );
function wpct_create_model_community() {
    register_post_type( 'ce_community',
        array(
            'labels' => array(
                'name' => "Comunitats",
                'singular_name' => "Comunitat"
            ),
            // Frontend
            'has_archive'        => true,
            'public'             => true,
            'publicly_queryable' => true,

            // Admin
            'capability_type' => 'post',
            'menu_icon'       => 'dashicons-admin-home',
            'menu_position'   => 28,
            'query_var'       => true,
            'show_in_menu'    => true,
            'show_ui'         => true,
            'show_in_rest' => true,
            'supports'        => array(
                'title',
                'author',
                'editor',
                'comments'
            ),
            'rewrite' => array(
                'slug' => 'ce'
            ),
            // 'map_meta_cap' => true,
            // 'capabilities' => array(),
            // 'map_meta_cap' => true
        )
    );
}