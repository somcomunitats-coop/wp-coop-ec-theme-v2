<?php

require_once 'env.php';

require_once 'includes/model-ce-news.php';
require_once 'includes/model-rest-ce-landing.php';
require_once 'includes/model-rest-ce-coord.php';

require_once 'includes/taxonomy-ce-type.php';
require_once 'includes/taxonomy-ce-assoc-type.php';
require_once 'includes/taxonomy-ce-status.php';
require_once 'includes/taxonomy-ce-service.php';

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
        $parent->get('Version'),
    );

    wp_enqueue_style(
        $theme->get_stylesheet(),
        $theme->get_stylesheet_directory_uri() . '/style.css',
        [$parent->get_stylesheet()],
        $theme->get('Version'),
    );

    wp_enqueue_script(
        $theme->get_stylesheet(),
        $theme->get_stylesheet_directory_uri() . '/assets/js/index.js',
        [$parent->get_stylesheet()],
        $theme->get('Version'),
    );

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
add_filter('wpct_block_styles', 'wpct_ce_register_block_styles');
function wpct_ce_register_block_styles($styles)
{
    return array_merge($styles, [
      'core/columns' => [
        'in-container' => __('In Container', 'wpct-ce'),
        'no-padding' => __('No Padding', 'wpct-ce'),
        'no-gap' => __('No Gap', 'wpct-ce')
      ],
      'core/button' => [
        'button-minimal' => __('Minimal', 'wpct-ce'),
        'button-minimal-back' => __('Back Minimal', 'wpct-ce'),
      ]
    ]);
}

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
  var u='//matomo-staging.somcomunitats.coop/';
  _paq.push(['setTrackerUrl', u+'matomo.php']);
  _paq.push(['setSiteId', '1']);
  var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
  g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
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
add_filter('wpct_rcpt_endpoint', function ($endpoint, $post) {
    if ($post->post_type === 'rest-ce-landing') {
        return 'api/private/landing/' . $post->get('company_id');
    } elseif ($post->post_type === 'rest-ce-coord') {
        return 'api/private/landing/' . $post->get('company_id');
    }
}, 10, 2);

// Filter data before rest insert
add_filter('rest_pre_insert_' . WPCT_CE_LANDING_POST_TYPE, 'wpct_ce_rest_pre_insert');
add_filter('rest_pre_insert_' . WPCT_CE_COORD_POST_TYPE, 'wpct_ce_rest_pre_insert');
function wpct_ce_rest_pre_insert($post_data, $request)
{
    $payload = $request->get_json_params();
    $data = $payload['landing'];

    $post_data = [
        'post_title' => $data['title'],
        'post_status' => $data['status'],
        'post_excerpt' => $data['short_description'],
    ];

    if (!empty($data['wp_landing_page_id'])) {
        $post_data['ID'] = (int) $data['wp_landing_page_id'];
    }

    if (!empty($data['primary_image_file']) && !empty($data['primary_image_file_write_date'])) {
        $url = $data['primary_image_file'];
        $posts = get_posts([
            'post_type' => 'attachment',
            'meta_query' => [[
                'key' => '_wpct_remote_cpt_img_source',
                'value' => $url,
            ]]
        ]);
        if (count($posts)) {
            $media = $posts[0];
            $modified = get_post_meta($media->ID, '_wpct_remote_cpt_img_modified', true);
            if ($modified === $data->primary_image_file_write_date) {
                $post_data['featured_media'] = $media->ID;
            }
        }
    }

    return $post_data;
}

// Set post meta on rest inserts
add_action('rest_insert_' . WPCT_CE_LANDING_POST_TYPE, 'wpct_ce_rest_insert', 10, 3);
add_action('rest_insert_' . WPCT_CE_COORD_POST_TYPE, 'wpct_ce_rest_insert', 10, 3);
function wpct_ce_rest_insert($post, $request, $is_new)
{
    $payload = $request->get_json_params();
    $data = $payload['landing'];

    $type_term = wpct_ce_get_tax_term(WPCT_CE_REST_TYPE_TAX, $data['community_type']);
    if ($type_term) {
        wp_set_post_terms($post->ID, $type_term->name, WPCT_CE_REST_TYPE_TAX);
    }

    $status_term = wpct_ce_get_tax_term(WPCT_CE_REST_STATUS_TAX, $data['community_status']);
    if ($status_term) {
        wp_set_post_terms($post->ID, $status_term->name, WPCT_CE_REST_STATUS_TAX);
    }

    $assoc_type_term = wpct_ce_get_tax_term(WPCT_CE_REST_ASSOC_TYPE_TAX, $data['community_secondary_type']);
    if ($assoc_type_term) {
        wp_set_post_terms($post->ID, $assoc_type_term->name, WPCT_CE_REST_ASSOC_TYPE_TAX);
    }

    $service_terms = wpct_ce_get_tax_terms(WPCT_CE_REST_STATUS_TAX);
    $services = [];
    foreach ($data['community_active_services'] as $service) {
        $service_term = null;
        foreach ($service_terms as $term) {
            $term_meta = get_option(WPCT_CE_REST_SERVICE_TAX . '_' . $term->term_id);
            if ('energy_communities.' . $term_meta['source_xml_id'] === $service['ext_id']) {
                $service_term = $term;
                break;
            }
        }

        if ($service_term === null) {
            continue;
        }
        $services[] = $service_term->name;
    }

    wp_set_post_terms($post->ID, implode(',', $services), WPCT_CE_REST_SERVICE_TAX);

    update_post_meta($post->ID, 'ce-address', (string) $data['city']);
    update_post_meta($post->ID, 'company_id', (int) $data['company_id']);

    $attachment_id = get_post_thumbnail_id($post->ID);
    update_post_meta($attachment_id, '_wpct_remote_cpt_img_modified', $payload['primary_image_file_write_date']);

    // if ($is_new) wpct_rest_ce_schedule_task('wpct_rest_ce_do_translations', $post->ID);
    // wpct_rest_ce_drop_translations($post->ID);
}

// Sync remote translations
add_action('wpct_rcpt_translation', function ($translation) {
    global $remote_cpt;
    $data = $remote_cpt->fetch();
    wp_update_post([
        'ID' => $translation->post_id,
        'post_title' => $data['title'],
        'post_excerpt' => $data['short_description'],
    ]);

    $attachment_id = get_post_thumbnail_id($remote_cpt->ID);
    if (attachment_id) {
        set_post_thumbnail($translation->post_id, $attachment_id);
    }

    wpct_ce_translate_meta($translation);
});

function wpct_ce_translate_meta($translation)
{
    wpct_ce_sync_translation_tax($translation, WPCT_CE_REST_TYPE_TAX);
    wpct_ce_sync_translation_tax($translation, WPCT_CE_REST_STATUS_TAX);
    wpct_ce_sync_translation_tax($translation, WPCT_CE_REST_ASSOC_TYPE_TAX);
    wpct_ce_sync_translation_tax($translation, WPCT_CE_REST_SERVICE_TAX);

    $company_id = get_post_meta($translation->bound, 'company_id', true);
    update_post_meta($translation->post_id, 'company_id', (int) $company_id);

    $address = get_post_meta($translation->bound, 'ce-address', true);
    update_post_meta($translation->post_id, 'ce-address', (string) $address);
}

// Auxiliar functions
function wpct_ce_get_tax_term($tax, $slug)
{
    $terms = wpct_ce_get_tax_terms($tax, ['slug' => $slug]);
    return $terms[0];
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
    $terms = get_the_terms($post_id, $tax);
    if (is_wp_error($terms) || count($terms) === 0) {
        return;
    }

    wp_set_post_terms($translation->post_id, implode(',', array_map(function ($term) {
        return $term->name;
    }, $terms)), $tax);
}

// erp forms payload preparation
add_filter('wpct_erp_forms_payload', function ($payload) {
    foreach ($payload['metadata'] as $meta) {
        $key = $meta['key'];
        $value = $meta['value'];
        if ($key === 'source_xml_id') {
            $payload['source_xml_id'] = $value;
        } elseif ($key === 'company_id') {
            $payload['company_id'] = $value;
        } elseif ($key === 'email_from') {
            $payload['email_from'] = $value;
        } elseif ($key === 'submission_id') {
            $payload['entry_id'] = $value;
            $meta['key'] = 'entry_id';
        }
    }

    $payload['name'] = $payload['source_xml_id'] . ' submission: ' . $payload['entry_id'];

    if (!isset($payload['company_id']) || empty($payload['company_id'])) {
        $payload['company_id'] = 1;
    }

    if (isset($payload['submission_id'])) {
        unset($payload['submission_id']);
    }

    return $payload;
}, 10);
