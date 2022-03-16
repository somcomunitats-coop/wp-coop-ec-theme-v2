<?php

/**
 * Enqueue Child theme assets.
 */
function wp_coop_theme_child_enqueue_scripts() {
  $theme = wp_get_theme();

  wp_enqueue_style( 'wp-coop-theme-child', get_stylesheet_directory_uri().'/css/app.css' , array('wp-coop-theme'), $theme->get( 'Version' ) );
  wp_enqueue_script( 'wp-coop-theme-child', get_stylesheet_directory_uri(). '/js/app.js' , array('wp-coop-theme'), $theme->get( 'Version' ) );

}

add_action( 'wp_enqueue_scripts', 'wp_coop_theme_child_enqueue_scripts' );