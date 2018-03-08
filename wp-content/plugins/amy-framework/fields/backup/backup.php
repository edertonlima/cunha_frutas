<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Backup
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class AmyFramework_Option_backup extends AmyFramework_Options {

	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();

		echo '<textarea name="' . $this->unique . '[import]"' . $this->element_class() . $this->element_attributes() . '></textarea>';
		echo '<div class="amy-dropdown">';
		echo '<button type="button" class="button">' . __( 'Choose a Profile', 'amy-framework' ) . ' <i class="fa fa-caret-down"></i></button> ';
		echo '<ul class="amy-dropdown-menu">';
		echo amy_get_profiles();
		echo '</ul>';
		echo '</div>';
		submit_button( __( 'Import a Backup', 'amy-framework' ), 'primary amy-import-backup', 'backup', false );
		echo '<small>( ' . __( 'copy-paste your backup string here', 'amy-framework' ) . ' )</small>';

		echo '<hr />';

		echo '<textarea name="_nonce"' . $this->element_class() . $this->element_attributes() . ' disabled="disabled">' . amy_encode_string( get_option( $this->unique ) ) . '</textarea>';
		echo '<a href="#" class="amy-save-profile button button-primary">' . __( 'Save Profile' ) . '</a>';
		echo '<small>-( ' . __( 'or', 'amy-framework' ) . ' )-</small>';
		echo '<a href="' . admin_url( 'admin-ajax.php?action=amy-export-options' ) . '" class="button button-primary" target="_blank">' . __( 'Export and Download Backup', 'amy-framework' ) . '</a>';
		echo '<small>-( ' . __( 'or', 'amy-framework' ) . ' )-</small>';
		submit_button( __( 'Reset All Options', 'amy-framework' ), 'amy-warning-primary amy-reset-confirm', $this->unique . '[resetall]', false );
		echo '<small class="amy-text-warning">' . __( 'Please be sure for reset all of framework options.', 'amy-framework' ) . '</small>';
		echo $this->element_after();
	}
}
