<?php

class EDCAO_Custom_Fields
{

    // Constructor to initialize the ACF field setup
    public function __construct()
    {
        add_action('acf/init', array($this, 'add_acf_fields_to_page'));
    }

    // Method to add ACF fields to the "page" post type
    public function add_acf_fields_to_page()
    {
        if (function_exists('acf_add_local_field_group')) :

            acf_add_local_field_group(array(
                'key' => 'group_page_fields',
                'title' => 'Page Custom Fields',
                'fields' => array(
                    array(
                        'key' => 'field_page_rating',
                        'label' => 'Rating',
                        'name' => 'page_rating',
                        'type' => 'select',
                        'choices' => array_combine(range(1, 10),range(1, 10)), // Generate numbers from 1 to 10
                        'post_type' => array('page'), // Specify the post type (in this case, 'page')
                    ),
                    array(
                        'key' => 'field_page_summary',
                        'label' => 'Summary',
                        'name' => 'page_summary',
                        'type' => 'textarea',
                        'post_type' => array('page'),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'post', // Target the 'page' post type
                        ),
                    ),
                ),
            ));

        endif;
    }
}