<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Style Builder Class
 * A helper class for build custom style.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Style_Builder {
	protected $styles	= array( 'all' => array() );

	public static function getInstance() {
		static $instance;

		if ( empty( $instance ) ) {
			$instance	= new AmyFramework_Style_Builder();
		}

		return $instance;
	}

	public function addStyle( $selectors, $styles, $media = 'all' ) {
		if ( ! is_array( $selectors ) ) {
			$selectors	= array( $selectors );
		}

		foreach ( $selectors as $selector ) {
			$selector	= trim( $selector );
			$styles		= trim( $styles );

			if ( ! empty( $selector ) && ! empty( $styles ) ) {
				if ( substr( $styles, -1 ) != ';' ) {
					$styles	.= ';';
				}

				if ( isset( $this->styles[ $media ] ) ) {
					if ( isset( $this->styles[ $media ][ $selector ] ) ) {
						$this->styles[ $media ][ $selector ]	.= ' ' . $styles;
					} else {
						$this->styles[ $media ][ $selector ]	= $styles;
					}
				} else {
					$this->styles[ $media ]	= array( $selector => $styles );
				}
			}
		}
	}

	public function render() {
		$css	= '';

		foreach ( $this->styles as $media => $rule ) {
			if ( $media != 'all' ) {
				$css .= $media . " {\n";
			}

			foreach ( $rule as $selector => $styles ) {
				$css	.= $selector . ' { ' . $styles . " }\n";
			}

			if ( $media != 'all' ) {
				$css .= "}\n";
			}
		}

		return $css;
	}
}
