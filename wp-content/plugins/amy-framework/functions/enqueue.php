<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Framework admin enqueue style and scripts
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_admin_enqueue_scripts' ) ) {
	function amy_admin_enqueue_scripts() {
		// admin utilities
		wp_enqueue_media();

		// wp core styles
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );

		// framework core styles
		wp_enqueue_style( 'amy-framework', AMY_URI . '/assets/css/amy-framework.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( 'font-awesome', AMY_URI . '/assets/css/font-awesome.css', array(), '4.2.0', 'all' );

		if ( is_rtl() ) {
			wp_enqueue_style( 'amy-framework-rtl', AMY_URI . '/assets/css/amy-framework-rtl.css', array(), '1.0.0', 'all' );
		}

		// wp core scripts
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-accordion' );

		// framework core scripts
		wp_enqueue_script( 'amy-plugins', AMY_URI . '/assets/js/amy-plugins.js', array(), '1.0.0', true );
		wp_enqueue_script( 'amy-framework', AMY_URI . '/assets/js/amy-framework.js', array( 'amy-plugins' ), '1.0.0', true );

		wp_localize_script('amy-framework', 'acsL10n', array(
			'delete_sidebar_area'	=> esc_html__( 'Are you sure you want to delete this sidebar?', 'amy-framework' ),
			'shortcode'				=> esc_html__( 'Shortcode', 'amy-framework' ),
		));
	}

	add_action( 'admin_enqueue_scripts', 'amy_admin_enqueue_scripts' );
}
