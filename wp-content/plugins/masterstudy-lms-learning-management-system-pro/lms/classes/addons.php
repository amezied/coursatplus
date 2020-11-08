<?php

STM_LMS_Pro_Addons::init();

class STM_LMS_Pro_Addons
{
    public static function init()
    {
        add_action('init', 'STM_LMS_Pro_Addons::manage_addons', -1);
        add_action('wp_ajax_stm_lms_pro_save_addons', 'STM_LMS_Pro_Addons::save_addons');
    }

    public static function available_addons()
    {
        return array(
            'udemy' => array(
                'name' => esc_html__('Udemy Course Importer', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/udemy.png'),
                'settings' => admin_url('admin.php?page=stm-lms-udemy-settings')
            ),
            'prerequisite' => array(
                'name' => esc_html__('Prerequisites', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/msp.png'),
            ),
            'online_testing' => array(
                'name' => esc_html__('Online Testing', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/mst.png'),
                'settings' => admin_url('admin.php?page=stm-lms-online-testing')
            ),
            'statistics' => array(
                'name' => esc_html__('Statistics and Payout', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/statistics.png'),
                'settings' => admin_url('admin.php?page=stm_lms_statistics')
            ),
            'shareware' => array(
                'name' => esc_html__('Trial Courses', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/trial_courses.png'),
                'settings' => admin_url('admin.php?page=stm-lms-shareware')
            ),
            'sequential_drip_content' => array(
                'name' => esc_html__('Sequential Drip Content', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/sequential.png'),
                'settings' => admin_url('admin.php?page=sequential_drip_content')
            ),
            'gradebook' => array(
                'name' => esc_html__('The Gradebook', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/gradebook.png'),
            ),
            'live_streams' => array(
                'name' => esc_html__('Lessons Live Streaming', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/live-stream.png'),
            ),
            'enterprise_courses' => array(
                'name' => esc_html__('Group Courses', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/enterprise-groups.png'),
                'settings' => admin_url('admin.php?page=enterprise_courses')
            ),
            'assignments' => array(
                'name' => esc_html__('Assignments', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/assignment.png'),
                'settings' => admin_url('admin.php?page=assignments_settings')
            ),
            'point_system' => array(
                'name' => esc_html__('Point system', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/points.png'),
                'settings' => admin_url('admin.php?page=point_system_settings')
            ),
            'course_bundle' => array(
                'name' => esc_html__('Course Bundle', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/bundle.jpg'),
                'settings' => admin_url('admin.php?page=course_bundle_settings')
            ),
            'multi_instructors' => array(
                'name' => esc_html__('Multi-instructors', 'masterstudy-lms-learning-management-system-pro'),
                'url' => esc_url(STM_LMS_URL . 'post_type/metaboxes/assets/addons/multi_instructors.png'),
            ),
        );
    }

    public static function manage_addons()
    {
        $addons_enabled = get_option('stm_lms_addons', array());
        $available_addons = STM_LMS_Pro_Addons::available_addons();

        foreach ($available_addons as $addon => $settings) {
            if (!empty($addons_enabled[$addon]) and $addons_enabled[$addon] == 'on') {
                require_once STM_LMS_PRO_PATH . "/addons/{$addon}/main.php";
            }
        }
    }

    public static function save_addons()
    {

        check_ajax_referer('stm_lms_pro_save_addons', 'nonce');

        if (function_exists('stm_lms_point_system_table')) stm_lms_point_system_table();

        $addons = json_decode(stripcslashes($_POST['addons']), true);

        update_option('stm_lms_addons', $addons);


        wp_send_json('done');
    }
}