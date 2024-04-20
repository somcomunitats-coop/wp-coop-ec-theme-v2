<?php

add_action('init', 'wpct_ce_register_service_tax', 20);
function wpct_ce_register_service_tax()
{
    if (defined('WP_CLI') && WP_CLI) {
        return;
    }

    $config = [
        'labels' => [
            'name' => __('Serveis energètics', 'wpct-ce'),
            'singular_name' => __('Servei energètic', 'wpct-ce'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'accion-energetica'],
        'has_archive' => true,
    ];

    register_taxonomy(WPCT_CE_REST_SERVICE_TAX, [WPCT_CE_LANDING_POST_TYPE, WPCT_CE_COORD_POST_TYPE], $config);

    // wpct_ce_lock_service_taxonomy();
}

function wpct_ce_lock_service_taxonomy()
{
    $options = array_map(function ($option) {
        return $option['slug'];
    }, WPCT_CE_REST_SERVICE_TERMS);

    $terms = get_terms([
        'hide_empty' => false,
        'taxonomy' => WPCT_CE_REST_SERVICE_TAX
    ]);

    foreach ($terms as $term) {
        if (!in_array($term->slug, $options)) {
            wp_delete_term($term->term_id, WPCT_CE_REST_SERVICE_TAX);
        }
    }
}


add_action('init', 'wpct_ce_register_service_terms', 30);
function wpct_ce_register_service_terms()
{
    if (defined('WP_CLI') && WP_CLI) {
        return;
    }

    $current_language = apply_filters('wpct_i18n_current_language', null, 'slug');
    if ($current_language !== 'ca') {
        return;
    }

    foreach (WPCT_CE_REST_SERVICE_TERMS as $term) {
        $term = wp_insert_term($term['name'], WPCT_CE_REST_SERVICE_TAX, [
            'slug' => $term['slug']
        ]);

        if (is_wp_error($term)) {
            continue;
        }

        $term = get_term($term['term_id']);
        foreach (WPCT_CE_REST_SERVICE_XML_SOURCES as $slug => $source) {
            if ($slug === $term->slug) {
                wpct_ce_set_service_meta($term->term_id, [
                    'source_xml_id' => $source
                ]);
            }
        }
    }
}

add_action(WPCT_CE_REST_SERVICE_TAX . '_add_form_fields', 'wpct_ce_service_add_form_fields', 99);
function wpct_ce_service_add_form_fields()
{ ?>
    <div class="form-field">
        <label for="term_meta[source_xml_id]"><?= __('source_xml_id', 'wpct-ce'); ?></label>
        <input type="text" name="term_meta[source_xml_id]" id="term_meta[source_xml_id]" value="">
        <p class="description"><?= __('Identificador (slug) de l\'acció energètica a Odoo', 'wpct-ce'); ?></p>
    </div>
<?php
}

add_action(WPCT_CE_REST_SERVICE_TAX . '_edit_form_fields', 'wpct_ce_service_edit_form_fields', 99);
function wpct_ce_service_edit_form_fields($term)
{
    $term_meta = wpct_ce_get_service_meta($term->term_id);
    $value = isset($term_meta['source_xml_id']) && esc_attr($term_meta['source_xml_id']) ? esc_attr($term_meta['source_xml_id']) : '';
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[source_xml_id]"><?= __('source_xml_id', 'wpct-ce'); ?></label></th>
        <td>
            <input type="text" name="term_meta[source_xml_id]" id="term_meta[source_xml_id]" value="<?= $value; ?>">
            <p class="description"><?= __('Identificador (slug) de l\'acció energètica a Odoo', 'wpct-ce'); ?></p>
        </td>
    </tr>
<?php
}

add_action('edited_' . WPCT_CE_REST_SERVICE_TAX, 'wpct_ce_save_service_custom_field', 10, 2);
add_action('create_' . WPCT_CE_REST_SERVICE_TAX, 'wpct_ce_save_service_custom_field', 10, 2);
function wpct_ce_save_service_custom_field($term_id)
{
    if (isset($_POST['term_meta'])) {
        $term_meta = wpct_ce_get_service_meta($term_id);
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }

        wpct_ce_set_service_meta($term_id, $term_meta);
    }
}

function wpct_ce_get_service_meta($term_id)
{
    return get_option(WPCT_CE_REST_SERVICE_TAX . '_' . $term_id);
}

function wpct_ce_set_service_meta($term_id, $term_meta = [])
{
    update_option(WPCT_CE_REST_SERVICE_TAX . '_' . $term_id, $term_meta);
}
