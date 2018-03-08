<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * ------------------------------------------------------------------------------------------------
 *
 * AmyTheme Framework
 * A Lightweight and easy-to-use WordPress Options Framework
 *
 * Plugin Name: AmyTheme Framework
 * Plugin URI: http://amytheme.com/
 * Author: AmyTheme
 * Author URI: http://amytheme.com/
 * Version: 1.2.0
 * Description: A Lightweight and easy-to-use WordPress Options Framework
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: amy-framework
 *
 * ------------------------------------------------------------------------------------------------
 *
 * Copyright 2016 AmyTheme <info@amytheme.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * ------------------------------------------------------------------------------------------------
 */

// ------------------------------------------------------------------------------------------------
require_once plugin_dir_path( __FILE__ ) . '/amy-framework-path.php';
// ------------------------------------------------------------------------------------------------
if ( ! function_exists( 'amy_framework_init' ) && ! class_exists( 'AmyFramework' ) ) {
	function amy_framework_init() {
		// active modules
		defined( 'AMY_ACTIVE_FRAMEWORK' ) or define( 'AMY_ACTIVE_FRAMEWORK', true );
		defined( 'AMY_ACTIVE_METABOX' ) or define( 'AMY_ACTIVE_METABOX', true );
		defined( 'AMY_ACTIVE_TAXONOMY' ) or define( 'AMY_ACTIVE_TAXONOMY', true );
		defined( 'AMY_ACTIVE_SHORTCODE' ) or define( 'AMY_ACTIVE_SHORTCODE', true );
		defined( 'AMY_ACTIVE_CUSTOMIZE' ) or define( 'AMY_ACTIVE_CUSTOMIZE', true );
		defined( 'AMY_ACTIVE_MEGAMENU' ) or define( 'AMY_ACTIVE_MEGAMENU', false );
		defined( 'AMY_ACTIVE_CUSTOM_SIDEBAR' ) or define( 'AMY_ACTIVE_CUSTOM_SIDEBAR', false );

		// helpers
		amy_locate_template( 'functions/fallback.php' );
		amy_locate_template( 'functions/helpers.php' );
		amy_locate_template( 'functions/actions.php' );
		amy_locate_template( 'functions/enqueue.php' );
		amy_locate_template( 'functions/sanitize.php' );
		amy_locate_template( 'functions/validate.php' );

		// classes
		amy_locate_template( 'classes/abstract.class.php' );
		amy_locate_template( 'classes/options.class.php' );
		amy_locate_template( 'classes/framework.class.php' );
		amy_locate_template( 'classes/metabox.class.php' );
		amy_locate_template( 'classes/taxonomy.class.php' );
		amy_locate_template( 'classes/shortcode.class.php' );
		amy_locate_template( 'classes/customize.class.php' );
		amy_locate_template( 'classes/style-builder.class.php' );

		if ( AMY_ACTIVE_MEGAMENU ) {
			amy_locate_template( 'classes/walker-nav-menu.class.php' );
			amy_locate_template( 'classes/megamenu.class.php' );
		}

		// configs
		amy_locate_template( 'config/framework.config.php' );
		amy_locate_template( 'config/metabox.config.php' );
		amy_locate_template( 'config/taxonomy.config.php' );
		amy_locate_template( 'config/shortcode.config.php' );
		amy_locate_template( 'config/customize.config.php' );

		if ( amy_is_vc_activated() ) {
			amy_locate_template( 'plugins/js-composer/includes/init.php' );
		}
	}

	add_action( 'init', 'amy_framework_init', 10 );

	// Load widget library
	function amy_framework_widgets_init() {
		amy_locate_template( 'classes/widget.class.php' );

		// register custom sidebars
		if ( AMY_ACTIVE_CUSTOM_SIDEBAR ) {
			$sidebars	= get_option( 'amy_custom_sidebars' );

			$args		= apply_filters('amy_custom_sidebars_widget_args', array(
				'description'	=> esc_html__( 'Drag widgets for all of pages sidebar', 'amy-framework' ),
				'before_widget'	=> '<div class="amy-widget %2$s">',
				'after_widget'	=> '<div class="clear"></div></div>',
				'before_title'	=> '<div class="amy-widget-title"><h4>',
				'after_title'	=> '</h4></div>',
			));

			if ( is_array( $sidebars ) ) {
				foreach ( $sidebars as $sidebar ) {
					$args['name']	= $sidebar;
					$sidebar		= sanitize_title_with_dashes( $sidebar );
					$args['id']		= $sidebar;
					$args['class']	= 'amy-custom-widget';

					register_sidebar( apply_filters( 'amy_custom_sidebars_widget_args_' . $sidebar, $args ) );
				}
			}
		}
	}

	add_action( 'widgets_init', 'amy_framework_widgets_init' );
}

// update plugin
if ( ! class_exists( 'PucFactory' ) ) {
	require_once 'plugins/update-checker/plugin-update-checker.php';
}

$amyUpdateChecker = PucFactory::buildUpdateChecker(
	'http://plugins.amytheme.com/update-notice/amy-framework.json',
	__FILE__,
	'amy-framework'
);
