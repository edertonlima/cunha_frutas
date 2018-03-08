<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Icon
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Option_icon extends AmyFramework_Options {

	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();

		$value	= $this->element_value();
		$hidden	= (empty( $value )) ? ' hidden' : '';

		echo '<div class="amy-icon-select">';
		echo '<span class="amy-icon-preview' . $hidden . '"><i class="' . $value . '"></i></span>';
		echo '<a href="#" class="button button-primary amy-icon-add">' . __( 'Add Icon', 'amy-framework' ) . '</a>';
		echo '<a href="#" class="button amy-warning-primary amy-icon-remove' . $hidden . '">' . __( 'Remove Icon', 'amy-framework' ) . '</a>';
		echo '<input type="text" name="' . $this->element_name() . '" value="' . $value . '"' . $this->element_class( 'amy-icon-value' ) . $this->element_attributes() . ' />';
		echo '</div>';

		echo $this->element_after();
	}
}
