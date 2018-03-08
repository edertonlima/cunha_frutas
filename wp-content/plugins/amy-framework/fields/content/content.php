<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Content
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Option_content extends AmyFramework_Options {

	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();
		echo $this->field['content'];
		echo $this->element_after();
	}
}
