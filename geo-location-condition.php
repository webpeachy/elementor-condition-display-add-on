<?php

namespace EDCAO\Conditions;

use ElementorPro\Modules\DisplayConditions\Conditions\Base\Condition_Base;
use Elementor\Controls_Manager;

/**
 * Class ACF_Field_Value_Condition
 * @package EDCAO\Conditions
 */
class Geo_Location_Condition extends Condition_Base
{
    /**
     * @return array
     */
    public function get_options()
    {
        return [];
    }

    /**
     * @return string
     */
    public function get_name()
    {
        return 'user_geo_location';
    }

    /**
     * @return string
     */

    public function get_label()
    {
        return esc_html__('User geo Location region', 'elementor-pro');
    }

    /**
     * @return string
     */
    public function get_group()
    {
        return 'geo_location';
    }

    /**
     * @return void
     */
    protected function register_controls()
    {
        $this->start_controls_section('__settings');

        $comparators = [
            'is_one_of' => esc_html__('Is One Of', 'EDCAO'),
            'is_not_one_of' => esc_html__('Is Not One Of', 'EDCAO')
        ];

        $this->add_control(
            'comparator',
            [
                'type' => Controls_Manager::SELECT,
                'options' => $comparators,
                'default' => 'is_one_of',
            ]
        );

        $this->add_control(
            'geo_regions',
            [
                'label' => esc_html__('Geo Regions', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $this->get_us_state_options(), // Use the method to get options
                'default' => [],
                'placeholder' => esc_html__('Select State', 'EDCAO'),
            ]
        );

        $this->end_controls_section();
    }

    /**
     * @param array $args
     *
     * @return bool
     */
    public function check($args): bool
    {

        $comparator = $args['comparator'];
        $geo_regions = $args['geo_regions'];
        $user_state = $this->get_user_geo_state();
        // $user_state = 'NY';
        if ($comparator === 'is_one_of') {
            return in_array($user_state, $geo_regions);
        } else {
            return !in_array($user_state, $geo_regions);
        }
    }

    /**
     * @return array
     */
    public function get_us_state_options()
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District Of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'PR' => 'Puerto Rico',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'VI' => 'US Virgin Islands',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
        ];
    }

    /**
     * @return bool|string
     */
    public function get_user_geo_state()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = '198.200.132.56';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://ipapi.co/$ip/json/");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);

        // var_dump($response);
        // die();
        if (!$response) {
            return false;
        } else {
            $response_data = json_decode($response, true);
            return isset($response_data['region']) ? $response_data['region'] : false;
        }
    }
}
