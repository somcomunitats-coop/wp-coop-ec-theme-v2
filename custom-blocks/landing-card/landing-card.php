<?php
/**
 * Plugin Name:       Landing Card
 * Description:       Landing card with custom fields.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpct-ce
 *
 * @package           wpct-ce-landing-cards
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
add_action( 'init', 'wpct_ce_landing_card_block_init' );
function wpct_ce_landing_card_block_init() {
	register_block_type( __DIR__ . '/build' );
}
