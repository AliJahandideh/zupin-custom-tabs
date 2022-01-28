<?php
/**
 * Zupin Custom Tabs WordPress Plugin
 *
 * @package ZupinCustomTabs
 *
 * Plugin Name: Zupin Custom Tabs
 * Description: Customized elementor tabs to display galleries and sliders
 * Plugin URI:  https://zupin.dev
 * Version:     1.0.0
 * Author:      Ali Jahandideh
 * Author URI:  https://zupin.dev
 * Text Domain: zup-widgets
 */

define( 'ZUPIN_CUSTOMTABS', __FILE__ );

/**
 * Include the Zupin_CustomTabs class.
 */
require plugin_dir_path( ZUPIN_CUSTOMTABS ) . 'class-zupin-custom-tabs.php';
