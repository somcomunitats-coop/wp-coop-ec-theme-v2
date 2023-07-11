<?php

add_action('init', 'ce_block_slider_init');
function ce_block_slider_init()
{
	register_block_type(__DIR__ . '/build');
}

add_action('wp_enqueue_scripts', 'ce_block_slider_scripts');
function ce_block_slider_scripts()
{
	$assets = require(__DIR__ . '/build/index.asset.php');

	// if (has_block('ce-block/slider')) {
	wp_enqueue_script(
		'slick-slider-js',
		'//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
		['jquery'],
		'1.8.1'
	);

	wp_enqueue_style(
		'slick-slider-css',
		'//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
		[],
		'1.8.1'
	);

	wp_enqueue_script(
		'ce-block-slider-js',
		get_theme_file_uri() . '/custom-blocks/slider/assets/js/ce-block-slider.js',
		['jquery'],
		$assets['version']
	);
	// }
}
