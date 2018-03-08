<?php
defined( 'ABSPATH' ) or die;

class AmyFramework_Mega_Menu extends AmyFramework_Abstract {
	public $extra_fields	= array(
		'highlight',
		'highlight_type',
		'icon',
		'mega',
		'mega_width',
		'mega_position',
		'mega_custom_width',
		'column_title',
		'column_title_link',
		'column_width',
		'content',
	);
	public $walker			= null;

	public function __construct() {
		$this->addFilter( 'wp_nav_menu_args', 'wp_nav_menu_args', 99 );
		$this->addFilter( 'wp_edit_nav_menu_walker', 'wp_edit_nav_menu_walker', 10, 2 );
		$this->addFilter( 'wp_setup_nav_menu_item', 'wp_setup_nav_menu_item', 10, 1 );

		$this->addAction( 'wp_update_nav_menu_item', 'wp_update_nav_menu_item', 10, 3 );
		$this->addAction( 'amy_mega_menu_fields', 'amy_mega_menu_fields', 10, 2 );
		$this->addAction( 'amy_mega_menu_labels', 'amy_mega_menu_labels' );
	}

	/**
	 * Menu Menu Fields
	 */
	public function amy_mega_menu_fields( $item_id, $item ) {
		?>
		<p class="field-highlight description description-thin">
			<label for="edit-menu-item-highlight-<?php echo $item_id; ?>">
				<?php _e( 'Highlight', 'amy-framework' ); ?><br/>
				<input type="text" id="edit-menu-item-highlight-<?php echo $item_id; ?>" class="widefat code edit-menu-item-highlight" name="menu-item-highlight[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->highlight ); ?>" />
			</label>
		</p>

		<p class="field-highlight-type description description-thin">
			<label for="edit-menu-item-highlight-type-<?php echo $item_id; ?>">
				<?php _e( 'Highlight Type', 'amy-framework' ); ?><br/>
				<select id="edit-menu-item-highlight-type-<?php echo $item_id; ?>" name="menu-item-highlight_type[<?php echo $item_id; ?>]">
					<option value=""><?php _e( 'default', 'amy-framework' ); ?></option>

					<?php
					foreach ( array( 'info', 'success', 'warning', 'danger' ) as $highlight ) {
						echo '<option value="' . $highlight . '"' . selected( $highlight, $item->highlight_type ) . '>' . $highlight . '</option>';
					}
					?>
				</select>
			</label>
		</p>

		<div class="field-icon description description-wide">
			<?php
			$hidden	= (empty( $item->icon )) ? ' hidden' : '';
			$icon	= ( ! empty( $item->icon )) ? ' class="' . ($item->icon) . '"' : '';
			?>

			<div class="amy-field amy-field-icon">
				<div class="amy-icon-select">
					<span class="amy-icon-preview<?php echo $hidden; ?>"><i<?php echo $icon; ?>></i></span>
					<button class="button button-primary amy-icon-add"><?php _e( 'Add Icon', 'amy-framework' ); ?></button>
					<button class="button amy-warning-primary amy-icon-remove<?php echo $hidden; ?>"><?php _e( 'Remove Icon', 'amy-framework' ); ?></button>
					<input type="hidden" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo $item->icon; ?>" class="widefat code edit-menu-item-icon icon-value"/>
				</div>
			</div>
		</div>

		<div class="amy-mega-menu">
			<div class="field-mega">
				<label for="edit-menu-item-mega-<?php echo $item_id; ?>">
					<input type="checkbox" class="is-mega" id="edit-menu-item-mega-<?php echo $item_id; ?>" value="mega" name="menu-item-mega[<?php echo $item_id; ?>]"<?php checked( $item->mega, 'mega' ); ?> />
					<?php _e( 'Mega Menu', 'amy-framework' ); ?>
				</label>
			</div>

			<div class="field-mega-width">
				<select id="edit-menu-item-mega_width-<?php echo $item_id; ?>" name="menu-item-mega_width[<?php echo $item_id; ?>]" class="is-width">
					<option value=""><?php _e( 'Full Width', 'amy-framework' ); ?></option>

					<?php
					$mega_width	= array(
						'natural'	=> __( 'Natural Width', 'amy-framework' ),
						'custom'	=> __( 'Custom Width', 'amy-framework' ),
					);

					foreach ( $mega_width as $key => $value ) {
						echo '<option value="' . $key . '"' . selected( $key, $item->mega_width ) . '>' . $value . '</option>';
					}
					?>
				</select>
			</div>

			<div class="mega-depend-width hidden">
				<p class="description">
					<label for="edit-menu-item-mega_custom_width<?php echo $item_id; ?>">
						<?php _e( 'Custom Mega Menu Width (without px)', 'amy-framework' ); ?><br/>
						<input type="text" id="edit-menu-item-mega_custom_width<?php echo $item_id; ?>" class="widefat code edit-menu-item-mega_custom_width" name="menu-item-mega_custom_width[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->mega_custom_width ); ?>" />
					</label>
				</p>
			</div>

			<div class="mega-depend-position hidden">
				<p class="description">
					<label for="edit-menu-item-mega_position<?php echo $item_id; ?>">
						<input type="checkbox" id="edit-menu-item-mega_position<?php echo $item_id; ?>" value="1" name="menu-item-mega_position[<?php echo $item_id; ?>]"<?php checked( $item->mega_position, 1 ); ?> />
						<?php _e( 'Mega Right Position (optional)', 'amy-framework' ); ?>
					</label>
				</p>
			</div>

			<div class="clear"></div>
		</div>

		<div class="amy-mega-column">

			<p class="field-column description description-thin">
				<label for="edit-menu-item-column-title-<?php echo $item_id; ?>">
					<input type="checkbox" id="edit-menu-item-column-title-<?php echo $item_id; ?>" value="1" name="menu-item-column_title[<?php echo $item_id; ?>]"<?php checked( $item->column_title, 1 ); ?> />
					<?php _e( 'Disable Title', 'amy-framework' ); ?>
				</label>
			</p>

			<p class="field-column description description-thin amy-last">
				<label for="edit-menu-item-column-title-link-<?php echo $item_id; ?>">
					<input type="checkbox" id="edit-menu-item-column-title-link-<?php echo $item_id; ?>" value="1" name="menu-item-column_title_link[<?php echo $item_id; ?>]"<?php checked( $item->column_title_link, 1 ); ?> />
					<?php _e( 'Disable Title Link', 'amy-framework' ); ?>
				</label>
			</p>

			<p class="field-column description">
				<select id="edit-menu-item-column_width-<?php echo $item_id; ?>" name="menu-item-column_width[<?php echo $item_id; ?>]">
					<option value=""><?php _e( 'Custom column width (optional)', 'amy-framework' ); ?></option>

					<?php
					$column_width	= array(
						'col-md-1'		=> '1 Col',
						'col-md-2'		=> '2 Col',
						'col-md-3'		=> '3 Col',
						'col-md-4'		=> '4 Col',
						'col-md-5'		=> '5 Col',
						'col-md-6'		=> '6 Col (half)',
						'col-md-7'		=> '7 Col',
						'col-md-8'		=> '8 Col',
						'col-md-9'		=> '9 Col',
						'col-md-10'		=> '10 Col',
						'col-md-11'		=> '11 Col',
						'col-md-12'		=> '12 Col (full-width)',
					);

					foreach ( $column_width as $key => $value ) {
						echo '<option value="' . $key . '"' . selected( $key, $item->column_width ) . '>' . $value . '</option>';
					}
					?>
				</select>
			</p>

			<div class="clear"></div>
		</div>

		<p class="field-content description description-wide">
			<label for="edit-menu-item-content-<?php echo $item_id; ?>">
				Description ( and can be used any shortcode )<br/>
				<textarea id="edit-menu-item-content-<?php echo $item_id; ?>" class="widefat edit-menu-item-content" rows="3" cols="20" name="menu-item-content[<?php echo $item_id; ?>]"><?php echo $item->content; ?></textarea>
			</label>
		</p>

		<div class="clear"></div>
		<?php
	}

	public function amy_mega_menu_labels() {
		$out	= '<span class="item-mega"><span class="amy-label amy-label-primary">Mega Menu</span></span>';
		$out	.= '<span class="item-mega-column"><span class="amy-label amy-label-success">Column</span></span>';

		echo $out;
	}

	/**
	 *
	 * Custom Menu Args
	 */
	public function wp_nav_menu_args( $args ) {
		$location = $args['theme_location'];

		if ( ($location == 'primary' || $location == 'primary-left' || $location == 'primary-right' || $location == 'right') && ! isset( $args['mobile'] ) ) {
			$header = amy_get_option( 'header_style' );

			$walker				= new AmyFramework_Walker_Nav_Menu();
			$args['container']	= false;
			$args['menu_class']	= ( ! empty( $args['menu_class'] ) ? $args['menu_class'] . ' ' : '') . 'main-navigation sf-menu';
			$args['walker']		= $walker;

			if ( ($location == 'primary' && $header != 'fancy') || ($location == 'right' && $header == 'fancy') ) {
				$args['items_wrap'] = $walker->custom_wrap();
			}
		} else if ( isset( $args['mobile'] ) || $location == 'mobile' ) {

		}

		return $args;
	}

	/**
	 *
	 * Custom Nav Menu Edit
	 */
	public function wp_edit_nav_menu_walker( $walker, $menu_id ) {
		return 'AmyFramework_Walker_Nav_Menu_Edit';
	}

	/**
	 *
	 * Save Custom Fields
	 */
	public function wp_setup_nav_menu_item( $item ) {
		foreach ( $this->extra_fields as $key ) {
			$item->$key	= get_post_meta( $item->ID, '_menu_item_' . $key, true );
		}

		return $item;
	}

	/**
	 *
	 * Update Custom Fields
	 */
	public function wp_update_nav_menu_item( $menu_id, $menu_item_db_id, $args ) {
		foreach ( $this->extra_fields as $key ) {
			$value	= (isset( $_REQUEST[ 'menu-item-' . $key ][ $menu_item_db_id ] )) ? $_REQUEST[ 'menu-item-' . $key ][ $menu_item_db_id ] : '';

			update_post_meta( $menu_item_db_id, '_menu_item_' . $key, $value );
		}
	}
}

new AmyFramework_Mega_Menu();
