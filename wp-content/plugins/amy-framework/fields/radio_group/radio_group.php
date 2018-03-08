<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Radio
 *
 * @since 1.1.0
 * @version 1.0.0
 */
class AmyFramework_Option_Radio_Group extends AmyFramework_Options {
	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();

		if ( isset( $this->field['options'] ) ) {
			$options	= $this->field['options'];
			$options	= (is_array( $options )) ? $options : array_filter( $this->element_data( $options ) );
			if ( ! empty( $options ) ) {
				echo '<ul' . $this->element_class( 'amy-radio-group' ) . '>';
				foreach ( $options as $key => $value ) {
					echo '<li>';
					echo '<input type="radio" id="field_' . $this->field['id'] . '_' . $key . '" name="' . $this->element_name() . '" value="' . $key . '"' . $this->element_attributes( $key ) . $this->checked( $this->element_value(), $key ) . '/>';
					echo '<label for="field_' . $this->field['id'] . '_' . $key . '">' . $value . '</label>';
					echo '</li>';
				}
				echo '</ul>';
			}
		} else {
			$label	= (isset( $this->field['label'] )) ? $this->field['label'] : '';
			echo '<label><input type="radio" name="' . $this->element_name() . '" value="1"' . $this->element_class() . $this->element_attributes() . checked( $this->element_value(), 1, false ) . '/> ' . $label . '</label>';
		}

		echo $this->element_after();
	}
}
