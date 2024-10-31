<?php
/*
Plugin Name: Nested Ordered Lists
Plugin URI: https://cubecolour.co.uk/
Description: Add Formatting to Nested Ordered Lists
Author: cubecolour
Version: 1.3.0
Author URI: https://cubecolour.co.uk
*/

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Define Constants
 *
 */
define( 'CC_NOL_PLUGIN_VERSION', '1.3.0' );
define( 'CC_NOL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


/**
 * Add Links in Plugins Table
 *
 */
function cc_nested_ol_meta_links( $links, $file ) {
	$plugin = plugin_basename(__FILE__);
	if ( $file == $plugin ) {
		$supportlink = 'https://wordpress.org/support/plugin/nested-ordered-lists';
		$donatelink = 'https://cubecolour.co.uk/wp';
		$reviewlink = 'https://wordpress.org/support/view/plugin-reviews/nested-ordered-lists';
		$twitterlink = 'https://twitter.com/cubecolour';
		$iconstyle = 'style="-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;font-size: 14px;margin: 4px 0 -4px;"';
		return array_merge( $links, array(
			'<a href="' . $supportlink . '"> <span class="dashicons dashicons-lightbulb" ' . $iconstyle . 'title="Nested Ordered Lists Support"></span></a>',
			'<a href="' . $twitterlink . '"><span class="dashicons dashicons-twitter" ' . $iconstyle . 'title="Twitter"></span></a>',
			'<a href="' . $reviewlink . '"><span class="dashicons dashicons-star-filled"' . $iconstyle . 'title="Give a 5 Star Review"></span></a>',
			'<a href="' . $donatelink . '"><span class="dashicons dashicons-heart"' . $iconstyle . 'title="Donate"></span></a>',
		) );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'cc_nested_ol_meta_links', 10, 2 );


/**
 * Enqueue Styles
 *
 */
function cc_nested_ol_style() {
	wp_enqueue_style( 'cc-nested-ol', CC_NOL_PLUGIN_URL . 'css/nested-ol.css', false, CC_NOL_PLUGIN_VERSION );
}
add_action('wp_enqueue_scripts', 'cc_nested_ol_style');


/**
 * Enqueue Editor Styles for block editor
 *
 */
function cc_nested_ol_block_editor_style() {
    wp_enqueue_style( 'tiered-legal-list-block-editor', CC_NOL_PLUGIN_URL . 'css/nested-ol-block-editor.css', false, CC_NOL_PLUGIN_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'cc_nested_ol_block_editor_style' );


/**
 * Enqueue Editor Styles for visual editor (classic)
 *
 */
function cc_nested_ol_visual_editor_style() {
    add_editor_style( CC_NOL_PLUGIN_URL . 'css/nested-ol-visual-editor.css', false, CC_NOL_PLUGIN_VERSION );
}
add_action( 'after_setup_theme', 'cc_nested_ol_visual_editor_style' );


/**
 * Add 'nested-list' body class as an attempt to override default theme ordered list styles with increased specificity.
 *
 */
function cc_add_bodyclass( $classes ) {
	$classes[] = 'nested-list';
	return $classes;
}
add_filter( 'body_class', 'cc_add_bodyclass' );



/**
 * Add wrap to page content to enable the stylesheet to target only ordered lists within the page content and increase specificity of ol rules
 *
 */
function cc_nolwrap_content( $content ) {

    $wrappedcontent = '<div class="nolwrap">' . $content . '</div>';

    return $wrappedcontent;
}
add_filter( 'the_content', 'cc_nolwrap_content' );