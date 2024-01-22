<?php

namespace EDCAO\Conditions;

use ElementorPro\Modules\DisplayConditions\Conditions\Base\Condition_Base;
use Elementor\Controls_Manager;

if(!class_exists('WC')){
    return;
}

if(!is_product()){
    return;
}


use WC_Product;
/**
 * Class WC_Product_Price_Condition
 * @package EDCAO\Conditions
 */
class WC_Product_Price_Condition extends Condition_Base {
    /**
     * @return array
     */
    public function get_options() {
        return [];
    }

    /**
     * @return string
     */
    public function get_name()
    {
        return 'product_price';
    }

    /**
     * @return string
     */
    public function get_label()
    {
        return esc_html__('Product Price', 'EDCAO');
    }

    /**
     * @return string
     */
    public function get_group()
    {
        return 'woocommerce';
    }

    /**
     * @return void
     */
    protected function register_controls()
    {
        $this->start_controls_section('__settings');

        $this->add_control(
            'comparator',
            [
                'label' => esc_html__('Comparator', 'EDCAO'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'equal' => esc_html__('Equal', 'EDCAO'),
                    'greater' => esc_html__('Greater Than', 'EDCAO'),
                    'less' => esc_html__('Less Than', 'EDCAO'),
                ],
                'default' => 'equal',
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => esc_html__('Price', 'EDCAO'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * @param $args
     *
     * @return bool
     */
    public function check($args):bool{
        $product = wc_get_product(get_the_ID());
        if (!$product instanceof WC_Product) {
            return false;
        }

        $comparator = $args['comparator'];
        $price_condition = $args['price'];

        if(!is_numeric($price_condition)){
            return false;
        }
        switch ($comparator) {
            case 'equal':
                return $product->get_price() == $price_condition;
            case 'greater':
                return $product->get_price() > $price_condition;
            case 'less':
                return $product->get_price() < $price_condition;
        }

        return false;
    }

}