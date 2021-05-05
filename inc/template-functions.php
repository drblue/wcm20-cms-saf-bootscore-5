<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Bootscore
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bootscore_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'bootscore_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bootscore_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'bootscore_pingback_header' );

if (!function_exists('dump')) {
	/**
	 * var_dump variable
	 *
	 * @param mixed $var Variable to dump
	 * @param boolean $wrap Wrap output in <pre>-tag?
	 * @return void
	 */
	function dump($var, $wrap = true) {
		if ($wrap) {
			echo "<pre>";
		}

		var_dump($var);

		if ($wrap) {
			echo "</pre>";
		}
	}
}
