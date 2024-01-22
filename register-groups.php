<?php

namespace EDCAO\Conditions;

/**
 * Class EDCAO_Register_Groups
 * @package EDCAO\Conditions
 */
class EDCAO_Register_Groups {
    /**
     * @param $conditions_manager
     */
    function register_groups( $conditions_manager) {
        $conditions_manager->add_group(
            'woocommerce',
            [
                'label' => esc_html__( 'WooCommerce', 'edcao' ),
            ]
        );

        $conditions_manager->add_group(
            'acf',
            [
                'label' => esc_html__( 'ACF', 'edcao' ),
            ]
        );

        $conditions_manager->add_group(
            'geo_location',
            [
                'label' => esc_html__( 'User GEO location', 'edcao' ),
            ]
        );
    }
}