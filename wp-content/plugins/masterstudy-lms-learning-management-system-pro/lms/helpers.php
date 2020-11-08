<?php
function stm_lms_pro_register_style($style, $deps = array(), $inline_css = '')
{
    $default_path = STM_LMS_PRO_URL . 'assets/css/parts/';
    if (stm_lms_has_custom_colors()) $default_path = stm_lms_custom_styles_url();

    wp_enqueue_style('stm-lms-' . $style, $default_path . $style . '.css', $deps, stm_lms_custom_styles_v());

    if (!empty($inline_css)) wp_add_inline_style('stm-lms-' . $style, $inline_css);
}

function stm_lms_pro_register_script($script, $deps = array(), $footer = false)
{
    wp_enqueue_script('stm-lms-' . $script, STM_LMS_PRO_URL . 'assets/js/' . $script . '.js', $deps, stm_lms_custom_styles_v(), $footer);
}

function stm_lms_pro_allowed_html()
{
    $allowed_html = wp_kses_allowed_html('post');
    $allowed_html['iframe'] = array(
        'autoplay' => 1,
        'src' => 1,
        'width' => 1,
        'height' => 1,
        'class' => 1,
        'style' => 1,
        'muted' => 1,
        'loop' => 1,
    );

    return apply_filters('stm_lms_allowed_html', $allowed_html);
}

add_action('admin_head', 'stm_lms_pro_nonces');
add_action('wp_head', 'stm_lms_pro_nonces');
function stm_lms_pro_nonces()
{

    $nonces = array(
        'stm_lms_pro_install_base',
        'stm_lms_pro_search_courses',
        'stm_lms_pro_udemy_import_courses',
        'stm_lms_pro_udemy_publish_course',
        'stm_lms_pro_udemy_import_curriculum',
        'stm_lms_pro_save_addons',
        'stm_lms_create_announcement',
        'stm_lms_pro_upload_image',
        'stm_lms_pro_get_image_data',
        'stm_lms_pro_save_quiz',
        'stm_lms_pro_save_lesson',
        'stm_lms_pro_save_front_course',
        'stm_lms_get_course_info',
        'stm_lms_get_course_students',
    );

    $nonces_list = array();

    foreach ($nonces as $nonce_name) {
        $nonces_list[$nonce_name] = wp_create_nonce($nonce_name);
    }

    ?>
    <script>
        var stm_lms_pro_nonces = <?php echo json_encode($nonces_list); ?>;
    </script>
    <?php
}