<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Notice
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Option_notice extends AmyFramework_Options {

	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();
		echo '<div class="amy-notice amy-' . $this->field['class'] . '">' . $this->field['content'] . '</div>';
		echo $this->element_after();
	}
}
