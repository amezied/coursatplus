<?php

add_action('vc_after_init', 'stm_lms_ms_courses_carousel_vc');

function stm_lms_ms_courses_carousel_vc()
{

    $terms = stm_lms_autocomplete_terms('stm_lms_course_taxonomy');

    vc_map(array(
        'name'        => esc_html__('STM LMS Courses Carousel', 'masterstudy-lms-learning-management-system'),
        'base'        => 'stm_lms_courses_carousel',
        'icon'        => 'stm_lms_courses_carousel',
        'description' => esc_html__('Display Courses in Styled Carousel', 'masterstudy-lms-learning-management-system'),
        'html_template' => STM_LMS_Templates::vc_locate_template('vc_templates/stm_lms_courses_carousel'),
        'php_class_name' => 'WPBakeryShortCode_Stm_Lms_Ms_Courses_Carousel',
        'category'    => array(
            esc_html__('Content', 'masterstudy-lms-learning-management-system'),
        ),
        'params'      => array(
            array(
                'type'       => 'textfield',
                'heading'    => __('Title', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'title',
            ),
            array(
                'type'       => 'colorpicker',
                'heading'    => __('Title color', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'title_color',
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __('Sort', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'query',
                'value'      => array(
                    'None'    => 'none',
                    'Popular' => 'popular',
                    'Free'    => 'free',
                    'Rating'  => 'rating',
                )
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __('Prev/Next Buttons', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'prev_next',
                'value'      => array(
                    'Enable'  => 'enable',
                    'Disable' => 'disable',
                ),
                'std'        => 'enable',
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __('Remove border', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'remove_border',
                'value'      => array(
                    'Enable'  => 'enable',
                    'Disable' => 'disable',
                ),
                'std'        => 'disable',
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __('Pagination', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'pagination',
                'value'      => array(
                    'Enable'  => 'enable',
                    'Disable' => 'disable',
                ),
                'std'        => 'disable',
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __('Show categories', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'show_categories',
                'value'      => array(
                    'Enable'  => 'enable',
                    'Disable' => 'disable',
                ),
                'std'        => 'disable',
            ),
            array(
                'type'       => 'textfield',
                'heading'    => __('Courses per row', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'per_row',
                'std'        => '6',
            ),
            array(
                'type'       => 'autocomplete',
                'heading'    => esc_html__('Select taxonomy', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'taxonomy',
                'settings'   => array(
                    'multiple'       => true,
                    'sortable'       => true,
                    'min_length'     => 1,
                    'no_hide'        => true,
                    'unique_values'  => true,
                    'display_inline' => true,
                    'values'         => $terms
                ),
                'dependency' => array(
                    'element' => 'show_categories',
                    'value' => array( 'enable' )
                ),
            ),
            array(
                'type'       => 'autocomplete',
                'heading'    => esc_html__('Show Courses From categories:', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'taxonomy_default',
                'settings'   => array(
                    'multiple'       => true,
                    'sortable'       => true,
                    'min_length'     => 1,
                    'no_hide'        => true,
                    'unique_values'  => true,
                    'display_inline' => true,
                    'values'         => $terms
                ),
                'dependency' => array(
                    'element' => 'show_categories',
                    'value' => array( 'disable' )
                ),
            ),
            array(
                'type'       => 'textfield',
                'heading'    => __( 'Image size (Ex. : 200x100)', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'image_size',
            ),
            array(
                'type'       => 'css_editor',
                'heading'    => esc_html__('Css', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'css',
                'group'      => esc_html__('Design options', 'masterstudy-lms-learning-management-system')
            )
        )
    ));
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Stm_Lms_Ms_Courses_Carousel extends WPBakeryShortCode
    {
    }
}