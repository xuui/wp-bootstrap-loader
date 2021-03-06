<?php
/**
 * WP Bootstrap Loader
 *
 * @package wp-bootstrap-loader
 */

 /*
 * Plugin Name: WP Bootstrap Loader
 * Plugin URI:  https://github.com/wp-bootstrap/wp-bootstrap-loader
 * Version: 2.0.5
 * Description: A WordPress class to load Bootstrap and FontAwesome stylesheets and scripts.
 * Author: WP-Bootstrap
 * Author URI: https://github.com/wp-bootstrap
 * GitHub Plugin URI: https://github.com/wp-bootstrap/wp-bootstrap-loader
 * GitHub Branch: master
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'WP_Bootstrap_Loader' ) ) {

	/**
	 * WP_Bootstrap_Loader class.
	 */
	class WP_Bootstrap_Loader {

		/**
		 * Construct
		 *
		 * @access public
		 * @return void
		 */
		function __construct() {

			// Load Bootstrap Scripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ) );

			// Async & Defer.
			add_filter( 'script_loader_tag', array( $this, 'bootstrap_async' ), 10, 2);
			add_filter( 'script_loader_tag', array( $this, 'jquery_migrate_async' ), 10, 3);

			// Load Bootstrap for WordPress Editor.
			add_action( 'admin_init', array( $this, 'bootstrap_editor_css' ) );
		}
		/**
		 * Bootstrap Async and Defer.
		 *
		 * @access public
		 * @param mixed $tag Tag.
		 * @param mixed $handle Handle.
		 * @return void
		 */
		function bootstrap_async($tag, $handle) {
			if ( 'bootstrap' !== $handle )
				return $tag;
			return str_replace( ' src', ' async="async" src', $tag );
		}

		/**
		 * jquery_migrate_async function.
		 *
		 * @access public
		 * @param mixed $tag Tag.
		 * @param mixed $handle Handle.
		 * @return void
		 */
		function jquery_migrate_async( $tag, $handle ) {
			if ( 'jquery-migrate' !== $handle )
				return $tag;
			return str_replace( ' src', ' defer="defer" src', $tag );
		}

		/**
		 * Loads Bootstrap & Font Awesome Stylesheet & Scripts.
		 *
		 * @access public
		 * @return void
		 */
		function bootstrap_scripts() {
			if ( ! is_admin() ) {
				// Twitter Bootstrap CSS.
				wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', '', null, 'all' );
				wp_enqueue_style( 'bootstrap' );
				// Load jQuery.
				wp_enqueue_script( 'jquery' );
				// Twitter Bootstrap Javascript.
				wp_register_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', 'jquery', null, true );
				wp_enqueue_script( 'bootstrap' );
				// Google Webfont.
				wp_register_script( 'webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', null, null, true );
				wp_enqueue_script( 'webfont' );
				// Load Font Awesome via Google Webfont.
				wp_add_inline_script( 'webfont', 'WebFont.load({custom:{families:["font-awesome"],urls:["https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"]}});' );
			}
		}
		/**
		 * Loads Bootstrap & Font-Awesome CSS in WordPress editor.
		 *
		 * @access public
		 * @return void
		 */
		function bootstrap_editor_css() {
				// Support Custom Editor CSS.
				add_editor_style( array(
					'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
					'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
				));
		}
	}
}
new WP_Bootstrap_Loader;
