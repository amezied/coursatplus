<?php

new STM_LMS_Course_Bundle_Settings;

class STM_LMS_Course_Bundle_Settings
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
            'Course Bundle Settings',
            'Course Bundle Settings',
            'manage_options',
            'course_bundle_settings',
            array($this, 'stm_lms_settings_page_view')
        );
    }

    function stm_lms_settings()
    {
        return apply_filters('stm_lms_course_bundle_settings', array(
            'id' => 'stm_lms_course_bundle_settings',
            'args' => array(
                'stm_lms_course_bundle_settings' => array(
                    'credentials' => array(
                        'name' => esc_html__('Credentials', 'masterstudy-lms-learning-management-system-pro'),
                        'fields' => array(
                            'bundle_limit' => array(
                                'type' => 'text',
                                'label' => esc_html__('Bundles quantity limit', 'masterstudy-lms-learning-management-system-pro'),
                            ),
                            'bundle_courses_limit' => array(
                                'type' => 'text',
                                'label' => esc_html__('Courses in bundle quantity limit', 'masterstudy-lms-learning-management-system-pro'),
                                'description' => esc_html__('By default limit is 5. Five courses - fits the best in bundle on frontend.', 'masterstudy-lms-learning-management-system-pro'),
                            ),
                        )
                    ),
                ),
            )
        ));
    }

    static function stm_lms_get_settings()
    {
        return get_option('stm_lms_course_bundle_settings', array());
    }

    function stm_lms_settings_page_view()
    {
        $metabox = $this->stm_lms_settings();
        $settings = $this->stm_lms_get_settings();

        foreach ($metabox['args']['stm_lms_course_bundle_settings'] as $section_name => $section) {
            foreach ($section['fields'] as $field_name => $field) {
                $default_value = (!empty($field['value'])) ? $field['value'] : '';
                $metabox['args']['stm_lms_course_bundle_settings'][$section_name]['fields'][$field_name]['value'] = (!empty($settings[$field_name])) ? $settings[$field_name] : $default_value;
            }
        }
        $title = esc_html__('Course Bundle settings', 'masterstudy-lms-learning-management-system-pro'); ?>
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