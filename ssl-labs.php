<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.1
 * @package           SSL_Labs
 *
 * @wordpress-plugin
 * Plugin Name:       SSL Quality Checker
 * Plugin URI:        https://www.createful.com
 * Description:       Ensure your server meets the correct SSL quality
 * Version:           1.0.6
 * Author:            Createful
 * Author URI:        https://www.createful.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ssl-labs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register autoloader
spl_autoload_register( 'plugin_name_autoloader' );
function plugin_name_autoloader( $class_name ) {
    if ( strpos( $class_name, 'SSL_Labs_Admin' ) !== false) {
        $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
        $class_file = str_replace('SSL_Labs_Admin_','',$class_name);
        $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_file ). '.php';
        require_once $classes_dir . $class_file;
    }
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ssl-labs-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ssl-labs-activator.php';
	SSL_Labs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ssl-labs-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ssl-labs-deactivator.php';
	SSL_Labs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ssl-labs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new SSL_Labs();
	$plugin->run();

}
run_plugin_name();
