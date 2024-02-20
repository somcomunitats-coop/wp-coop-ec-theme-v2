<?php

add_action('init', 'wpct_rest_ce_register_service_tax', 20);
function wpct_rest_ce_register_service_tax()
{
    if (defined('WP_CLI') && WP_CLI) return;

    register_taxonomy(WPCT_REST_CE_SERVICE_TAX, WPCT_REST_CE_POST_TYPE, [
        'labels' => [
            'name' => __('Serveis energètics', 'wpct-rest-ce-landings'),
            'singular_name' => __('Servei energètic', 'wpct-rest-ce-landings'),
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
            'menu_name' => __('Serveis energètics', 'wpct-rest-ce-landings'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'accion-energetica'],
        'has_archive' => true,
    ]);

    // wpct_rest_ce_lock_service_taxonomy();
}

function wpct_rest_ce_lock_service_taxonomy()
{
    $options = array_map(function ($option) {
        return $option['slug'];
    }, WPCT_REST_CE_SERVICE_TERMS);

    $terms = get_terms([
        'hide_empty' => false,
        'taxonomy' => WPCT_REST_CE_SERVICE_TAX
    ]);

    foreach ($terms as $term) {
        if (!in_array($term->slug, $options)) {
            wp_delete_term($term->term_id, WPCT_REST_CE_SERVICE_TAX);
        }
    }
}


add_action('init', 'wpct_rest_ce_register_service_terms', 30);
function wpct_rest_ce_register_service_terms()
{
    if (defined('WP_CLI') && WP_CLI || !get_option('wpct-rest-ce-after-activation')) return;

    foreach (WPCT_REST_CE_SERVICE_TERMS as $term) {
        $term = wp_insert_term($term['name'], WPCT_REST_CE_SERVICE_TAX, [
            'slug' => $term['slug']
        ]);

        if (is_wp_error($term)) continue;

        $term = get_term($term['term_id'], WPCT_REST_CE_SERVICE_TAX);
        $option_id = WPCT_REST_CE_SERVICE_TAX . '_' . $term->term_id;

        foreach (WPCT_REST_CE_SERVICE_XML_SOURCES as $slug => $source) {
            if ($slug === $term->slug) {
                update_option($option_id, [
                    'source_xml_id' => $source
                ]);
            }
        }
    }
}

add_action('wpct_rest_ce_deactivate', 'wpct_rest_ce_unregister_service_terms');
function wpct_rest_ce_unregister_service_terms()
{
    $terms = get_terms([
        'taxonomy' => WPCT_REST_CE_SERVICE_TAX,
        'hide_empty' => false
    ]);

    if (is_wp_error($terms)) return;

    $term_slugs = array_reduce($terms, function ($acum, $term) {
        $acum[$term->slug] = $term->term_id;
        return $acum;
    }, []);

    foreach (WPCT_REST_CE_SERVICE_TERMS as $term) {
        if (isset($term_slugs[$term['slug']])) {
            $term_id = $term_slugs[$term['slug']];
            wp_delete_term($term_id, WPCT_REST_CE_SERVICE_TAX);
            delete_option(WPCT_REST_CE_SERVICE_TAX . '_' . $term_id);
        }
    }
}

add_action(WPCT_REST_CE_SERVICE_TAX . '_add_form_fields', 'wpct_rest_ce_service_add_form_fields', 99);
function wpct_rest_ce_service_add_form_fields()
{ ?>
    <div class="form-field">
        <label for="term_meta[source_xml_id]"><?= __('source_xml_id', 'wpct'); ?></label>
        <input type="text" name="term_meta[source_xml_id]" id="term_meta[source_xml_id]" value="">
        <p class="description"><?= __('Identificador (slug) de l\'acció energètica a Odoo', 'wpct'); ?></p>
    </div>
<?php
}

add_action(WPCT_REST_CE_SERVICE_TAX . '_edit_form_fields', 'wpct_rest_ce_service_edit_form_fields', 99);
function wpct_rest_ce_service_edit_form_fields($term)
{
    $term_meta = get_option(WPCT_REST_CE_SERVICE_TAX . '_' . $term->term_id);
    $value = isset($term_meta['source_xml_id']) && esc_attr($term_meta['source_xml_id']) ? esc_attr($term_meta['source_xml_id']) : '';
?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[source_xml_id]"><?= __('source_xml_id', 'wpct'); ?></label></th>
        <td>
            <input type="text" name="term_meta[source_xml_id]" id="term_meta[source_xml_id]" value="<?= $value; ?>">
            <p class="description"><?= __('Identificador (slug) de l\'acció energètica a Odoo', 'wpct'); ?></p>
        </td>
    </tr>
<?php
}

add_action('edited_' . WPCT_REST_CE_SERVICE_TAX, 'wpct_rest_ce_save_service_custom_field', 10, 2);
add_action('create_' . WPCT_REST_CE_SERVICE_TAX, 'wpct_rest_ce_save_service_custom_field', 10, 2);
function wpct_rest_ce_save_service_custom_field($term_id)
{
    if (isset($_POST['term_meta'])) {
        $term_meta = wpct_rest_ce_get_service_meta($term_id);
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        update_option(WPCT_REST_CE_SERVICE_TAX . '_' . $term_id, $term_meta);
    }
}

function wpct_rest_ce_get_service_meta($term_id)
{
    return get_option(WPCT_REST_CE_SERVICE_TAX . '_' . $term_id);
}
