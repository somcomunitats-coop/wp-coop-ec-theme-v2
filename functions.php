<?php
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