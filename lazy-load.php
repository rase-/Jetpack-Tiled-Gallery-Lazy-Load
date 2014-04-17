<?php
/**
 * Plugin Name: jQuery Lazy Load For WordPress
 * Description: A plugin for lazy loading of images using the jQuery Lazy Load plugin
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
		add_filter( 'the_content', array( __CLASS__, 'add_image_placeholders' ), 99 ); // run this later, so other content filters have run, including image_add_wh on WP.com
		add_filter( 'post_thumbnail_html', array( __CLASS__, 'add_image_placeholders' ), 11 );
		add_filter( 'get_avatar', array( __CLASS__, 'add_image_placeholders' ), 11 );
	}

	static function add_scripts() {
		wp_enqueue_script( 'wpcom-lazy-load-images',  self::get_url( 'js/lazy-load.js' ), array( 'jquery', 'jquery-lazyload' ), self::version, true );
		wp_enqueue_script( 'jquery-lazyload', self::get_url( 'js/jquery.lazyload.min.js' ), array( 'jquery' ), self::version, true );
	}

	static function add_image_placeholders( $content ) {
		// Don't lazyload for feeds, previews, mobile
		if( is_feed() || is_preview() || ( function_exists( 'is_mobile' ) && is_mobile() ) )
			return $content;

		// Don't lazy-load if the content has already been run through previously
		if ( false !== strpos( $content, 'data-lazy-src' ) )
			return $content;

		// In case you want to change the placeholder image
		//$placeholder_image = apply_filters( 'lazyload_images_placeholder_image', self::get_url( 'images/1x1.trans.gif' ) );

		// This is a pretty simple regex, but it works
		$content = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}data-original="${2}"${3}><noscript><img${1}src="${2}"${3}></noscript>', $placeholder_image ), $content );

		return $content;
	}

	static function get_url( $path = '' ) {
		return plugins_url( ltrim( $path, '/' ), __FILE__ );
	}
}

function lazyload_images_add_placeholders( $content ) {
	return LazyLoad_Images::add_image_placeholders( $content );
}

LazyLoad_Images::init();

endif;
