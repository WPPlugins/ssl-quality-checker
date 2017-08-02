<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.2
 *
 * @package    SSL_Labs
 * @subpackage SSL_Labs/admin
 */
/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    SSL_Labs
 * @subpackage SSL_Labs/admin
 * @author     Your Name <email@example.com>
 */

class SSL_Labs_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}


    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ssl_Labs_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ssl_Labs_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ssl-labs-admin.css', array(), $this->version, 'all' );

        wp_enqueue_script( 'postbox' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ssl_Labs_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ssl_Labs_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ssl-labs-admin.js', array( 'jquery' ), $this->version, false );

    }

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		add_menu_page(
			__( 'SSL Quality Checker', $this->plugin_name ),
			__( 'SSL Quality Checker', $this->plugin_name ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_plugin_admin_page' ),
            'dashicons-lock'
			);

		$tabs = SSL_Labs_Settings_Definition::get_tabs();

		foreach ( $tabs as $tab_slug => $tab_title ) {

			add_submenu_page(
				$this->plugin_name,
				$tab_title,
				$tab_title,
				'manage_options',
				$this->plugin_name . '&tab=' . $tab_slug,
				array( $this, 'display_plugin_admin_page' )
				);
		}

        add_submenu_page(
            $this->plugin_name,
            __( 'View Status', $this->plugin_name ),
            __( 'View Status', $this->plugin_name ),
            'manage_options',
            $this->plugin_name . "-view-status",
            array( $this, 'display_status_page' )
        );

		remove_submenu_page( $this->plugin_name, $this->plugin_name );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 * @return   array 			Action links
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>'
				),
			$links
			);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {

		$tabs = SSL_Labs_Settings_Definition::get_tabs();

		$default_tab = SSL_Labs_Settings_Definition::get_default_tab_slug();

		$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], $tabs ) ? $_GET[ 'tab' ] : $default_tab;

		include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );

	}

    public function get_url(){

        $options = get_option( "ssl_quality_checker_settings");
        if($options['domain']){
            return $options['domain'];
        }else {
            return get_site_url();
        }

    }
    public function display_status_page(){

        $site_url = self::get_url();

        if(strstr($site_url,"https://")) {
            $client = new SSL_Labs_Admin_API_Client($site_url);

            $force_cache_refresh = isset( $_GET['force_refresh']) ? $_GET['force_refresh'] : false;

            $response = $client->analyse($force_cache_refresh == 1);
            if ($response->status != "READY") {
                include_once( 'partials/' . $this->plugin_name . '-view-status-not-ready.php');
            } else {
                include_once( 'partials/' . $this->plugin_name . '-view-status.php');
                $options = get_option( "ssl_quality_checker_settings");
                if(!$client->check_grade($options['expected_grade'])){
                    update_option("ssl_labs_inform_user", 1);
                    if($options['email_site_admin']){
                        $adminusers = get_users('role=Administrator');
                        foreach ($adminusers as $user) {
                            self::send_email($response,$user->user_email);
                        }
                    }
                    if ($options['email_address']) {
                        self::send_email($response,$options['email_address']);
                    }
                }else if($options['force_email_send']) {
                    if($options['email_site_admin']){
                        $adminusers = get_users('role=Administrator');
                        foreach ($adminusers as $user) {
                            self::send_email($response, $user->user_email);
                        }
                    }
                    if ($options['email_address']) {
                        self::send_email($response,$options['email_address']);
                    }
                }else{
                    update_option("ssl_labs_inform_user", 0);
                }

            }
        }else{
            include_once( 'partials/' . $this->plugin_name . '-view-status-not-ssl.php');
        }
    }

    public function cron_check_status(){

        $site_url = self::get_url();

        if(strstr($site_url,"https://")) {
            $client = new SSL_Labs_Admin_API_Client($site_url);
            $response = $client->analyse();

            if ($response->status == "READY") {
                $options = get_option( "ssl_quality_checker_settings");
                if(!$client->check_grade($options['expected_grade'])){
                    update_option("ssl_labs_inform_user", 1);
                    if ($options['email_address']) {
                        self::send_email($response,$options['email_address']);
                    }
                }else{
                    update_option("ssl_labs_inform_user", 0);
                }
            }
        }else{

        }

    }
    public function send_email($response, $email_address){
        $site_url = self::get_url();
        ob_start();
        include_once( 'partials/' . $this->plugin_name . '-email.php');
        $message = ob_get_contents();
        ob_end_clean();
        add_filter("wp_mail_content_type", array($this,"set_mail_content_type"));
        wp_mail($email_address, "Your SSL status", $message);
        remove_filter("wp_mail_content_type", array($this,"set_mail_content_type"));
    }

    public function set_mail_content_type(){
        return "text/html";
    }
    public function show_admin_notice(){
        global $current_user ;
        $user_id = $current_user->ID;
        $ignore = get_user_meta($user_id, 'ignore_ssl_notice', true);
        if ( get_option('ssl_labs_inform_user') && (!$ignore) ) {
            echo '<div class="error notice is-dismissible ssl-notice"><p>';
            echo __('Your SSL certificate is not the grading you expected', $this->plugin_name);
            echo "</p></div>";
        }
    }

    public function ssl_check_status(){

        if ( !wp_verify_nonce( $_REQUEST['nonce'], "ssl_check_status")) {
            exit("No naughty business please");
        }

        $site_url = self::get_url();

        if(strstr($site_url,"https://")) {
            $client = new SSL_Labs_Admin_API_Client($site_url);
            $response = $client->analyse();
            echo json_encode($response);
        }
        die();
    }

    public function ignore_ssl_notice(){
        global $current_user;
        $user_id = $current_user->ID;

        add_user_meta($user_id, 'ignore_ssl_notice', '1', true);
        update_user_meta($user_id, 'ignore_ssl_notice', '1');

        die();

    }

    public function update_cron_schedule($old_value, $new_value){
        wp_clear_scheduled_hook('cron_check_ssl_status');
        if(($new_value['cronschedule'] != 'never') && ($new_value['cronschedule'] != $old_value['cronschedule'])) {
            wp_schedule_event(time(), $new_value['cronschedule'], 'cron_check_ssl_status');
        }
    }

    public function add_new_intervals($schedules){
        // add weekly and monthly intervals
        $schedules['weekly'] = array(
            'interval' => 604800,
            'display' => __('Once Weekly')
        );

        $schedules['monthly'] = array(
            'interval' => 2635200,
            'display' => __('Once a month')
        );

        return $schedules;
    }
}
