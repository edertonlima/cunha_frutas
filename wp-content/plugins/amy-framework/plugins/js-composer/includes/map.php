<?php
defined( 'ABSPATH' ) or die;

amy_locate_template( 'plugins/js-composer/includes/helpers.php' );
amy_locate_template( 'plugins/js-composer/includes/params.php' );
amy_locate_template( 'plugins/js-composer/includes/extends.php' );

$options	= apply_filters( 'amy_framework_vc_map_options', array() );

foreach ( $options as $option ) {
	if ( $option ) {
		vc_map( $option );
	}
}
