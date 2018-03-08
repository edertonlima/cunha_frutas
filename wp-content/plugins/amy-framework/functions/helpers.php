<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Add framework element
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_add_element' ) ) {
	function amy_add_element( $field = array(), $value = '', $unique = '' ) {
		$output		= '';
		$depend		= '';
		$sub		= (isset( $field['sub'] )) ? 'sub-' : '';
		$unique		= (isset( $unique )) ? $unique : '';
		$languages	= amy_language_defaults();
		$class		= 'AmyFramework_Option_' . $field['type'];
		$wrap_class	= (isset( $field['wrap_class'] )) ? ' ' . $field['wrap_class'] : '';
		$el_class	= isset( $field['title'] ) ? sanitize_title( $field['title'] ) : 'no-title';
		$hidden		= (isset( $field['show_only_language'] ) && ($field['show_only_language'] != $languages['current'])) ? ' hidden' : '';
		$is_pseudo	= (isset( $field['pseudo'] )) ? ' amy-pseudo-field' : '';

		if ( isset( $field['dependency'] ) ) {
			$hidden	= ' hidden';
			$depend	.= ' data-' . $sub . 'controller="' . $field['dependency'][0] . '"';
			$depend	.= ' data-' . $sub . 'condition="' . $field['dependency'][1] . '"';
			$depend	.= ' data-' . $sub . 'value="' . $field['dependency'][2] . '"';
		}
		$output			.= '<div class="amy-element amy-element-' . $el_class . ' amy-field-' . $field['type'] . $is_pseudo . $wrap_class . $hidden . '"' . $depend . '>';

		if ( isset( $field['title'] ) ) {
			$field_desc	= (isset( $field['desc'] )) ? '<p class="amy-text-desc">' . $field['desc'] . '</p>' : '';
			$output		.= '<div class="amy-title"><h4>' . $field['title'] . '</h4>' . $field_desc . '</div>';
		}

		$output	.= (isset( $field['title'] )) ? '<div class="amy-fieldset">' : '';

		$value	= ( ! isset( $value ) && isset( $field['default'] )) ? $field['default'] : $value;
		$value	= (isset( $field['value'] )) ? $field['value'] : $value;

		if ( class_exists( $class ) ) {
			ob_start();

			$element	= new $class($field, $value, $unique);
			$element->output();
			$output		.= ob_get_clean();
		} else {
			$output .= '<p>' . __( 'This field class is not available!', 'amy-framework' ) . '</p>';
		}

		$output	.= (isset( $field['title'] )) ? '</div>' : '';
		$output	.= '<div class="clear"></div>';
		$output	.= '</div>';

		return $output;
	}
}

/**
 *
 * Encode string for backup options
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_encode_string' ) ) {
	function amy_encode_string( $string ) {
		return rtrim( strtr( call_user_func( 'base' . '64' . '_encode', addslashes( gzcompress( serialize( $string ), 9 ) ) ), '+/', '-_' ), '=' );
	}
}

/**
 *
 * Decode string for backup options
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_decode_string' ) ) {
	function amy_decode_string( $string ) {
		return unserialize( gzuncompress( stripslashes( call_user_func( 'base' . '64' . '_decode', rtrim( strtr( $string, '-_', '+/' ), '=' ) ) ) ) );
	}
}

/**
 *
 * Get google font from json file
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_google_fonts' ) ) {
	function amy_get_google_fonts() {
		global $amy_google_fonts;

		if ( ! empty( $amy_google_fonts ) ) {
			return $amy_google_fonts;
		} else {
			ob_start();
			amy_locate_template( 'fields/typography/google-fonts.json' );

			$json				= ob_get_clean();
			$amy_google_fonts	= json_decode( $json );

			return $amy_google_fonts;
		}
	}
}

/**
 *
 * Get icon fonts from json file
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_icon_fonts' ) ) {
	function amy_get_icon_fonts( $file ) {
		ob_start();
		amy_locate_template( $file );

		$json	= ob_get_clean();

		return json_decode( $json );
	}
}

/**
 *
 * Array search key & value
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_array_search' ) ) {
	function amy_array_search( $array, $key, $value ) {
		$results	= array();

		if ( is_array( $array ) ) {
			if ( isset( $array[ $key ] ) && $array[ $key ] == $value ) {
				$results[]	= $array;
			}

			foreach ( $array as $sub_array ) {
				$results	= array_merge( $results, amy_array_search( $sub_array, $key, $value ) );
			}
		}

		return $results;
	}
}

/**
 *
 * Getting POST Var
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_var' ) ) {
	function amy_get_var( $var, $default = '' ) {
		if ( isset( $_POST[ $var ] ) ) {
			return $_POST[ $var ];
		}

		if ( isset( $_GET[ $var ] ) ) {
			return $_GET[ $var ];
		}

		return $default;
	}
}

/**
 *
 * Getting POST Vars
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_vars' ) ) {
	function amy_get_vars( $var, $depth, $default = '' ) {
		if ( isset( $_POST[ $var ][ $depth ] ) ) {
			return $_POST[ $var ][ $depth ];
		}

		if ( isset( $_GET[ $var ][ $depth ] ) ) {
			return $_GET[ $var ][ $depth ];
		}

		return $default;
	}
}

/**
 *
 * Load options fields
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_load_option_fields' ) ) {
	function amy_load_option_fields() {
		$located_fields	= array();

		foreach ( glob( AMY_DIR . '/fields/*/*.php' ) as $amy_field ) {
			$located_fields[]	= basename( $amy_field );
			amy_locate_template( str_replace( AMY_DIR, '', $amy_field ) );
		}

		$override_name	= apply_filters( 'amy_framework_override', 'inc' );
		$override_dir	= get_template_directory() . '/' . $override_name . '/fields';

		if ( is_dir( $override_dir ) ) {
			foreach ( glob( $override_dir . '/*/*.php' ) as $override_field ) {
				if ( ! in_array( basename( $override_field ), $located_fields ) ) {
					amy_locate_template( str_replace( $override_dir, '/fields', $override_field ) );
				}
			}
		}

		do_action( 'amy_load_option_fields' );
	}
}

/**
 *
 * Load profiles
 *
 * @since 1.1.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_profiles' ) ) {
	function amy_get_profiles() {
		$profiles	= get_option( AMY_OPTION_PROFILE );

		if ( empty( $profiles ) ) {
			$html	= '<li><a href="#">' . __( 'No profile saved...', 'amy-framework' ) . '</a></li>';
		} else {
			$html	= '';

			foreach ( $profiles as $id => $profile ) {
				$html	.= '<li><a href="#" class="amy-profile-select" data-profile="' . esc_html( $profile->data ) . '">' . $profile->name
					. '</a><a href="' . admin_url( 'admin-ajax.php?action=amy-remove-profile&profile=' . (int) $id ) . '" class="amy-profile-remove">&times;</a></li>';
			}
		}

		return $html;
	}
}
