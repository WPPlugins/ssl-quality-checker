<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    SSL_Labs
 * @subpackage SSL_Labs/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    SSL_Labs
 * @subpackage SSL_Labs/includes
 * @author     Your Name <email@example.com>
 */
class SSL_Labs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      SSL_Labs_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'ssl-labs';
		$this->version = '1.0.5';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();



	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - SSL_Labs_Loader. Orchestrates the hooks of the plugin.
	 * - SSL_Labs_i18n. Defines internationalization functionality.
	 * - SSL_Labs_Admin. Defines all hooks for the dashboard.
	 * - SSL_Labs_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ssl-labs-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ssl-labs-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ssl-labs-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ssl-labs-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ssl-labs-option.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ssl-labs-callback-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ssl-labs-meta-box.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ssl-labs-sanitization-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ssl-labs-settings-definition.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ssl-labs-settings.php';

		$this->loader = new SSL_Labs_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the SSL_Labs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new SSL_Labs_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new SSL_Labs_Admin( $this->get_plugin_name(), $this->get_version() );


		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		// Add the options page and menu item.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_name . '.php' );
		$this->loader->add_action( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Built the option page
		$settings_callback = new SSL_Labs_Callback_Helper( $this->plugin_name );
		$settings_sanitization = new SSL_Labs_Sanitization_Helper( $this->plugin_name );
		$plugin_settings = new SSL_Labs_Settings( $this->get_plugin_name(), $settings_callback, $settings_sanitization);
		$this->loader->add_action( 'admin_init' , $plugin_settings, 'register_settings' );

		$plugin_meta_box = new SSL_Labs_Meta_Box( $this->get_plugin_name() );
		$this->loader->add_action( 'load-toplevel_page_' . $this->get_plugin_name() , $plugin_meta_box, 'add_meta_boxes' );

        // add admin notices
        $this->loader->add_action( 'admin_notices', $plugin_admin, 'show_admin_notice' );

        // admin ajax call for check status
        $this->loader->add_action( 'wp_ajax_ssl_check_status', $plugin_admin, 'ssl_check_status' );

        //cron job
        $this->loader->add_action( 'cron_check_ssl_status', $plugin_admin, 'cron_check_status' );

        // action to ignore notice
        $this->loader->add_action('wp_ajax_ignore_ssl_notice', $plugin_admin, 'ignore_ssl_notice');

		// action to set cron settings
		$this->loader->add_action('update_option_ssl_quality_checker_settings', $plugin_admin, 'update_cron_schedule', 10 , 2);

		// add additional time intervals to cron
		$this->loader->add_filter('cron_schedules', $plugin_admin, 'add_new_intervals');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new SSL_Labs_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

        if($this->get_version() > SSL_Labs_Option::get_option('version') || SSL_Labs_Option::get_option('version') == ''){
            $this->do_upgrade();
        }
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    SSL_Labs_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

    public function do_upgrade(){
        SSL_Labs_Option::update_option('domain','');
        SSL_Labs_Option::update_option('version',$this->get_version());
        SSL_Labs_Option::update_option('email_site_admin',0);
    }

}
