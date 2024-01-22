<?php

/**
 * Plugin Name: Elementor display conditions add on
 * Plugin URI: https://github.com/webpeachy/elementor-display-condition-add-ons
 * Description: For demo purposes only not for production use
 * Version: 0.1
 * Author: web-peachy
 * Author URI: https://webpeachy.io
 */

 if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

 /**
  * @param \ElementorPro\Modules\DisplayConditions\Classes\Conditions_Manager $conditions_manager
  */
 function register_display_conditions_add_on( $conditions_manager ) {

   // Register groups
    require_once plugin_dir_path( __FILE__ ) . 'register-groups.php';
    $elementor_geo_location_display_groups = new \EDCAO\Conditions\EDCAO_Register_Groups();
    add_action( 'elementor/display_conditions/register_groups', [$elementor_geo_location_display_groups, 'register_groups'] );

    // Register condition for geo location
    require_once plugin_dir_path( __FILE__ ) . 'geo-location-condition.php';
    $geo_location_condition = new \EDCAO\Conditions\Geo_Location_Condition();
    $conditions_manager->register_condition_instance( $geo_location_condition );

   // Register condition for product price
    require_once plugin_dir_path( __FILE__ ) . 'wc-product-price-condition.php';
    $WC_Product_Price_Condition = new \EDCAO\Conditions\WC_Product_Price_Condition();
    $conditions_manager->register_condition_instance( $WC_Product_Price_Condition );

   // Register condition for ACF field value
    require_once plugin_dir_path( __FILE__ ) . 'acf-field-condition.php';
    $ACF_Field_Value_Condition = new \EDCAO\Conditions\ACF_Field_Value_Condition();
    $conditions_manager->register_condition_instance( $ACF_Field_Value_Condition );
 };

// Hook the function to the elementor display conditions register hook
add_action( 'elementor/display_conditions/register', 'register_display_conditions_add_on' );

// Render custom fields on post type "post" for demonstration purposes
require_once plugin_dir_path( __FILE__ ) . 'custom-fields.php';
$EDCOA_CustomPageFields = new EDCAO_Custom_Fields();