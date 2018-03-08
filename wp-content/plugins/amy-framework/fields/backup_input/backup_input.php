<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Backup Input
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Option_Backup_Input extends AmyFramework_Options {

	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();

		echo '<textarea name="' . $this->element_name() . '"' . $this->element_class() . $this->element_attributes() . '>' . $this->element_value() . '</textarea>';
		echo '<div class="amy-dropdown">';
		echo '<button type="button" class="button">' . __( 'Choose a Profile', 'amy-framework' ) . ' <i class="fa fa-caret-down"></i></button> ';
		echo '<ul class="amy-dropdown-menu">';
		echo amy_get_profiles();
		echo '</ul>';
		echo '</div>';
		echo '<small>( ' . __( 'copy-paste your backup string here', 'amy-framework' ) . ' )</small>';

		echo $this->element_after();
	}
}
