<?php

require_once 'env.php';

require_once 'includes/model-ce-news.php';
require_once 'includes/model-rest-ce-landing.php';
require_once 'includes/model-rest-ce-coord.php';

require_once 'includes/taxonomy-ce-type.php';
require_once 'includes/taxonomy-ce-assoc-type.php';
require_once 'includes/taxonomy-ce-status.php';
require_once 'includes/taxonomy-ce-service.php';
// require_once 'includes/taxonomy-ce-news.php';

require_once 'custom-blocks/landing-card/landing-card.php';
require_once 'custom-blocks/slider/slider.php';

require_once 'includes/template-functions.php';


// Enqueue Child theme assets.
add_action('wp_enqueue_scripts', 'wpct_ce_enqueue_scripts', 11);
function wpct_ce_enqueue_scripts()
{
    $theme = wp_get_theme();
    $parent = $theme->parent();

    wp_enqueue_style(
        $parent->get_stylesheet(),
        $parent->get_stylesheet_directory_uri() . '/style.css',
        [],
        $parent->get('Version')
    );

    wp_enqueue_style(
        $theme->get_stylesheet(),
        $theme->get_stylesheet_directory_uri() . '/style.css',
        [$parent->get_stylesheet()],
        $theme->get('Version')
    );

    // wp_enqueue_script(
    //     $theme->get_stylesheet(),
    //     $theme->get_stylesheet_directory_uri() . '/assets/js/index.js',
    //     [$parent->get_stylesheet()],
    //     $theme->get('Version'),
    // );

}

// Define fonts.
add_filter('wpct_gfonts', 'wpct_ce_gfonts');
function wpct_ce_gfonts()
{
    return [
        'family=Open+Sans:wght@100;200;300;400;500;600;700;800;900',
        'family=Montserrat:wght@100;200;300;400;500;600;700;800;900',
        'family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
        'family=Besley:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900'
    ];
}

add_action('after_setup_theme', 'wpct_add_theme_support');
function wpct_add_theme_support()
{
    add_editor_style('assets/css/index.css');
}

// Register block styles.
// add_filter('wpct_block_styles', 'wpct_ce_register_block_styles');
// function wpct_ce_register_block_styles($styles)
// {
//     return array_merge($styles, [
//         'core/columns' => [
//             'in-container' => __('In Container', 'wpct-ce'),
//             'no-padding' => __('No Padding', 'wpct-ce'),
//             'no-gap' => __('No Gap', 'wpct-ce')
//         ],
//         'core/button' => [
//             'button-minimal' => __('Minimal', 'wpct-ce'),
//             'button-minimal-back' => __('Back Minimal', 'wpct-ce'),
//         ]
//     ]);
// }

// Analytics
add_action('wp_footer', 'wpct_ce_add_analytics');
function wpct_ce_add_analytics()
{
?>
    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        / tracker methods like 'setCustomDimension' should be called before 'trackPageView' /
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u = '//matomo-staging.somcomunitats.coop/';
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '1']);
            var d = document,
                g = d.createElement('script'),
                s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->

    <!-- Google Tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WD92MXBLJE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-WD92MXBLJE');
    </script>
    <!-- End Google Tag -->
<?php
}

// Register block categories
add_filter('wpct_pattern_categories', 'wpct_ce_register_block_pattern_categories');
function wpct_ce_register_block_pattern_categories($categories)
{
    return array_merge($categories, [
        'ce-pages' => [
            'label' => __('CE Pages', 'wpct-ce')
        ],
        'ce-pattern' => [
            'label' => __('CE Pattern', 'wpct-ce')
        ],
    ]);
}

//  Favicon
add_action('wp_head', 'wpct_set_favicon');
add_action('admin_head', 'wpct_set_favicon');
function wpct_set_favicon()
{ ?>
    <link rel="shortcut icon" href="<?= get_theme_file_uri() . "/img/favicon.ico" ?>" />
<?php
}


/**
 * Tweak canonical Wordpress redirection when attempting /ca/ routes
 */
add_filter('redirect_canonical', 'ce_canonical_redirect', 10, 2);

function ce_canonical_redirect($redirect_url, $requested_url)
{
    $home_url = home_url('/');
    if (preg_match('/' . preg_quote($home_url . "ca/", '/') . '?/', $requested_url)) {
        $redirect_url = $home_url;
    }
    return $redirect_url;
}

/**
 * This function modifies the main WordPress archive query for categories
 * and tags to include an array of post types instead of the default 'post' post type.
 *
 * @param object $query The main WordPress query.
 */
add_action('pre_get_posts', 'ce_include_custom_post_types_in_archive_pages');
function ce_include_custom_post_types_in_archive_pages($query)
{
    if ($query->is_main_query() && !is_admin() && (is_category() || is_tag() && empty($query->query_vars['suppress_filters']))) {
        $query->set('post_type', array('post', 'ce-news'));
    }
}

add_action('pre_get_posts', 'ce_exclude_current_post');
function ce_exclude_current_post($query)
{
    global $post;
    if (is_single() && !$query->is_main_query()) {
        $query->set('post__not_in', [$post->ID]);
    }
}

// Remote CPT

// Data getter on remote model fetch
add_filter('wpct_rcpt_fetch', 'wpct_ce_unfold_landing_payload', 10);
function wpct_ce_unfold_landing_payload($data)
{
    return $data['landing'];
}

// Register remote post types
add_filter('wpct_rcpt_post_types', function ($post_types) {
    return [WPCT_CE_LANDING_POST_TYPE, WPCT_CE_COORD_POST_TYPE];
}, 10, 1);

// Set remote endpoints
add_filter('wpct_rcpt_endpoint', function ($endpoint, $remote_cpt) {
    if (WPCT_RCPT_ENV !== 'development') {
        if ($remote_cpt->post_type === 'rest-ce-landing') {
            return '/api/opendata/landing/' . $remote_cpt->get_meta('company_id');
        } elseif ($remote_cpt->post_type === 'rest-ce-coord') {
            return '/api/opendata/landing/' . $remote_cpt->get_meta('company_id');
        }
    }
    return $endpoint;
}, 10, 2);

// Filter data before rest insert
add_filter('rest_pre_insert_' . WPCT_CE_LANDING_POST_TYPE, 'wpct_ce_rest_pre_insert', 10, 2);
add_filter('rest_pre_insert_' . WPCT_CE_COORD_POST_TYPE, 'wpct_ce_rest_pre_insert', 10, 2);
function wpct_ce_rest_pre_insert($prepared_post, $request)
{

    $payload = $request->get_json_params();
    $data = $payload['landing'];


    $post_data = [
        'post_title' => $data['title'],
        'post_name' => $data['slug_id'],
        'post_status' => $data['status'],
        'post_excerpt' => $data['short_description'],
    ];

    if (!empty($data['wp_landing_page_id'])) {
        $post_data['ID'] = (int) $data['wp_landing_page_id'];
    }

    if (empty($data['primary_image_file'])) {
        delete_post_thumbnail((int) $data['wp_landing_page_id']);
    }

    if (!(empty($data['primary_image_file']) || empty($data['primary_image_file_write_date']))) {
        $url = $data['primary_image_file'];
        $posts = get_posts([
            'post_type' => 'attachment',
            'meta_query' => [[
                'key' => '_wpct_remote_cpt_img_source',
                'value' => $url,
            ]]
        ]);

        foreach ($posts as $media) {
            $modified = get_post_meta($media->ID, '_wpct_remote_cpt_img_modified', true);

            if ($modified === $data['primary_image_file_write_date']) {
                $post_data['_thumbnail_id'] = $media->ID;
                break;
            }
        }

        if (!isset($post_data['_thumbnail_id'])) {
            $request['featured_media'] = $data['primary_image_file'];
        }
    }
    return (object) $post_data;
}

// Set post meta on rest inserts
add_action('rest_insert_' . WPCT_CE_LANDING_POST_TYPE, 'wpct_ce_rest_insert', 10, 3);
add_action('rest_insert_' . WPCT_CE_COORD_POST_TYPE, 'wpct_ce_rest_insert', 10, 3);
function wpct_ce_rest_insert($post, $request, $is_new)
{
    $payload = $request->get_json_params();
    $data = $payload['landing'];

    $status_slug = $data['allow_new_members'] === true ? 'open' : 'closed';

    $type_term = wpct_ce_get_tax_term(WPCT_CE_REST_TYPE_TAX, $data['community_type']);
    if ($type_term) {
        wp_set_post_terms($post->ID, $type_term->name, WPCT_CE_REST_TYPE_TAX);
    }

    $status_term = wpct_ce_get_tax_term(WPCT_CE_REST_STATUS_TAX, $status_slug);
    if ($status_term) {
        wp_set_post_terms($post->ID, $status_term->name, WPCT_CE_REST_STATUS_TAX);
    }

    $assoc_type_term = wpct_ce_get_tax_term(WPCT_CE_REST_ASSOC_TYPE_TAX, $data['community_secondary_type']);
    if ($assoc_type_term) {
        wp_set_post_terms($post->ID, $assoc_type_term->name, WPCT_CE_REST_ASSOC_TYPE_TAX);
    } else {
        wp_set_post_terms($post->ID, 'undefined', WPCT_CE_REST_ASSOC_TYPE_TAX);
    }

    $service_terms = wpct_ce_get_tax_terms(WPCT_CE_REST_SERVICE_TAX);
    $services = [];
    foreach ($data['energy_actions'] as $action) {
        $service_term = null;
        foreach ($service_terms as $term) {
            $term_meta = get_option(WPCT_CE_REST_SERVICE_TAX . '_' . $term->term_id);
            $source_xml_id = isset($term_meta['source_xml_id']) ? 'energy_communities.' . $term_meta['source_xml_id'] : false;
            if ($source_xml_id === $action['ext_id']) {
                $service_term = $term;
                break;
            }
        }

        if ($service_term === null) {
            continue;
        }
        $services[] = $service_term->term_id;
    }

    wp_set_post_terms($post->ID, $services, WPCT_CE_REST_SERVICE_TAX);

    update_post_meta($post->ID, 'ce-address', (string) $data['city']);
    update_post_meta($post->ID, 'company_id', (int) $data['company_id']);
}

add_action('rest_after_insert_' . WPCT_CE_LANDING_POST_TYPE, 'wpct_ce_rest_after_insert', 10, 3);
add_action('rest_after_insert_' . WPCT_CE_COORD_POST_TYPE, 'wpct_ce_rest_after_insert', 10, 3);
function wpct_ce_rest_after_insert($post, $request, $is_new)
{
    $payload = $request->get_json_params();
    $data = $payload['landing'];
    $attachment_id = get_post_thumbnail_id($post->ID);
    update_post_meta($attachment_id, '_wpct_remote_cpt_img_modified', $data['primary_image_file_write_date']);
}

// Sync remote translations
add_action('wpct_rcpt_translation', function ($translation) {
    wpct_ce_translate_meta($translation);

    // Reload remote_cpt from db with new meta
    global $remote_cpt;
    try {
        $remote_cpt->fetch();
    } catch (Exception $e) {
        // Landing is not yet public??
        return;
    }

    wp_update_post([
        'ID' => $translation['post_id'],
        'post_title' => $remote_cpt->get('title', $remote_cpt->post_title),
        'post_name' => $remote_cpt->get('slug_id', $remote_cpt->post_name),
        'post_status' => $remote_cpt->get('status', 'draft'),
        'post_excerpt' => $remote_cpt->get('short_description', $remote_cpt->post_excerpt),
        '_thumbnail_id' => get_post_thumbnail_id($translation['bound']),
    ]);
});

function wpct_ce_translate_meta($translation)
{
    if (get_post_status($translation['bound']) === 'publish') {
        $company_id = get_post_meta($translation['bound'], 'company_id', true);
        update_post_meta($translation['post_id'], 'company_id', (int) $company_id);

        $address = get_post_meta($translation['bound'], 'ce-address', true);
        update_post_meta($translation['post_id'], 'ce-address', (string) $address);
    }
}

// Auxiliar functions
function wpct_ce_get_tax_term($tax, $slug)
{
    $terms = wpct_ce_get_tax_terms($tax, ['slug' => $slug]);
    if (!is_wp_error($terms) && count($terms) > 0) {
        return $terms[0];
    }

    return null;
}

function wpct_ce_get_tax_terms($tax, $query = [])
{
    $query = array_merge([
        'taxonomy' => $tax,
        'hide_empty' => false
    ], $query);

    $terms = get_terms($query);
    if (is_wp_error($terms) || count($terms) === 0) {
        throw new Exception('Unknown term for taxonomy ' . $tax);
    }

    return $terms;
}

function wpct_ce_sync_translation_tax($translation, $tax)
{
    $bound_terms = get_the_terms($translation['bound'], $tax);
    if (is_wp_error($bound_terms) || count($bound_terms) === 0) {
        return;
    }

    $trans_terms = [];
    foreach ($bound_terms as $term) {
        $translations = apply_filters('wpct_i18n_term_translations', $term);
        foreach ($translations as $lang => $term_id) {
            if ($lang !== $translation['lang']) {
                $trans_terms[] = $term_id;
            }
        }
    }

    wp_set_post_terms($translation['post_id'], $trans_terms, $tax);
    return $trans_terms;
}

// ERP forms payload preparation
add_filter('wpct_erp_forms_payload', function ($data) {
    $payload = [
        'metadata' => [],
    ];

    foreach ($data as $key => $value) {
        if ($key === 'source_xml_id') {
            $payload['source_xml_id'] = $value;
        } elseif ($key === 'company_id') {
            $payload['company_id'] = (int) $value;
        } elseif ($key === 'email_from') {
            $payload['email_from'] = $value;
        } elseif ($key === 'submission_id') {
            $payload['entry_id'] = $value;
            $key = 'entry_id';
        }

        $payload['metadata'][] = ['key' => $key, 'value' => $value];
    }

    $payload['name'] = $payload['source_xml_id'] . ' submission: ' . $payload['entry_id'];

    if (!isset($payload['company_id']) || empty($payload['company_id'])) {
        $payload['company_id'] = (int) get_option('wpct-erp-forms_general', [])['company_id'];
    }

    return $payload;
}, 10);

add_filter('wpct-erp-forms_general_defaults', function ($defaults) {
    $defaults['company_id'] = 1;
    return $defaults;
});

add_filter('gettext', function ($trans, $text, $domain) {
    if ($domain === 'wpct-erp-forms' && $text === 'wpct-erp-forms_general__company_id--label') {
        return 'Company ID';
    }

    return $trans;
}, 20, 3);


// CUSTOM RSS FEED
// show post thumbnails in feeds
function diw_post_thumbnail_feeds($content)
{
    global $post;
    if (has_post_thumbnail($post->ID)) {
        $content = $content . '<img src="' . get_the_post_thumbnail_url($post->ID) . '"/>';
    }
    return $content;
}
add_filter('the_content_feed', 'diw_post_thumbnail_feeds');

//populate the options in a Gravity Form select field with all of the posts currently published on the site.

add_filter('gform_pre_render_7', 'populate_coordinadores');
add_filter('gform_pre_validation_7', 'populate_coordinadores');
add_filter('gform_pre_submission_filter_7', 'populate_coordinadores');
add_filter('gform_admin_pre_render_7', 'populate_coordinadores');
function populate_coordinadores($form)
{

    foreach ($form['fields'] as &$field) {

        if ($field->type != 'select' || strpos($field->cssClass, 'ce-coordinadores-posts') === false) {
            continue;
        }
        // $current_language = apply_filters('wpml_current_language', NULL);


        // you can add additional parameters here to alter the posts that are retrieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        $posts = get_posts(
            'numberposts=-1&post_type=rest-ce-coord&post_status=publish'
        );

        $choices = array();

        foreach ($posts as $post) {
            if (apply_filters('wpml_post_language_details', NULL, $post->ID)['language_code'] != "ca") {
                continue;
            }
            $choices[] = array('text' => $post->post_title, 'value' => $post->ID);
        }

        // update 'Select a Post' to whatever you'd like the instructive option to be
        $field->placeholder = 'Quina coordinadora?';
        $field->choices = $choices;
    }

    return $form;
}




add_filter('forms_bridge_payload', function ($payload, $bridge) {
    if ($bridge->name !== 'Alta') {
        return $payload;
    }
    $metadata = $payload['metadata'];
    foreach ($metadata as $field) {
        if ($field['key'] === "coordinator_landing_id") {
            $coord_id = $field['value'];
        }
    }
    if (isset($coord_id)) {
        $coordinador_landing = get_post($coord_id);
        $payload['metadata'][] = [
            'key' => 'coordinator_landing_name',
            'value' => $coordinador_landing->post_title,
        ];
    }
    return $payload;
}, 10, 2);


add_filter('forms_bridge_backend_headers', function ($headers, $backend) {
    if ($backend->name !== 'Odoo_dev4') {
        return $headers;
    }
    $current_lang = apply_filters('wpml_post_language_details', NULL, 1);
    $headers[] = [
        'key' => 'accept-language',
        'value' => $current_lang
    ];

    return $headers;
}, 10, 2);
