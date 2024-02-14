<?php

require_once "includes/model-ce-news.php";

require_once "custom-blocks/slider/slider.php";

require_once "custom-blocks/participationdata/participationdata.php";

/**
 * Theme setup.
 */
function wpct_child_setup()
{
  add_editor_style('css/style.css');
  // add_theme_support( 'menus' );
}
add_action('after_setup_theme', 'wpct_child_setup');

/**
 * Enqueue Child theme assets.
 */
function wp_coop_theme_child_enqueue_scripts()
{
  wp_dequeue_style('wp-coop-theme');
  wp_dequeue_style('wp-coop-theme-responsive');
  $theme = wp_get_theme();
  wp_enqueue_style('wp-coop-theme-child', get_stylesheet_directory_uri() . '/css/style.css', array(), $theme->get('Version'));
  wp_enqueue_script('wp-coop-theme-child', get_stylesheet_directory_uri() . '/js/app.js', array('wp-coop-theme'), $theme->get('Version'));
}
add_action('wp_enqueue_scripts', 'wp_coop_theme_child_enqueue_scripts', 11);


/**
 * Enqueue fonts.
 */
function wpct_child_enqueue_fonts()
{
  wp_enqueue_style('wpct-fonts', wpct_child_fonts_url(), array(), null);
}
add_action('wp_enqueue_scripts', 'wpct_child_enqueue_fonts');
add_action('enqueue_block_editor_assets', 'wpct_child_enqueue_fonts');

// Define fonts.
function wpct_child_fonts_url()
{
  // Allow child themes to disable to the default Coop Theme fonts.
  $dequeue_fonts = apply_filters('wpct_dequeue_fonts', false);
  if ($dequeue_fonts) {
    return '';
  }
  $fonts = array(
    'family=Open+Sans:wght@100;200;300;400;500;600;700;800;900',
    'family=Montserrat:wght@100;200;300;400;500;600;700;800;900',
    'family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
    'family=Besley:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900'

  );

  // Make a single request for all Google Fonts.
  return esc_url_raw('https://fonts.googleapis.com/css2?' . implode('&', array_unique($fonts)) . '&display=swap');
}

/**
 * Register block styles.
 *
 */
function wpct_child_register_block_styles()
{

  $block_styles = array(
    'core/columns'           => array(
      'in-container' => __('In Container', 'wpct'),
      'no-padding' => __('No Padding', 'wpct'),
      'no-gap' => __('No Gap', 'wpct')
    ),
    'core/button' => array(
      'button-minimal' => __('Minimal', 'wpct'),
      'button-minimal-back' => __('Back Minimal', 'wpct'),
    )
  );


  foreach ($block_styles as $block => $styles) {
    foreach ($styles as $style_name => $style_label) {
      register_block_style(
        $block,
        array(
          'name'  => $style_name,
          'label' => $style_label
        )
      );
    }
  }
}
add_action('init', 'wpct_child_register_block_styles');


/**
 * Analytics
 *
 */
add_action('wp_footer', 'wpct_add_analytics');
function wpct_add_analytics()
{
  echo "
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
  ";
}
/**
 * Register block categories.
 *
 */

function ce_register_block_pattern_categories()
{
  register_block_pattern_category(
    'ce-pages',
    array('label' => __('CE Pages', 'wpct'))
  );

  register_block_pattern_category(
    'ce-pattern',
    ['label' => __('CE Pattern', 'wpct')]
  );
}
add_action('init', 'ce_register_block_pattern_categories');

add_action('wp_head', 'wpct_add_ga_script');
function wpct_add_ga_script()
{ ?>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-WD92MXBLJE"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-WD92MXBLJE');
  </script>
<?php
}

add_action('wp_head', 'wpct_set_favicon');
function wpct_set_favicon()
{ ?>
  <link rel="shortcut icon" href="<?= get_theme_file_uri() . "/img/favicon.ico" ?>" />
<?php
}
