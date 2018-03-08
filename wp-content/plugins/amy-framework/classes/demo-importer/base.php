<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined( 'ABSPATH' ) or die;

class Amy_Demo_Importer_Base {
	protected static $data;

	public function __construct( $data = null ) {
		self::$data		= $data;
	}
}
