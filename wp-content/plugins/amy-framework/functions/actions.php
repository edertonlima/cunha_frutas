<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Get icons from admin ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_get_icons' ) ) {
	function amy_get_icons() {
		do_action( 'amy_add_icons_before' );

		$jsons	= apply_filters( 'amy_add_icons_json', glob( AMY_DIR . '/fields/icon/*.json' ) );

		if ( ! empty( $jsons ) ) {
			foreach ( $jsons as $path ) {
				$object	= amy_get_icon_fonts( 'fields/icon/' . basename( $path ) );

				if ( is_object( $object ) ) {
					echo (count( $jsons ) >= 2) ? '<h4 class="amy-icon-title">' . $object->name . '</h4>' : '';

					foreach ( $object->icons as $icon ) {
						echo '<a class="amy-icon-tooltip" data-amy-icon="' . $icon . '" data-title="' . $icon . '"><span class="amy-icon amy-selector"><i class="' . $icon . '"></i></span></a>';
					}
				} else {
					echo '<h4 class="amy-icon-title">' . __( 'Error! Can not load json file.', 'amy-framework' ) . '</h4>';
				}
			}
		}

		do_action( 'amy_add_icons' );
		do_action( 'amy_add_icons_after' );

		die();
	}

	add_action( 'wp_ajax_amy-get-icons', 'amy_get_icons' );
}

/**
 *
 * Export options
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_export_options' ) ) {
	function amy_export_options() {
		header( 'Content-Type: plain/text' );
		header( 'Content-disposition: attachment; filename=backup-options-' . gmdate( 'd-m-Y' ) . '.txt' );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		echo amy_encode_string( get_option( AMY_OPTION ) );

		die();
	}

	add_action( 'wp_ajax_amy-export-options', 'amy_export_options' );
}

/**
 *
 * Set icons for wp dialog
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_set_icons' ) ) {
	function amy_set_icons() {
		echo '<div id="amy-icon-dialog" class="amy-dialog" title="' . __( 'Add Icon', 'amy-framework' ) . '">';
		echo '<div class="amy-dialog-header amy-text-center"><input type="text" placeholder="' . __( 'Search a Icon...', 'amy-framework' ) . '" class="amy-icon-search" /></div>';
		echo '<div class="amy-dialog-load"><div class="amy-icon-loading">' . __( 'Loading...', 'amy-framework' ) . '</div></div>';
		echo '</div>';
	}

	add_action( 'admin_footer', 'amy_set_icons' );
	add_action( 'customize_controls_print_footer_scripts', 'amy_set_icons' );
}

/**
 *
 * WP dialog for profile title
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_set_profiles' ) ) {
	function amy_set_profiles() {
		echo '<div id="amy-profile-dialog" class="amy-dialog" title="' . __( 'Save Profile', 'amy-framework' ) . '">';
		echo '<div class="amy-dialog-load">';
		echo amy_add_element(array(
			'id'	=> 'title',
			'type'	=> 'text',
			'title'	=> __( 'Profile Name', 'amy-framework' ),
			'after'	=> '<p class="amy-text-desc">' . __( 'Old profile with same name will be replaced...', 'amy-framework' ) . '</p>',
		));
		echo '</div>';
		echo '<div class="amy-insert-button"><button type="button" class="button button-primary amy-dialog-insert">' . __( 'Save Profile', 'amy-framework' ) . '</button></div>';
		echo '</div>';
	}

	add_action( 'admin_footer', 'amy_set_profiles' );
	add_action( 'customize_controls_print_footer_scripts', 'amy_set_profiles' );
}

/**
 *
 * Save profile
 *
 * @since 1.1.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_save_profile' ) ) {
	function amy_save_profile() {
		$title	= amy_get_var( 'title' );

		if ( $title ) {
			$profiles	= get_option( AMY_OPTION_PROFILE );
			$data		= amy_encode_string( get_option( AMY_OPTION ) );
			$replace	= false;

			if ( empty( $profiles ) ) {
				$profiles	= array();
			}

			foreach ( $profiles as $i => $old_profile ) {
				if ( $old_profile->name == $title ) {
					$old_profile->data	= $data;
					$profiles[ $i ]	= $old_profile;
					$replace			= true;

					break;
				}
			}

			if ( ! $replace ) {
				$profile		= new stdClass();
				$profile->name	= $title;
				$profile->data	= $data;

				$profiles[]		= $profile;
			}

			update_option( AMY_OPTION_PROFILE, $profiles );
		}

		echo amy_get_profiles();
		die();
	}

	add_action( 'wp_ajax_amy-save-profile', 'amy_save_profile' );
}

/**
 *
 * Remove profile
 *
 * @since 1.1.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_remove_profile' ) ) {
	function amy_remove_profile() {
		$id			= (int) amy_get_var( 'id' );

		$profiles	= get_option( AMY_OPTION_PROFILE );

		if ( isset( $profiles[ $id ] ) ) {
			unset( $profiles[ $id ] );

			$profiles	= array_values( $profiles );

			update_option( AMY_OPTION_PROFILE, $profiles );
		}

		echo amy_get_profiles();
		die();
	}

	add_action( 'wp_ajax_amy-remove-profile', 'amy_remove_profile' );
}

/**
 * Demo Importer
 *
 * @since 1.2.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_demo_importer_localize_script' ) ) {
	function amy_demo_importer_localize_script() {
		wp_localize_script('amy-framework', 'adiL10n', array(
			'install_demo_confirm'		=> __(
				"Install demo content:\n"
				. "-----------------------------------------\n"
				. "Are you sure? This will install demo content\n\n"
				. "Please backup your settings to be sure that you don't lose them by accident.\n\n\n"
			),
			'uninstall_demo_confirm'	=> __(
				"Uninstall demo content:\n"
				. "-----------------------------------------\n"
				. "Are you sure? This will remove all the installed content and settings and it will try to reverse your site to the previous state.\n\n\n"
			),
			'install_demo_error'		=> __( 'Error installing demo content!' ),
			'uninstall_demo_error'		=> __( 'Error uninstalling demo content!' ),
		));
	}

	add_action( 'admin_enqueue_scripts', 'amy_demo_importer_localize_script', 99 );
}

/**
 * Handle ajax demo importer.
 */
if ( ! function_exists( 'amy_demo_importer_action' ) ) {
	function amy_demo_importer_action() {
		if ( ! isset( $_POST['demo_id'] ) || ! isset( $_POST['amy_demo_importer_action'] ) || ! current_user_can( 'switch_themes' ) ) {
			die;
		}

		set_time_limit( 0 );

		amy_locate_template( 'classes/demo-importer/base.php' );
		amy_locate_template( 'classes/demo-importer/map.php' );
		amy_locate_template( 'classes/demo-importer/settings.php' );
		amy_locate_template( 'classes/demo-importer/post.php' );
		amy_locate_template( 'classes/demo-importer/term.php' );
		amy_locate_template( 'classes/demo-importer/state.php' );

		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';

			WP_Filesystem();
		}

		$action		= $_POST['amy_demo_importer_action'];
		$demo_id	= $_POST['demo_id'];
		$pni		= isset( $_POST['pni'] ) ? $_POST['pni'] : 0;

		if ( $action == 'uninstall' ) {
			(new Amy_Demo_Importer_Settings())->restore();
			(new Amy_Demo_Importer_Post())->remove();
			(new Amy_Demo_Importer_Term())->remove();

			do_action( 'amy_demo_importer_finish_uninstall' );

			Amy_Demo_Importer_Map::instance()->remove();
			Amy_Demo_Importer_State::update_state( '' );
		} else {
			// load data
			$data	= amy_demo_importer_load_data_file( $demo_id );

			if ( ! $data ) {
				echo 0;
				die;
			}

			switch ( $action ) {
				case 'install':
					Amy_Demo_Importer_State::update_state( $demo_id );

					$settings	= new Amy_Demo_Importer_Settings( $data );
					$settings->save();
					$settings->add();

					$response	= array(
						'next_action'	=> 'term',
						'progress'		=> 10,
					);

					break;
				case 'term':
					$term	= new Amy_Demo_Importer_Term( $data );
					$term->add();

					$response	= array(
						'next_action'	=> 'post',
						'progress'		=> 25,
					);

					break;
				case 'post':
					$time_out	= 5;	// 5s
					$start_time	= time();
					$index		= $pni;
					$post		= new Amy_Demo_Importer_Post( $data );

					do {
						$index		= $post->add_by_index( $index );
						$end_time	= time();
					} while ($index && $end_time - $start_time < $time_out);

					if ( $index ) {
						$response	= array(
							'next_action'	=> 'post',
							'pni'			=> $index,
							'progress'		=> 25 + intval( 40 * $index / count( $data->posts ) ),
						);
					} else {
						$response	= array(
							'next_action'	=> 'remap',
							'progress'		=> 65,
						);
					}

					break;
				case 'remap':
					(new Amy_Demo_Importer_Settings( $data ))->remap();
					(new Amy_Demo_Importer_Term( $data ))->remap();
					(new Amy_Demo_Importer_Post( $data ))->remap();

					$response	= array(
						'next_action'	=> 'finish',
						'progress'		=> 90,
					);

					break;
				case 'finish':
					do_action( 'amy_demo_importer_finish_install', $demo_id, $data );
					echo 1;
					die;
			}

			if ( isset( $response ) ) {
				echo json_encode( $response );
				die;
			} else {
				echo 0;
				die;
			}
		}
	}

	add_action( 'wp_ajax_amy_demo_importer_action', 'amy_demo_importer_action' );
}

/**
 * Load demo data file.
 */
if ( ! function_exists( 'amy_demo_importer_load_data_file' ) ) {
	function amy_demo_importer_load_data_file( $id ) {
		$file	= apply_filters( 'amy_demo_importer_get_data_file', '', $id );
		$theme	= apply_filters( 'amy_demo_importer_get_theme_name', get_template() );

		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';

			WP_Filesystem();
		}

		if ( $file ) {
			// check if file is url
			$regex	= '`^http(|s)://`';

			if ( preg_match( $regex, $file ) ) {
				$file_name	= basename( $file );

				// check if file was downloaded
				$local_path	= get_home_path() . '/wp-content/uploads/' . $theme . '/' . sanitize_title_with_dashes( $id ) . '/' . $file_name;

				if ( file_exists( $local_path ) ) {
					// compare file size
					$response   = wp_remote_head( $file );
					$size		= $response['headers']['content-length'];

					if ( $size != filesize( $local_path ) ) {
						// download file
						$response	= wp_remote_get( $file, array( 'timeout' => 1200 ) );
						$content	= $response['body'];

						$wp_filesystem->put_contents( $local_path, $content, 'w' );
					}
				} else {
					wp_mkdir_p( dirname( $local_path ) );

					// download file
					$response	= wp_remote_get( $file, array( 'timeout' => 1200 ) );
					$content	= $response['body'];

					$wp_filesystem->put_contents( $local_path, $content, 'w' );
				}
			} else {
				$local_path	= $file;
			}

			return json_decode( $wp_filesystem->get_contents( $local_path ) );
		}

		return null;
	}
}

/**
 * Custom Sidebars
 *
 * @since 1.2.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_custom_sidebar_add_form' ) ) {
	function amy_custom_sidebar_add_form() {
		if ( AMY_ACTIVE_CUSTOM_SIDEBAR ) {
			global $wp_version;
			?>

			<script type="text/html" id="tmpl-amy-add-widget">
				<div class="amy-widgets-holder-wrap">
					<?php if ( version_compare( $wp_version, '3.7.9', '>' ) == false ) : ?>
						<div class="sidebar-name">
							<h3><?php esc_html_e( 'Custom Widget Area', 'amy-framework' ); ?></h3>
						</div>
					<?php endif; ?>

					<form action="" method="post" class="amy-add-widget">
						<?php if ( version_compare( $wp_version, '3.7.9', '>' ) == true ) : ?>
							<div class="sidebar-name">
								<h3><?php esc_html_e( 'Custom Widget Area', 'amy-framework' ); ?></h3>
							</div>
						<?php endif; ?>

						<input type="text" name="amy-add-widget" value="" placeholder="<?php esc_html_e( 'Enter name of the new widget area here', 'amy-framework' ); ?>" required="required" />
						<?php submit_button( esc_html__( 'Add Widget Area', 'amy-framework' ), 'secondary large', 'amy-custom-sidebar-submit' ); ?>
						<input type="hidden" name="amy-delete-nonce" value="<?php echo wp_create_nonce( 'amy-delete-nonce' ); ?>" />
					</form>
				</div>
			</script>

			<?php
		}
	}

	add_action( 'admin_footer' , 'amy_custom_sidebar_add_form' );
}

if ( ! function_exists( 'amy_get_sidebar_name' ) ) {
	function amy_get_sidebar_name( $name ) {
		if ( empty( $GLOBALS['wp_registered_sidebars'] ) ) {
			return $name;
		}

		$sidebars	= get_option( 'amy_custom_sidebars' );
		$taken		= array();

		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$taken[]	= $sidebar['name'];
		}

		if ( empty( $sidebars ) ) {
			$sidebars	= array();
		}

		$taken	= array_merge( $taken, $sidebars );

		if ( in_array( $name, $taken ) ) {
			$counter 	= substr( $name, -1 );

			if ( ! is_numeric( $counter ) ) {
				$new_name	= $name . ' 1';
			} else {
				$new_name	= substr( $name, 0, -1 ) . ((int) $counter + 1);
			}

			$name = amy_get_sidebar_name( $new_name );
		}

		return $name;
	}
}

if ( ! function_exists( 'amy_custom_sidebar_action_load_widgets' ) ) {
	function amy_custom_sidebar_action_load_widgets() {
		if ( AMY_ACTIVE_CUSTOM_SIDEBAR ) {
			if ( ! empty( $_POST['amy-add-widget'] ) ) {
				$sidebars	= get_option( 'amy_custom_sidebars' );
				$name		= amy_get_sidebar_name( $_POST['amy-add-widget'] );

				$sidebars[ sanitize_title_with_dashes( $name ) ]	= $name;

				update_option( 'amy_custom_sidebars', $sidebars );
				wp_redirect( admin_url( 'widgets.php' ) );
				exit;
			}
		}
	}

	add_action( 'load-widgets.php', 'amy_custom_sidebar_action_load_widgets', 1000 );
}

if ( ! function_exists( 'amy_custom_sidebar_delete_sidebar' ) ) {
	function amy_custom_sidebar_delete_sidebar() {
		if ( AMY_ACTIVE_CUSTOM_SIDEBAR ) {
			check_ajax_referer( 'amy-delete-nonce' );

			if ( ! empty( $_POST['name'] ) ) {
				$name		= sanitize_title_with_dashes( stripslashes( $_POST['name'] ) );
				$sidebars	= get_option( 'amy_custom_sidebars' );

				if ( array_key_exists( $name, $sidebars ) ) {
					unset( $sidebars[ $name ] );
					update_option( 'amy_custom_sidebars', $sidebars );
					unregister_sidebar( $name );

					echo 'sidebar-deleted';
				}
			}

			exit();
		}
	}

	add_action( 'wp_ajax_amy_ajax_delete_custom_sidebar', 'amy_custom_sidebar_delete_sidebar', 1000 );
}
