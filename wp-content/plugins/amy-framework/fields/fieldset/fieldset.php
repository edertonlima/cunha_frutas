<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Fieldset
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Option_fieldset extends AmyFramework_Options {

	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();
		echo '<div class="' . (isset( $this->field['inline'] ) && $this->field['inline'] ? 'amy-inline' : 'amy-inner') . '">';

		foreach ( $this->field['fields'] as $field ) {
			$field_id		= (isset( $field['id'] )) ? $field['id'] : '';
			$field_default	= isset( $field['default'] ) ? $field['default'] : '';
			$field_value	= (isset( $this->value[ $field_id ] )) ? $this->value[ $field_id ] : $field_default;
			$unique_id		= $this->unique . '[' . $this->field['id'] . ']';

			if ( ! empty( $this->field['un_array'] ) ) {
				echo amy_add_element( $field, amy_get_option( $field_id ), $this->unique );
			} else {
				echo amy_add_element( $field, $field_value, $unique_id );
			}
		}

		echo '</div>';

		echo $this->element_after();
	}
}
