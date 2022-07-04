<?php
require_once "includes/model-ce-community.php";

/**
 * Theme setup.
 */
function wpct_child_setup() {
  add_editor_style( 'css/app.css' );
}
add_action( 'after_setup_theme', 'wpct_child_setup' );
/**
 * Enqueue Child theme assets.
 */
function wp_coop_theme_child_enqueue_scripts() {
  wp_dequeue_style('wp-coop-theme');
  wp_dequeue_style('wp-coop-theme-responsive');
  $theme = wp_get_theme();
  wp_enqueue_style( 'wp-coop-theme-child', get_stylesheet_directory_uri().'/css/app.css' , array(), $theme->get( 'Version' ) );
  wp_enqueue_style( 'wp-coop-theme-child=responsive', get_stylesheet_directory_uri().'/css/responsive.css' , array(), $theme->get( 'Version' ) );
  wp_enqueue_script( 'wp-coop-theme-child', get_stylesheet_directory_uri(). '/js/app.js' , array('wp-coop-theme'), $theme->get( 'Version' ) );

}

add_action( 'wp_enqueue_scripts', 'wp_coop_theme_child_enqueue_scripts',11 );


/**
 * Enqueue fonts.
 */
function wpct_child_enqueue_fonts() {
  wp_enqueue_style( 'wpct-fonts', wpct_child_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'wpct_child_enqueue_fonts' );
add_action( 'enqueue_block_editor_assets', 'wpct_child_enqueue_fonts' );

// Define fonts.
function wpct_child_fonts_url() {
  // Allow child themes to disable to the default Coop Theme fonts.
  $dequeue_fonts = apply_filters( 'wpct_dequeue_fonts', false );
  if ( $dequeue_fonts ) {
    return '';
  }
  $fonts = array(
    'family=Open+Sans:wght@100;200;300;400;500;600;700;800;900',
    'family=Montserrat:wght@100;200;300;400;500;600;700;800;900'
  );

  // Make a single request for all Google Fonts.
  return esc_url_raw( 'https://fonts.googleapis.com/css2?' . implode( '&', array_unique( $fonts ) ) . '&display=swap' );

}

/**
 * Register block styles.
 *
 */
function wpct_child_register_block_styles() {

  $block_styles = array(
    'core/columns'           => array(
      'in-container' => __( 'In Container', 'wpct' ),
    )
  );

  foreach ( $block_styles as $block => $styles ) {
    foreach ( $styles as $style_name => $style_label ) {
      register_block_style(
        $block,
        array(
          'name'  => $style_name,
          'label' => $style_label,
        )
      );
    }
  }
}
add_action( 'init', 'wpct_child_register_block_styles' );