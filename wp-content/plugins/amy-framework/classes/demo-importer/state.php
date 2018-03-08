<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined( 'ABSPATH' ) or die;

class Amy_Demo_Importer_State {

	static function update_state( $demo_id ) {
		$theme			= apply_filters( 'amy_demo_importer_get_theme_name', get_template() );
		$option_name	= $theme . '_demo_state';

		update_option( $option_name, $demo_id );
	}

	static function get_installed_demo() {
		$theme			= apply_filters( 'amy_demo_importer_get_theme_name', get_template() );
		$option_name	= $theme . '_demo_state';
		$state			= get_option( $option_name );

		return $state ? $state : false;
	}
}
