<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Image
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Option_Image extends AmyFramework_Options {

	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();

		$preview	= '';
		$value		= $this->element_value();
		$add		= ( ! empty( $this->field['add_title'] )) ? $this->field['add_title'] : __( 'Add Image', 'amy-framework' );
		$hidden		= (empty( $value )) ? ' hidden' : '';

		if ( ! empty( $value ) ) {
			$attachment	= wp_get_attachment_image_src( $value, 'thumbnail' );
			$preview	= $attachment[0];
		}

		echo '<div class="amy-image-preview' . $hidden . '"><div class="amy-preview"><i class="fa fa-times amy-remove"></i><img src="' . $preview . '" alt="preview" /></div></div>';
		echo '<a href="#" class="button button-primary amy-add">' . $add . '</a>';
		echo '<input type="text" name="' . $this->element_name() . '" value="' . $this->element_value() . '"' . $this->element_class() . $this->element_attributes() . '/>';

		echo $this->element_after();
	}
}
