<?php
/**
 * Plugin Name:       Post Slider Widget For Elementor
 * Description:       A simple and nice plugin that helps you to show your wordpress post as a slider.
 * Version:           1.0.0
 * Author:            Shahrukh Ahmmed
 * Author URI:        https://pluginscafe.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       post-slider-elementor
 */
if( ! defined ('ABSPATH') ) {
    exit;
}

/**
 * Widgets Loader
 */


function PsweWidgetsCategroies( $elements_manager ) {

	$elements_manager->add_category(
		'plugins-cafe',
		[
			'title' => esc_html__( 'Plugins Cafe', 'post-slider-elementor' ),
			'icon' => 'fa fa-plug',
		]
	);

}
add_action( 'elementor/elements/categories_registered', 'PsweWidgetsCategroies' );


require plugin_dir_path(__FILE__).'post-slider-base.php';