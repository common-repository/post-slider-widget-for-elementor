<?php

if( ! defined ('ABSPATH') ) {
    exit;
}

/**
 * Main Pswe_Post_Slider_Root Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Pswe_Post_Slider_Root {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const PSWE_VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const PSWE_MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const PSWE_MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Pswe_Post_Slider_Root The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Pswe_Post_Slider_Root An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'load_wpac_scripts' ] );




	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'post-slider-elementor' );

	}

    /**
     * Load CSS & JS Files
     * 
     * @since 1.0.0
     * 
     * @access public
     */






     public function load_wpac_scripts(){
        wp_register_style( "pswe-style", PSWE_PLUGIN_URL."assets/css/style.css", array(), 1.0, "all" );   
        wp_enqueue_style( "pswe-style" );
 
        wp_register_script("pswe-main", PSWE_PLUGIN_URL."assets/js/main.js", array('jquery'), 1.0, true);
        wp_enqueue_script("pswe-main");

		if (!in_array( 'elementor-pro/elementor-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) { 
			wp_register_style( "pswe-swiper", PSWE_PLUGIN_URL."assets/css/swiper.min.css", array(), 1.0, "all" );
			wp_enqueue_style( "pswe-swiper" );

			wp_register_script("pswe-swiper", PSWE_PLUGIN_URL."assets/js/swiper.min.js", array('jquery'), 1.0, true);
			wp_enqueue_script("pswe-swiper");

		}
     }

    /**
	 * define constant
	 */
     public function define_constant(){
        define('PSWE_PLUGIN_URL', trailingslashit(plugins_url( '/',  __FILE__ )));
        define('PSWE_PLUGIN_PATH',trailingslashit(plugin_dir_path( __FILE__ )));

    }
	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_plugins_loaded() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}

	}

	
	

	/**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin's minimum requirement.
	 * Checks if the installed PHP version meets the plugin's minimum requirement.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::PSWE_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::PSWE_MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {
	
		$this->i18n();

        $this->define_constant();

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files
		require_once( PSWE_PLUGIN_PATH .'/widget/post-slider-widget.php' );

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Pswe_Post_Slider() );

	}
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'post-slider-elementor' ),
			'<strong>' . esc_html__( 'Post Slider Widget For Elementor', 'post-slider-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'post-slider-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'post-slider-elementor' ),
			'<strong>' . esc_html__( 'Post Slider Widget For Elementor', 'post-slider-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'post-slider-elementor' ) . '</strong>',
			 self::PSWE_MINIMUM_ELEMENTOR_VERSION

		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'post-slider-elementor' ),
			'<strong>' . esc_html__( 'Post ', 'post-slider-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'post-slider-elementor' ) . '</strong>',
			 self::PSWE_MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}

Pswe_Post_Slider_Root::instance();
