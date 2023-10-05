<?php
add_action('init', 'wpct_create_model_landing');
function wpct_create_model_landing()
{
    register_post_type(
        'ce-landing',
        [
            'labels' => [
                'name' => __('CE Landings', 'wpct'),
                'singular_name' => __(
                    'CE Landing',
                    'wpct'
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
                'custom-fields',
                'category'
            ],
            'rewrite' => [
                'slug' => 'ce'
            ],
            'taxonomies' => ['ce-type', 'ce-status', 'ce-assoc-type', 'ce-eaction']
            // 'map_meta_cap' => true,
            // 'capabilities' => [],
            // 'map_meta_cap' => true
        ]
    );
}

add_action('wp_insert_post', 'wpct_initialize_ce_type_terms', 10, 3);
function wpct_initialize_ce_type_terms($post_id, $post, $update)
{
    if (get_post_type($post_id) !== 'ce-landing' || $update) return;

    global $WPCT_CE_TYPE_TAX;

    $terms = get_terms([
        'taxonomy' => $WPCT_CE_TYPE_TAX,
        'hide_empty' => false
    ]);

    $term = $terms[0]->name;

    wp_set_post_terms($post_id, $term, $WPCT_CE_TYPE_TAX);
}

add_action('wp_insert_post', 'wpct_initialize_ce_status_terms', 11, 3);
function wpct_initialize_ce_status_terms($post_id, $post, $update)
{
    if (get_post_type($post_id) !== 'ce-landing' || $update) return;

    global $WPCT_CE_STATUS_TAX;

    $terms = get_terms([
        'taxonomy' => $WPCT_CE_STATUS_TAX,
        'hide_empty' => false
    ]);

    $term = $terms[0]->name;

    wp_set_post_terms($post_id, $term, $WPCT_CE_STATUS_TAX);
}


add_action('wp_insert_post', 'wpct_initialize_ce_eaction_terms', 12, 3);
function wpct_initialize_ce_eaction_terms($post_id, $post, $update)
{
    if (get_post_type($post_id) !== 'ce-landing' || $update) return;

    global $WPCT_CE_EACTION_TAX;

    $terms = get_terms([
        'taxonomy' => $WPCT_CE_EACTION_TAX,
        'hide_empty' => false
    ]);

    $names = implode(',', array_map(function ($term) {
        return $term->name;
    }, $terms));

    wp_set_post_terms($post_id, $names, $WPCT_CE_EACTION_TAX);
}

add_action('wp_insert_post', 'wpct_initialize_ce_assoc_type_terms', 13, 3);
function wpct_initialize_ce_assoc_type_terms($post_id, $post, $update)
{
    if (get_post_type($post_id) !== 'ce-landing' || $update) return;

    global $WPCT_CE_ASSOC_TYPE_TAX;

    $terms = get_terms([
        'taxonomy' => $WPCT_CE_ASSOC_TYPE_TAX,
        'hide_empty' => false
    ]);

    $term = $terms[0]->name;

    wp_set_post_terms($post_id, $term, $WPCT_CE_ASSOC_TYPE_TAX);
}

add_action('wp_insert_post', 'wpct_initialize_ce_custom_fields', 10, 3);
function wpct_initialize_ce_custom_fields($post_id, $post, $update)
{
    if (get_post_type($post_id) !== 'ce-landing' || $update) return;

    // udate_post_meta($post_id, 'community_type', 'citizen');
    // udate_post_meta($post_id, 'community_secondary_type', 'cooperative');
    // udate_post_meta($post_id, 'community_status', 'closed');
    // udate_post_meta($post_id, 'community_active_services', ['ce_tag_thermal_energy']);
    update_post_meta($post_id, 'ce_company_id', 1);
    update_post_meta($post_id, 'ce_allow_new_members', true);
    update_post_meta($post_id, 'ce_why_become_cooperator', 'Per què hauria d\'esdevenir membre de la cooperativa?');
    update_post_meta($post_id, 'ce_become_cooperator_process', 'Procés d\'incorporació a la cooperativa');
    update_post_meta($post_id, 'ce_become_cooperator_process', 'Procés d\'incorporació a la cooperativa');
    update_post_meta($post_id, 'ce_street', 'Carrer de la comunitat');
    update_post_meta($post_id, 'ce_postal_code', 'Codi postal');
    update_post_meta($post_id, 'ce_city', 'Municipi');
    update_post_meta($post_id, 'ce_external_website_link', 'http://web-de-la.comunitat.org');
    update_post_meta($post_id, 'ce_twitter_link', 'http://twitter.com');
    update_post_meta($post_id, 'ce_telegram_link', 'http://telegram.com');
    update_post_meta($post_id, 'ce_instagram_link', 'http://instagram.com');
}

add_filter('is_protected_meta', 'wpct_filter_ce_custom_fields', 99, 3);
function wpct_filter_ce_custom_fields($protected, $meta_key, $meta_type)
{
    $post_id = get_the_ID();
    if (get_post_type($post_id) !== 'ce-landing') return $protected;
    return substr($meta_key, 0, 3) !== 'ce_';
}
