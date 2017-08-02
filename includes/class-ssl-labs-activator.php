<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    SSL_Labs
 * @subpackage SSL_Labs/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    SSL_Labs
 * @subpackage SSL_Labs/includes
 * @author     Your Name <email@example.com>
 */
class SSL_Labs_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        SSL_Labs_Option::update_option('cronschedule','weekly');
        SSL_Labs_Option::update_option('expected_grade','A+');

	}

}
