<?php
/**
 * Plugin Name: jQuery Lazy Load For Galleries
 * Description: A plugin for lazy loading galleries of images using the jQuery Lazy Load plugin
 * Version: 0.0.1
 *
 * Based on the the WordPress lazy load plugin written by the WordPress.com VIP team at Automattic, the TechCrunch 2011 Redesign team, and Jake Goldman (10up LLC): http://wordpress.org/plugins/lazy-load/
 * Uses the jQuery Lazy Load plugin by Mika Tuupola: https://github.com/tuupola/jquery_lazyload
 *
 * License: GPL2
 */

if ( ! class_exists( 'LazyLoad_Images' ) ) :

class LazyLoad_Images {

	const version = '0.0.1';

	static function init() {
		if ( is_admin() )
			return;

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'add_scripts' ) );

		// Note: this needs to be added so that it's executed after the hook added by Jetpack
		add_filter( 'post_gallery', array( __CLASS__, 'add_image_placeholders' ), 1002, 2 );
	}

	static function add_scripts() {
		wp_enqueue_script( 'wpcom-lazy-load-images',  self::get_url( 'js/lazy-load.js' ), array( 'jquery', 'jquery-lazyload' ), self::version, true );
		wp_enqueue_script( 'jquery-lazyload', self::get_url( 'js/jquery.lazyload.min.js' ), array( 'jquery' ), self::version, true );
	}

	static function add_image_placeholders( $val, $attrs ) {
	// Don't lazy-load if the content has already been run through previously
	if ( false !== strpos( $val, 'data-lazy-src' ) ) {
		return $val;
	}

	// It's possible to filter based on gallery type here, for example
	if ( 'square' !== $attrs['type'] ) {
		return $val;
	}

	// This is a pretty simple regex, but it works
	// Remember to put data-lazy-src as the data attribute if you want to
	// serve your images through photon. They work locally too, though
	$val = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}data-lazy-src="${2}"${3}><noscript><img${1}src="${2}"${3}></noscript>', $placeholder_image ), $val );

	return $val;
	}

	static function get_url( $path = '' ) {
		return plugins_url( ltrim( $path, '/' ), __FILE__ );
	}
}

LazyLoad_Images::init();

endif;
