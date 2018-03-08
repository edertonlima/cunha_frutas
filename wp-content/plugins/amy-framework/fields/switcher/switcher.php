<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Switcher
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Option_switcher extends AmyFramework_Options {

	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();
		$label = (isset( $this->field['label'] )) ? '<div class="amy-text-desc">' . $this->field['label'] . '</div>' : '';
		echo '<label><input type="checkbox" name="' . $this->element_name() . '" value="1"' . $this->element_class() . $this->element_attributes() . checked( $this->element_value(), 1, false ) . '/><em data-on="' . __( 'on', 'amy-framework' ) . '" data-off="' . __( 'off', 'amy-framework' ) . '"></em><span></span></label>' . $label;
		echo $this->element_after();
	}
}
