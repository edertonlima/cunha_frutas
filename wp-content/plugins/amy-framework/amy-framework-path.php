<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Framework constants
 *
 * @since 1.0.0
 * @version 1.0.0
 */
defined( 'AMY_VERSION' ) or define( 'AMY_VERSION', '1.1.0' );
defined( 'AMY_OPTION' ) or define( 'AMY_OPTION', '_amy_options' );
defined( 'AMY_CUSTOMIZE' ) or define( 'AMY_CUSTOMIZE', '_amy_customize_options' );
defined( 'AMY_OPTION_PROFILE' ) or define( 'AMY_OPTION_PROFILE', '_amy_option_profiles' );

/**
 *
 * Framework path finder
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_path_locate' ) ) {
	function amy_get_path_locate() {
		$dirname		= wp_normalize_path( dirname( __FILE__ ) );
		$plugin_dir		= wp_normalize_path( WP_PLUGIN_DIR );
		$located_plugin	= (preg_match( '#' . $plugin_dir . '#', $dirname )) ? true : false;
		$directory		= ($located_plugin) ? $plugin_dir : get_template_directory();
		$directory_uri	= ($located_plugin) ? WP_PLUGIN_URL : get_template_directory_uri();
		$basename		= str_replace( wp_normalize_path( $directory ), '', $dirname );
		$dir			= $directory . $basename;
		$uri			= $directory_uri . $basename;

		return apply_filters('amy_get_path_locate', array(
			'basename'	=> wp_normalize_path( $basename ),
			'dir'		=> wp_normalize_path( $dir ),
			'uri'		=> $uri,
		));

	}
}

/**
 *
 * Framework set paths
 *
 * @since 1.0.0
 * @version 1.0.0
 */
$get_path	= amy_get_path_locate();

defined( 'AMY_BASENAME' ) or define( 'AMY_BASENAME', $get_path['basename'] );
defined( 'AMY_DIR' ) or define( 'AMY_DIR', $get_path['dir'] );
defined( 'AMY_URI' ) or define( 'AMY_URI', $get_path['uri'] );

/**
 *
 * Framework locate template and override files
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_locate_template' ) ) {
	function amy_locate_template( $template_name ) {
		$located		= '';
		$override		= apply_filters( 'amy_framework_override', 'inc' );
		$dir_plugin		= WP_PLUGIN_DIR;
		$dir_theme		= get_template_directory();
		$dir_child		= get_stylesheet_directory();
		$dir_override	= '/' . $override . '/' . $template_name;
		$dir_template	= AMY_BASENAME . '/' . $template_name;

		// child theme override
		$child_force_overide	= $dir_child . $dir_override;
		$child_normal_override	= $dir_child . $dir_template;

		// theme override paths
		$theme_force_override	= $dir_theme . $dir_override;
		$theme_normal_override	= $dir_theme . $dir_template;

		// plugin override
		$plugin_force_override	= $dir_plugin . $dir_override;
		$plugin_normal_override	= $dir_plugin . $dir_template;

		if ( file_exists( $child_force_overide ) ) {
			$located = $child_force_overide;
		} else if ( file_exists( $child_normal_override ) ) {
			$located = $child_normal_override;
		} else if ( file_exists( $theme_force_override ) ) {
			$located = $theme_force_override;
		} else if ( file_exists( $theme_normal_override ) ) {
			$located = $theme_normal_override;
		} else if ( file_exists( $plugin_force_override ) ) {
			$located = $plugin_force_override;
		} else if ( file_exists( $plugin_normal_override ) ) {
			$located = $plugin_normal_override;
		}

		$located = apply_filters( 'amy_locate_template', $located, $template_name );

		if ( ! empty( $located ) ) {
			load_template( $located, true );
		}

		return $located;
	}
}

/**
 *
 * Get image option
 *
 * @since	1.0.0
 * @version	1.0.0
 */
if ( ! function_exists( 'amy_get_image_option' ) ) {
	function amy_get_image_option( $option_name = '', $default = '', $type = '' ) {
		switch ( $type ) {
			case 'customize':
				$image_id	= amy_get_customize_option( $option_name );
				break;
			default:
				$image_id	= amy_get_option( $option_name );
		}

		if ( $image_id ) {
			if ( $image_src = wp_get_attachment_image_src( $image_id, 'full' ) ) {
				return $image_src[0];
			}
		}

		return ! empty( $default ) ? $default : null;
	}
}

/**
 *
 * Get option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_option' ) ) {
	function amy_get_option( $option_name = '', $default = '' ) {
		$options	= apply_filters( 'amy_get_option', get_option( AMY_OPTION ), $option_name, $default );

		if ( ! empty( $option_name ) && isset( $options[ $option_name ] ) && ($options[ $option_name ] || $options[ $option_name ] === '0' || $options[ $option_name ] === false) ) {
			return $options[ $option_name ];
		} else {
			return ( ! empty( $default )) ? $default : null;
		}
	}
}

/**
 *
 * Get fieldset image option
 *
 * @since	1.0.0
 * @version	1.0.0
 */
if ( ! function_exists( 'amy_get_fieldset_image_option' ) ) {
	function amy_get_fieldset_image_option( $option_name = '', $key = 'default', $default = '', $type = '' ) {
		$image_id	= null;
		$data		= array();

		switch ( $type ) {
			case 'customize':
				$data	= amy_get_customize_option( $option_name );
				break;
			default:
				$data	= amy_get_option( $option_name );
		}

		if ( isset( $data[ $key ] ) ) {
			$image_id	= $data[ $key ];
		}

		if ( $image_id ) {
			if ( $image_src = wp_get_attachment_image_src( $image_id, 'full' ) ) {
				return $image_src[0];
			}
		}

		return ! empty( $default ) ? $default : null;
	}
}

/**
 *
 * Get fieldset option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_fieldset_option' ) ) {
	function amy_get_fieldset_option( $option_name = '', $key = 'default', $default = '' ) {
		$data	= amy_get_option( $option_name );

		return isset( $data[ $key ] ) && ($data[ $key ] || $data[ $key ] === '0' || $data[ $key ] === false) ? $data[ $key ] : $default;
	}
}

/**
 *
 * Set option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_set_option' ) ) {
	function amy_set_option( $option_name = '', $new_value = '' ) {
		$options	= apply_filters( 'amy_set_option', get_option( AMY_OPTION ), $option_name, $new_value );

		if ( ! empty( $option_name ) ) {
			$options[ $option_name ]	= $new_value;
			update_option( AMY_OPTION, $options );
		}

	}
}

/**
 *
 * Get all option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_all_option' ) ) {
	function amy_get_all_option() {
		return get_option( AMY_OPTION );
	}
}

/**
 *
 * Multi language option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_multilang_option' ) ) {
	function amy_get_multilang_option( $option_name = '', $default = '' ) {
		$value		= amy_get_option( $option_name, $default );
		$languages	= amy_language_defaults();
		$default	= $languages['default'];
		$current	= $languages['current'];

		if ( is_array( $value ) && is_array( $languages ) && isset( $value[ $current ] ) ) {
			return $value[ $current ];
		} else if ( $default != $current ) {
			return '';
		}

		return $value;
	}
}

/**
 *
 * Multi language value
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_multilang_value' ) ) {
	function amy_get_multilang_value( $value = '', $default = '' ) {
		$languages	= amy_language_defaults();
		$default	= $languages['default'];
		$current	= $languages['current'];

		if ( is_array( $value ) && is_array( $languages ) && isset( $value[ $current ] ) ) {
			return $value[ $current ];
		} else if ( $default != $current ) {
			return '';
		}

		return $value;
	}
}

/**
 *
 * Get customize option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_customize_option' ) ) {
	function amy_get_customize_option( $option_name = '', $default = '' ) {
		$options	= apply_filters( 'amy_get_customize_option', get_option( AMY_CUSTOMIZE ), $option_name, $default );

		if ( ! empty( $option_name ) && ! empty( $options[ $option_name ] ) ) {
			return $options[ $option_name ];
		} else {
			return ( ! empty( $default )) ? $default : null;
		}

	}
}

/**
 *
 * Set customize option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_set_customize_option' ) ) {
	function amy_set_customize_option( $option_name = '', $new_value = '' ) {
		$options	= apply_filters( 'amy_set_customize_option', get_option( AMY_CUSTOMIZE ), $option_name, $new_value );

		if ( ! empty( $option_name ) ) {
			$options[ $option_name ] = $new_value;
			update_option( AMY_CUSTOMIZE, $options );
		}

	}
}

/**
 *
 * Get all customize option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_all_customize_option' ) ) {
	function amy_get_all_customize_option() {
		return get_option( AMY_CUSTOMIZE );
	}
}

/**
 *
 * WPML plugin is activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_is_wpml_activated' ) ) {
	function amy_is_wpml_activated() {
		if ( class_exists( 'SitePress' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 *
 * qTranslate plugin is activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_is_qtranslate_activated' ) ) {
	function amy_is_qtranslate_activated() {
		if ( function_exists( 'qtranxf_getSortedLanguages' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 *
 * Polylang plugin is activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_is_polylang_activated' ) ) {
	function amy_is_polylang_activated() {
		if ( class_exists( 'Polylang' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 *
 * Get language defaults
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_language_defaults' ) ) {
	function amy_language_defaults() {
		$multilang	= array();

		if ( amy_is_wpml_activated() || amy_is_qtranslate_activated() || amy_is_polylang_activated() ) {
			if ( amy_is_wpml_activated() ) {
				global $sitepress;

				$multilang['default']	= $sitepress->get_default_language();
				$multilang['current']	= $sitepress->get_current_language();
				$multilang['languages']	= $sitepress->get_active_languages();
			} else if ( amy_is_polylang_activated() ) {
				global $polylang;

				$current	= pll_current_language();
				$default	= pll_default_language();
				$current	= (empty( $current )) ? $default : $current;
				$poly_langs	= $polylang->model->get_languages_list();
				$languages	= array();

				foreach ( $poly_langs as $p_lang ) {
					$languages[ $p_lang->slug ]	= $p_lang->slug;
				}

				$multilang['default']	= $default;
				$multilang['current']	= $current;
				$multilang['languages']	= $languages;
			} else if ( amy_is_qtranslate_activated() ) {
				global $q_config;

				$multilang['default']	= $q_config['default_language'];
				$multilang['current']	= $q_config['language'];
				$multilang['languages']	= array_flip( qtranxf_getSortedLanguages() );
			}
		}

		$multilang	= apply_filters( 'amy_language_defaults', $multilang );

		return ( ! empty( $multilang )) ? $multilang : false;

	}
}

/**
 *
 * Visual Composer plugin is activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_is_vc_activated' ) ) {
	function amy_is_vc_activated() {
		if ( class_exists( 'Vc_Manager' ) && defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, '4.2.3', '>=' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 *
 * Get locate for load textdomain
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_locale' ) ) {
	function amy_get_locale() {
		global $locale, $wp_local_package;

		if ( isset( $locale ) ) {
			return apply_filters( 'locale', $locale );
		}

		if ( isset( $wp_local_package ) ) {
			$locale	= $wp_local_package;
		}

		if ( defined( 'WPLANG' ) ) {
			$locale	= WPLANG;
		}

		if ( is_multisite() ) {
			if ( defined( 'WP_INSTALLING' ) || (false === $ms_locale = get_option( 'WPLANG' )) ) {
				$ms_locale	= get_site_option( 'WPLANG' );
			}

			if ( $ms_locale !== false ) {
				$locale	= $ms_locale;
			}
		} else {

			$db_locale	= get_option( 'WPLANG' );

			if ( $db_locale !== false ) {
				$locale	= $db_locale;
			}
		}

		if ( empty( $locale ) ) {
			$locale	= 'en_US';
		}

		return apply_filters( 'locale', $locale );
	}
}

/**
 *
 * Framework load text domain
 *
 * @since 1.0.0
 * @version 1.0.0
 */
load_textdomain( 'amy-framework', AMY_DIR . '/languages/' . amy_get_locale() . '.mo' );
