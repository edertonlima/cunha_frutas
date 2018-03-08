<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined( 'ABSPATH' ) or die;

/**
 *
 * Field: Demo Importer
 *
 * @since 1.3.0
 * @version 1.0.0
 */
class AmyFramework_Option_Demo_Importer extends AmyFramework_Options {
	public function output() {
		amy_locate_template( 'classes/demo-importer/state.php' );

		echo $this->element_before();

		$condition		= isset( $this->field['condition'] ) ? $this->field['condition'] : '';
		$message		= isset( $this->field['message'] ) ? $this->field['message'] : '';
		$demos			= isset( $this->field['demos'] ) ? $this->field['demos'] : array();
		$installed_demo	= Amy_Demo_Importer_State::get_installed_demo();

		if ( ! $condition ) {
			echo $message;
		} else {
			?>

			<div class="amy-demo-importer">
				<?php foreach ( $demos as $demo ) :
					if ( $installed_demo === false ) {
						$class	= '';
					} else {
						$class	= $installed_demo == $demo['id'] ? ' amy-demo-installed' : ' amy-demo-disabled';
					}
				?>
					<div class="amy-demo amy-demo-<?php echo esc_attr( $demo['id'] ); ?><?php echo $class; ?>">
						<div class="amy-demo-overlay"></div>

						<div class="amy-demo-thumbnail">
							<img class="amy-demo-thumbnail-img" src="<?php echo esc_url( $demo['thumbnail'] ); ?>" alt="<?php echo esc_attr( $demo['title'] ); ?>" />
						</div>

						<div class="amy-demo-info">
							<h3><?php echo $demo['title']; ?></h3>

							<div class="amy-demo-actions">
								<a href="#" class="button button-primary amy-button-install-demo" data-demo-id="<?php echo esc_attr( $demo['id'] ); ?>">
									<?php echo esc_html__( 'Install', 'amy-framework' ); ?>
								</a>
								<a href="#" class="button button-primary amy-button-uninstall-demo" data-demo-id="<?php echo esc_attr( $demo['id'] ); ?>">
									<?php echo esc_html__( 'Uninstall', 'amy-framework' ); ?>
								</a>
								<p class="amy-demo-installed-msg"><?php echo esc_html__( 'Demo Installed!', 'amy-framework' ); ?></p>
							</div>
						</div>

						<div class="amy-demo-progress-bar-wrapper">
							<div class="amy-demo-progress-bar"></div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php
		}

		echo $this->element_after();
	}
}
