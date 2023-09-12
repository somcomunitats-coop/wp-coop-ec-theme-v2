<?php

$WPCT_CE_EACTION_TAX = 'ce-eaction';
$WPCT_CE_EACTION_TERMS = [
    [
        'name' => __('Generació renovable comunitàtia', 'wpct'),
        'slug' => 'generacio-renovable'
    ],
    [
        'name' => __('Mobilitat sostenible', 'wpct'),
        'slug' => 'mobilitat-sostenible',
    ],
    [
        'name' => __('Eficiència energètica', 'wpct'),
        'slug' => 'eficiencia-energetica',
    ],
    [
        'name' => __('Formació ciutadana', 'wpct'),
        'slug' => 'formacio-ciutadana',
    ],
    [
        'name' => __('Energia tèrmica i climatització', 'wpct'),
        'slug' => 'energia-termica',
    ],
    [
        'name' => __('Subministrament d\'energia renovable', 'wpct'),
        'slug' => 'subministrament-renovable',
    ],
    [
        'name' => __('Compres col·lectives', 'wpct'),
        'slug' => 'compres-colectives',
    ],
];

$WPCT_CE_EACTION_XML_SOURCES = [
    'generacio-renovable' => 'ce_tag_common_generation',
    'eficiencia-energetica' => 'ce_tag_energy_efficiency',
    'mobilitat-sostenible' => 'ce_tag_sustainable_mobility',
    'formacio-ciutadana' => 'ce_tag_citizen_education',
    'energia-termica' => 'ce_tag_thermal_energy',
    'compres-colectives' => 'ce_tag_collective_purchases',
    'subministrament-renovable' => 'ce_tag_renewable_energy',
];

add_action('init', 'wpct_register_ce_eaction_tax', 5);
function wpct_register_ce_eaction_tax()
{
    if (defined('WP_CLI') && WP_CLI) return;

    global $WPCT_CE_EACTION_TAX;

    register_taxonomy($WPCT_CE_EACTION_TAX, 'ce-landing', [
        'labels' => [
            'name' => __('Accions energètiques', 'wpct'),
            'singular_name' => __('Acció energètica', 'wpct'),
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
            'menu_name' => __('Accions energètiques', 'wpct'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'accion-energetica'],
        'has_archive' => true,
    ]);

    wpct_lock_ce_eaction_taxonomy();
}

function wpct_lock_ce_eaction_taxonomy()
{
    global $WPCT_CE_EACTION_TAX;
    global $WPCT_CE_EACTION_TERMS;

    $options = array_map(function ($option) {
        return $option['slug'];
    }, $WPCT_CE_EACTION_TERMS);

    $terms = get_terms($WPCT_CE_EACTION_TAX, [
        'hide_empty' => false,
        'taxonomy' => $WPCT_CE_EACTION_TAX
    ]);

    foreach ($terms as $term) {
        if (!in_array($term->slug, $options)) {
            wp_delete_term($term->term_id, $WPCT_CE_EACTION_TAX);
        }
    }
}


// register_activation_hook(__FILE__, 'wpct_init_eaction_terms');
add_action('init', 'wpct_init_ce_eaction_terms', 99);
function wpct_init_ce_eaction_terms()
{
    if (defined('WP_CLI') && WP_CLI) return;

    global $WPCT_CE_EACTION_TERMS;
    global $WPCT_CE_EACTION_XML_SOURCES;
    global $WPCT_CE_EACTION_TAX;

    foreach ($WPCT_CE_EACTION_TERMS as $term) {
        $term = wp_insert_term($term['name'], $WPCT_CE_EACTION_TAX, [
            'slug' => $term['slug']
        ]);

        if (is_wp_error($term)) continue;

        $term = get_term($term['term_id'], $WPCT_CE_EACTION_TAX);
        $option_id = $WPCT_CE_EACTION_TAX . '_' . $term->term_id;

        foreach ($WPCT_CE_EACTION_XML_SOURCES as $slug => $source) {
            if ($slug === $term->slug) {
                update_option($option_id, [
                    'source_xml_id' => $source
                ]);
            }
        }
    }
}

// register_deactivation_hook(__FILE__, 'wpct_unregister_ce_eaction_terms');
// add_action('init', 'wpct_unregister_ce_eaction_terms', 10);
function wpct_unregister_ce_eaction_terms()
{
    global $WPCT_CE_EACTION_TERMS;
    global $WPCT_CE_EACTION_TAX;

    $terms = get_terms([
        'taxonomy' => $WPCT_CE_EACTION_TAX,
        'hide_empty' => false
    ]);

    $term_slugs = array_reduce($terms, function ($acum, $term) {
        $acum[$term->slug] = $term->term_id;
        return $acum;
    }, []);

    foreach ($WPCT_CE_EACTION_TERMS as $term) {
        if (isset($term_slugs[$term['slug']])) {
            $term_id = $term_slugs[$term['slug']];
            wp_delete_term($term_id, $WPCT_CE_EACTION_TAX);
            delete_option($WPCT_CE_EACTION_TAX . '_' . $term_id);
        }
    }
}

add_action($WPCT_CE_EACTION_TAX . '_add_form_fields', 'wpct_eaction_add_form_fields', 99);
function wpct_eaction_add_form_fields()
{ ?>
    <div class="form-field">
        <label for="term_meta[source_xml_id]"><?= __('source_xml_id', 'wpct'); ?></label>
        <input type="text" name="term_meta[source_xml_id]" id="term_meta[source_xml_id]" value="">
        <p class="description"><?= __('Identificador (slug) de l\'acció energètica a Odoo', 'wpct'); ?></p>
    </div>
<?php
}

add_action($WPCT_CE_EACTION_TAX . '_edit_form_fields', 'wpct_eaction_edit_form_fields', 99);
function wpct_eaction_edit_form_fields($term)
{
    global $WPCT_CE_EACTION_TAX;

    $term_meta = get_option($WPCT_CE_EACTION_TAX . '_' . $term->term_id);
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

add_action('edited_' . $WPCT_CE_EACTION_TAX, 'wpct_save_eaction_custom_field', 10, 2);
add_action('create_' . $WPCT_CE_EACTION_TAX, 'wpct_save_eaction_custom_field', 10, 2);
function wpct_save_eaction_custom_field($term_id)
{
    global $WPCT_CE_EACTION_TAX;

    if (isset($_POST['term_meta'])) {
        $term_meta = get_option($WPCT_CE_EACTION_TAX . '_' . $term_id);
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        update_option($WPCT_CE_EACTION_TAX . '_' . $term_id, $term_meta);
    }
}
