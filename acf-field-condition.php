<?php

namespace EDCAO\Conditions;
use ElementorPro\Modules\DisplayConditions\Conditions\Base\Condition_Base;
use Elementor\Controls_Manager;

/**
 * Class ACF_Field_Value_Condition
 * @package EDCAO\Conditions
 */
class ACF_Field_Value_Condition extends Condition_Base {
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
        return 'acf_field_value';
    }

    /**
     * @return string
     */
    public function get_label()
    {
        return esc_html__('ACF Field Value', 'EDCAO');
    }

    /**
     * @return string
     */
    public function get_group()
    {
        return 'acf';
    }

    /**
     * @return array
     */
    private function get_acf_fields(){
        $fields = [];
        if(function_exists('acf_get_fields')){
            $groups = acf_get_field_groups();
            foreach($groups as $group){ 
                $group_fields = acf_get_fields($group['key']);
                foreach($group_fields as $field){
                    $fields[$field['key']] = $field['label'];
                }
            }
        }
        return $fields;
    }

    /**
     * @return void
     */
    protected function register_controls()
    {
        $this->start_controls_section('__settings');

        $this->add_control(
            'acf_field_key',
            [
                'label' => esc_html__('ACF Field', 'EDCAO'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_acf_fields(),
                'default' => '',
                'title' => esc_html__('Select the ACF field', 'EDCAO'),
            ]
        );

        $this->add_control(
            'comparator',
            [
                'label' => esc_html__('Comparison Type', 'EDCAO'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'eqaul' => esc_html__('Eqaul', 'EDCAO'),
                    'bigger' => esc_html__('Bigger', 'EDCAO'),
                    'smaller' => esc_html__('Smaller', 'EDCAO'),
                ],
                'default' => 'eqaul',
            ]
        );

        $this->add_control(
            'acf_field_value',
            [
                'label' => esc_html__('ACF Field Value', 'EDCAO'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Enter the ACF field value', 'EDCAO'),
            ]
        );

        $this->end_controls_section();
    }

    /**
     * @param $args
     * @return bool
     */
    public function check($args): bool
    {

        $acf_field_value_condition = $args['acf_field_value'] ?? '';
        $acf_field_key = $args['acf_field_key'] ?? '';
        if(!$acf_field_key){
            return false;
        }

        $comparison_type = $args['comparator'] ?? '';
       
        $post_id = get_the_ID();
        $acf_field_value = get_field($acf_field_key, $post_id);
        if(!$acf_field_value){
            return false;
        }

        switch ($comparison_type) {
            case 'bigger':
                return $acf_field_value > $acf_field_value_condition;
            case 'smaller':
                return $acf_field_value < $acf_field_value_condition;
            case 'eqaul':
            default:
                return $acf_field_value == $acf_field_value_condition;
        }
    }
}