<?php

new STM_LMS_Point_System_Settings;

class STM_LMS_Point_System_Settings
{

    function __construct()
    {

        add_action('admin_menu', array($this, 'stm_lms_settings_page'), 1000);

    }

    /*Settings*/
    function stm_lms_settings_page()
    {
        add_submenu_page(
            'stm-lms-settings',
            'Point system Settings',
            'Point system Settings',
            'manage_options',
            'point_system_settings',
            array($this, 'stm_lms_settings_page_view')
        );
    }

    function stm_lms_settings()
    {

        $points = array();

        $points_dist = stm_lms_point_system();

        foreach($points_dist as $point_slug => $point_data) {
            if(empty($point_data['score'])) continue;

            $point_data_rebuild = array(
                'type' => 'text',
                'label' => $point_data['label'],
                'value' => $point_data['score']
            );

            if(!empty($point_data['description'])) $point_data_rebuild['description'] = $point_data['description'];

            $points[$point_slug] = $point_data_rebuild;
        }

        return apply_filters('stm_lms_point_system_settings', array(
            'id' => 'stm_lms_point_system_settings',
            'args' => array(
                'stm_lms_point_system_settings' => array(
                    'credentials' => array(
                        'name' => esc_html__('Interface', 'masterstudy-lms-learning-management-system-pro'),
                        'fields' => array(
                            'point_image' => array(
                                'type' => 'image',
                                'label' => esc_html__('Point Image', 'masterstudy-lms-learning-management-system-pro'),
                            ),
                            'point_label' => array(
                                'type' => 'text',
                                'label' => esc_html__('Point Label', 'masterstudy-lms-learning-management-system-pro'),
                            ),
                            'point_rate' => array(
                                'type' => 'text',
                                'label' => esc_html__('Point Rate', 'masterstudy-lms-learning-management-system-pro'),
                                'description' => esc_html__('Point rate relative to price (Ex.: 100 - means 100 points equal 1$)', 'masterstudy-lms-learning-management-system-pro'),
                                'value' => 10
                            ),
                            'affiliate_points' => array(
                                'type' => 'checkbox',
                                'label' => esc_html__('Enable Affiliate Points', 'masterstudy-lms-learning-management-system-pro'),
                                'description' => esc_html__('Your users can share their affiliate link, and get points for activity of users, they invited.', 'masterstudy-lms-learning-management-system-pro'),
                            ),
                            'affiliate_points_rate' => array(
                                'type' => 'number',
                                'label' => esc_html__('Affiliate Points percent (%)', 'masterstudy-lms-learning-management-system-pro'),
                                'description' => esc_html__('Number of percent, user will receive from affiliate', 'masterstudy-lms-learning-management-system-pro'),
                                'value' => 10
                            ),
                        )
                    ),
                    'points' => array(
                        'name' => esc_html__('Points Distribution', 'masterstudy-lms-learning-management-system-pro'),
                        'fields' => $points
                    ),
                ),
            )
        ));
    }

    static function stm_lms_get_settings()
    {
        return get_option('stm_lms_point_system_settings', array());
    }

    function stm_lms_settings_page_view()
    {
        $metabox = $this->stm_lms_settings();
        $settings = $this->stm_lms_get_settings();

        foreach ($metabox['args']['stm_lms_point_system_settings'] as $section_name => $section) {
            foreach ($section['fields'] as $field_name => $field) {
                $default_value = (!empty($field['value'])) ? $field['value'] : '';
                $metabox['args']['stm_lms_point_system_settings'][$section_name]['fields'][$field_name]['value'] = (!empty($settings[$field_name])) ? $settings[$field_name] : $default_value;
            }
        }
        $title = esc_html__('Point system settings', 'masterstudy-lms-learning-management-system-pro'); ?>
        <script>
            const STM_LMS_EventBus = new Vue();
        </script>
        <?php require_once(STM_LMS_PATH . '/settings/view/main.php');
    }

    function stm_save_settings()
    {
        if (!current_user_can('manage_options')) die;

        if (empty($_REQUEST['name'])) die;
        $id = sanitize_text_field($_REQUEST['name']);
        $settings = array();
        $request_body = file_get_contents('php://input');
        if (!empty($request_body)) {
            $request_body = json_decode($request_body, true);
            foreach ($request_body as $section_name => $section) {
                foreach ($section['fields'] as $field_name => $field) {
                    $settings[$field_name] = $field['value'];
                }
            }
        }

        wp_send_json(update_option($id, $settings));
    }

}