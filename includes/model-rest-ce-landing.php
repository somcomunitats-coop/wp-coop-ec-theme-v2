<?php
add_action('init', function () {
    if (defined('WP_CLI') && WP_CLI) return;

    register_post_type(
        WPCT_CE_LANDING_POST_TYPE,
        [
            'labels' => [
                'name' => __('Comunitats Energètiques', 'wpct-ce'),
                'singular_name' => __('Comunitat Energètica', 'wpct-ce')
            ],

            // Frontend
            'has_archive' => false,
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
                'custom-fields',
            ],
            'rewrite' => ['slug' => 'landing'],
            'taxonomies' => [
                WPCT_CE_REST_TYPE_TAX,
                WPCT_CE_REST_STATUS_TAX,
                WPCT_CE_REST_SERVICE_TAX,
                WPCT_CE_REST_ASSOC_TYPE_TAX,
            ]
            // 'map_meta_cap' => true,
            // 'capabilities' => [],
            // 'map_meta_cap' => true
        ]
    );

    register_post_meta(
        WPCT_CE_LANDING_POST_TYPE,
        'company_id',
        [
            'show_in_rest' => false,
            'single' => true,
            'type' => 'int',
        ]
    );

    register_post_meta(
        WPCT_CE_LANDING_POST_TYPE,
        'ce-address',
        [
            'show_in_rest' => false,
            'single' => true,
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field'
        ]
    );
});

add_action('rest_api_init', function () {
    register_rest_field(
        WPCT_CE_LANDING_POST_TYPE,
        'company_id',
        [
            'get_callback' => function () {
                return get_post_meta($data['id'], 'company_id', true);
            },
            'update_callback' => function ($value, $object) {
                if (!$value) {
                    return null;
                } 

                update_post_meta($object->ID, 'company_id', (int) $value);
                $translations = apply_filters('wpct_i18n_post_translations', null, $object->ID);
                foreach ($translations as $trans) {
                    update_post_meta($trans->ID, 'company_id', (int) $value);
                }
            }
        ]
    );

    register_rest_field(
        WPCT_CE_LANDING_POST_TYPE,
        'translations',
        [
            'get_callback' => function ($data) {
                $translations = apply_filters('wpct_i18n_post_translations', null, $data['id']);
                $links = [];
                foreach ($translations as $trans) {
                    $links[$trans->slug] = get_permalink($trans->ID);
                }

                return $links;
            }
        ]
    );
});
