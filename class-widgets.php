<?php
/**
 * Widgets class.
 *
 * @category   Class
 * @package    ZupinCustomTabs
 * @subpackage WordPress
 * @author     Ali Jahandideh <ali.jahandideh@live.com>
 * @copyright  2022 Ali Jahandideh
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       https://www.zupin.dev
 * @since      1.0.0
 * php version 7.3.9
 */

namespace ZupinCustomTabs;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Widgets {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once 'widgets/zup-gallery-tabs.php';
		require_once 'widgets/zup-slide-tabs.php';
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// It's now safe to include Widgets files.
		$this->include_widgets_files();

		// Register the plugin widget classes.		
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Zup_Gallery_Tabs() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Zup_Slide_Tabs() );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		# Gallery Thumbnail Image Size --------
		add_image_size( 'zup-md', 300, 300, true );
		add_image_size( 'zup-xl', 1300, 812, true );
		
		# Register widget styles --------
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

		# Register widget scripts --------
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'widget_scripts' ] );

		# Register the widgets --------
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );

	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {

		wp_enqueue_script( 'zup-tabs', plugins_url( '/assets/js/easyResponsiveTabs.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'zup-owl', plugins_url( '/assets/js/owl.carousel.min.js', __FILE__ ), array('jquery') );

	}

	/**
	 * widget_styles
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_styles() {

		wp_enqueue_style( 'zup-tabs', plugins_url( '/assets/css/easy-responsive-tabs.css', __FILE__ ) );
		wp_enqueue_style( 'zup-owl', plugins_url( '/assets/css/owl.carousel.css', __FILE__ ) );
		wp_enqueue_style( 'zup-owl-theme', plugins_url( '/assets/css/owl.theme.default.css', __FILE__ ) );

	}

}



// Instantiate the Widgets class.
Widgets::instance();
