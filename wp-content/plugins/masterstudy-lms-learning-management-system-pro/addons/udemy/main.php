<?php

require_once STM_LMS_PRO_PATH . '/addons/udemy/import.php';

new STM_LMS_Udemy;

class STM_LMS_Udemy
{

    function __construct()
    {
        add_action('admin_menu', array($this, 'stm_lms_settings_page'), 1000);

        add_action('wp_ajax_stm_lms_pro_search_courses', 'STM_LMS_Udemy::search_courses');

        add_filter('stm_lms_wrapper_classes', 'STM_LMS_Udemy::udemy_classes');

        add_action('stm-lms-content-stm-courses', 'STM_LMS_Udemy::single_course', 10);

        add_action('wp_ajax_stm_lms_pro_udemy_publish_course', 'STM_LMS_Udemy::publish_course');

        add_action('stm-lms-buy-button', 'STM_LMS_Udemy::buy-button');

        add_filter('stm_lms_template_name', 'STM_LMS_Udemy::replace_templates', 100, 2);

    }

    function stm_lms_settings_page()
    {
        add_submenu_page(
            'stm-lms-settings',
            'Udemy Importer',
            'Udemy Importer',
            'manage_options',
            'stm-lms-udemy-settings',
            array($this, 'stm_lms_settings_page_view')
        );
    }

    function stm_lms_settings()
    {
        return apply_filters('stm_lms_udemy_settings', array(
            'id' => 'stm_lms_udemy_settings',
            'args' => array(
                'stm_lms_udemy_settings' => array(
                    'credentials' => array(
                        'name' => esc_html__('Credentials', 'masterstudy-lms-learning-management-system-pro'),
                        'fields' => array(
                            'udemy_client_id' => array(
                                'type' => 'text',
                                'label' => esc_html__('Client ID', 'masterstudy-lms-learning-management-system-pro'),
                                'description' => wp_kses_post('You need <a href="https://www.udemy.com/user/edit-api-clients/" target="_blank">Udemy API</a> credentials.'),
                            ),
                            'udemy_client_secret' => array(
                                'type' => 'text',
                                'label' => esc_html__('Client Secret', 'masterstudy-lms-learning-management-system-pro'),
                                'description' => wp_kses_post('You need <a href="https://www.udemy.com/user/edit-api-clients/" target="_blank">Udemy API</a> credentials.'),
                            ),
                            'udemy_affiliate_automate' => array(
                                'type' => 'textarea',
                                'label' => esc_html__('Udemy Rakuten Affiliate script', 'masterstudy-lms-learning-management-system-pro'),
                                'description' => wp_kses_post('Get Your <a href="http://cli.linksynergy.com/cli/publisher/portfolio/automate/automate.php" target="_blank">Rakuten Automate script</a> and paste it here.'),
                            ),

                        )
                    ),
                    'search' => array(
                        'name' => esc_html__('Search', 'masterstudy-lms-learning-management-system-pro'),
                        'fields' => array(
                            'search_udemy' => array(
                                'type' => 'udemy/search',
                                'label' => esc_html__('Search Courses', 'masterstudy-lms-learning-management-system-pro'),
                            ),
                        )
                    ),
                    'courses' => array(
                        'name' => esc_html__('Imported Courses', 'masterstudy-lms-learning-management-system-pro'),
                        'fields' => array(
                            'manage_udemy_courses' => array(
                                'type' => 'manage_post_type',
                                'meta_key' => 'udemy_course_id',
                                'post_type' => 'stm-courses',
                            ),
                        )
                    ),
                ),
            )
        ));
    }

    function stm_lms_get_settings()
    {
        return get_option('stm_lms_udemy_settings', array());
    }

    function stm_lms_settings_page_view()
    {
        $metabox = $this->stm_lms_settings();
        $settings = $this->stm_lms_get_settings();

        foreach ($metabox['args']['stm_lms_udemy_settings'] as $section_name => $section) {
            foreach ($section['fields'] as $field_name => $field) {
                $default_value = (!empty($field['value'])) ? $field['value'] : '';
                $metabox['args']['stm_lms_udemy_settings'][$section_name]['fields'][$field_name]['value'] = (!empty($settings[$field_name])) ? $settings[$field_name] : $default_value;
            }
        }
        $title = esc_html__('STM LMS Udemy Settings', 'masterstudy-lms-learning-management-system-pro'); ?>
        <script>
            const STM_LMS_EventBus = new Vue();
        </script>
        <blockquote class="stm_lms_guide">
            <h4>
                <i class="lnr lnr-pointer-right"></i><?php esc_html_e('How to use', 'masterstudy-lms-learning-management-system-pro'); ?>
            </h4>
            <?php esc_html_e('Enter Udemy Credentials in tab below. In Import tab, you can enter Udemy course ID, and import into your site. Also, search is available where you can find courses, and their ID\'s'); ?>
        </blockquote>
        <?php require_once(STM_LMS_PATH . '/settings/view/main.php');
    }

    public static function search_courses()
    {

        check_ajax_referer('stm_lms_pro_search_courses', 'nonce');

        $s = (!empty($_GET['s'])) ? sanitize_text_field($_GET['s']) : '';
        $transient_name = "stm_lms_search_courses_{$s}";

        $disable_transient = true;

        if (false === ($courses = get_transient($transient_name)) or $disable_transient) {
            require_once STM_LMS_PRO_PATH . '/lms/classes/Udemy/autoload.php';
            $client = new Udemy_Client();
            $apis = get_option('stm_lms_udemy_settings', array());
            if (empty($apis['udemy_client_id']) or empty($apis['udemy_client_secret'])) {
                wp_send_json(esc_html__('Please, enter Udemy API Credentials', 'masterstudy-lms-learning-management-system-pro'));
                die;
            }
            $client_id = $apis['udemy_client_id'];
            $client_secret = $apis['udemy_client_secret'];
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);

            $service = new Udemy_Service_Courses($client);

            $optParams = array(
                'search' => $s,
                'page_size' => 50
            );

            $results = $service->courses->listCourses($optParams);

            $courses = array();

            foreach ($results as $item) {
                $courses[] = $item;
            }

            set_transient($transient_name, $courses, 60 * 60);
        }

        if (empty($courses)) $courses = array(
            array(
                'title' => esc_html__('Nothing Found', 'masterstudy-lms-learning-management-system-pro')
            )
        );

        if ($disable_transient) {
            delete_transient($transient_name);
        }

        wp_send_json($courses);
    }

    public static function is_udemy_course($id = '')
    {
        if (empty($id)) {
            global $post;
            $id = $post->ID;
        }
        return apply_filters('stm_lms_is_udemy_course', get_post_meta($id, 'udemy_course_id', true));
    }

    public static function udemy_classes($classes)
    {
        if (is_singular('stm-courses')) {
            $is_udemy = STM_LMS_Udemy::is_udemy_course();
            if ($is_udemy) $classes .= ' stm_lms_udemy_course';
        }

        return $classes;
    }

    public static function single_course()
    {
        $is_udemy = STM_LMS_Udemy::is_udemy_course();
        if ($is_udemy) {
            remove_all_actions('stm-lms-content-stm-courses');
            STM_LMS_Templates::show_lms_template('course/udemy/single');
        }
    }

    public static function publish_course()
    {

        check_ajax_referer('stm_lms_pro_udemy_publish_course', 'nonce');

        $udemy_course_id = intval($_GET['id']);

        $course_id = STM_LMS_Udemy_Import::is_course_exist($udemy_course_id);
        if (empty($course_id)) die;
        $course = array(
            'ID' => $course_id,
            'post_status' => 'publish'
        );

        wp_update_post($course);

        wp_send_json(esc_html__('Published', 'masterstudy-lms-learning-management-system-pro'));
    }

    public static function affiliate_automate_links()
    {
        $settings = get_option('stm_lms_udemy_settings', array());
        $script = '';
        if (!empty($settings['udemy_affiliate_automate'])) {
            $script = str_replace(
                array(
                    '<!-- Rakuten Automate starts here -->',
                    '<!-- Rakuten Automate ends here -->',
                    '<script type="text/javascript">',
                    '</script>'
                ),
                array(''),
                $settings['udemy_affiliate_automate']
            );
        }

        stm_lms_register_script('buy-button', array(), true, $script);
    }

    public static function replace_templates($name, $stm_lms_vars)
    {
        switch ($name) {
            case('/stm-lms-templates/courses/parts/rating.php'):
                if (STM_LMS_Udemy::is_udemy_course($stm_lms_vars['id'])) {
                    $name = '/stm-lms-templates/courses/udemy/parts/rating.php';
                }
                break;
            case('/stm-lms-templates/courses/parts/course_info.php'):
                if (STM_LMS_Udemy::is_udemy_course($stm_lms_vars['post_id'])) {
                    $name = '/stm-lms-templates/courses/udemy/parts/course_info.php';
                }
                break;
        }
        return $name;
    }
}