<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Text sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_sanitize_text' ) ) {
	function amy_sanitize_text( $value, $field ) {
		return wp_filter_nohtml_kses( $value );
	}

	add_filter( 'amy_sanitize_text', 'amy_sanitize_text', 10, 2 );
}

/**
 *
 * Textarea sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_sanitize_textarea' ) ) {
	function amy_sanitize_textarea( $value ) {
		global $allowedposttags;

		return wp_kses( $value, $allowedposttags );
	}

	add_filter( 'amy_sanitize_textarea', 'amy_sanitize_textarea' );
}

/**
 *
 * Checkbox sanitize
 * Do not touch, or think twice.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_sanitize_checkbox' ) ) {
	function amy_sanitize_checkbox( $value ) {
		if ( ! empty( $value ) && $value == 1 ) {
			$value	= true;
		}

		if ( empty( $value ) ) {
			$value = false;
		}

		return $value;
	}

	add_filter( 'amy_sanitize_checkbox', 'amy_sanitize_checkbox' );
	add_filter( 'amy_sanitize_switcher', 'amy_sanitize_checkbox' );
}

/**
 *
 * Image select sanitize
 * Do not touch, or think twice.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_sanitize_image_select' ) ) {
	function amy_sanitize_image_select( $value ) {
		if ( isset( $value ) && is_array( $value ) ) {
			if ( count( $value ) ) {
				$value	= $value;
			} else {
				$value	= $value[0];
			}
		} else if ( empty( $value ) ) {
			$value	= '';
		}

		return $value;
	}

	add_filter( 'amy_sanitize_image_select', 'amy_sanitize_image_select' );
}

/**
 *
 * Group sanitize
 * Do not touch, or think twice.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_sanitize_group' ) ) {
	function amy_sanitize_group( $value ) {
		return (empty( $value )) ? '' : $value;
	}

	add_filter( 'amy_sanitize_group', 'amy_sanitize_group' );
}

/**
 *
 * Title sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_sanitize_title' ) ) {
	function amy_sanitize_title( $value ) {
		return sanitize_title( $value );
	}

	add_filter( 'amy_sanitize_title', 'amy_sanitize_title' );
}

/**
 *
 * Text clean
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_sanitize_clean' ) ) {
	function amy_sanitize_clean( $value ) {
		return $value;
	}

	add_filter( 'amy_sanitize_clean', 'amy_sanitize_clean', 10, 2 );
}
