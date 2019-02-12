<?php
/*
Plugin Name:  HTD Contact
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Contact Form Plugin
Version:      1.0.0
Author:       WordPress.org
Author URI:   https://developer.wordpress.org/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  htd-contact
Domain Path:  /languages
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class HTD_Contact_Form {

        /**
		 * HTD Contact Form version.
		 *
		 * @var string
		 */
		public $version = '1.0.0';
		/**
		 * The single instance of the class.
		 *
		 * @var HTD Contact Form
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Main HTD_Contact_Form Instance.
		 * Ensures only one instance of HTD_Contact_Form is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @see HTD_Contact_Form()
		 * @return HTD_Contact_Form - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * HTD_Contact_Form Constructor.
		 */
		function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
		}

		/**
		 * Define HTD_Contact_Form Constants.
		 */
		private function define_constants() {
			$this->define( 'HTD_CONTACT_FORM_PLUGIN_FILE', __FILE__ );
			$this->define( 'HTD_CONTACT_FORM_ABSPATH', dirname( __FILE__ ) . '/' );
			$this->define( 'HTD_CONTACT_FORM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'HTD_CONTACT_FORM_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
			$this->define( 'HTD_CONTACT_FORM_VERSION', $this->version );
			$this->define( 'HTD_CONTACT_FORM_PLUGIN_DIR', plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		private function init_hooks() {
			register_activation_hook( __FILE__, array( $this, 'htd_contact_form_activation' ) );
			add_action( 'init', array(  'HTD_CF_Post_Type', 'htd_register_post_type' ) );

		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string $name  Name of constant.
		 * @param  string $value Value of constant.
		 * @return void
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @return void
		 */
		function includes() {
            
			include sprintf( '%s/inc/class-htd-cf-post-types.php', HTD_CONTACT_FORM_ABSPATH );
			include sprintf( '%s/inc/class-admin-metaboxes.php', HTD_CONTACT_FORM_ABSPATH );
			include sprintf( '%s/inc/class-htd-form-shortcode.php', HTD_CONTACT_FORM_ABSPATH );
					

			// if ( $this->is_request( 'admin' ) ) {
                

                
			// }
		}

		/**
		 * What type of request is this?
		 *
		 * @param  string $type admin, ajax, cron or frontend.
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}
		
		/**
		 * HTD Contact Form Activation.
		 */
		function htd_contact_form_activation() {

			$posts_types = new HTD_CF_Post_Type();
			$posts_types->init();
			
		}


}

/**
 * Main instance of HTD Contact Form.
 *
 * Returns the main instance of HTD_Contact_Form to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return HTD Contact Form
 */
function HTD_Contact_Form() {
	return HTD_Contact_Form::instance();
}

// Start HTD Contact Form.
HTD_Contact_Form();
