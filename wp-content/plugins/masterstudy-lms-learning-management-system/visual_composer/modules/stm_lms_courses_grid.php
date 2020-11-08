<?php

add_action('vc_after_init', 'stm_lms_ms_courses_grid_vc');

function stm_lms_ms_courses_grid_vc()
{

    $terms = stm_lms_autocomplete_terms('stm_lms_course_taxonomy');

    vc_map(array(
        'name'   => esc_html__('STM LMS Courses Grid', 'masterstudy-lms-learning-management-system'),
        'base'   => 'stm_lms_courses_grid',
        'icon'   => 'stm_lms_courses_grid',
        'description' => esc_html__('Show Recent Courses', 'masterstudy-lms-learning-management-system'),
        'html_template' => STM_LMS_Templates::vc_locate_template('vc_templates/stm_lms_courses_grid'),
        'php_class_name' => 'WPBakeryShortCode_Stm_Lms_Ms_Courses_Grid',
        'category' =>array(
            esc_html__('Content', 'masterstudy-lms-learning-management-system'),
        ),
        'params' => array(
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Hide Top bar', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'hide_top_bar',
                'value'      => array(
                    'Hide' => 'hidden',
                    'Show' => 'showing',
                ),
                'std' => 'showing'
            ),
            array(
                'type'       => 'textfield',
                'heading'    => __( 'Title', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'title',
                'dependency' => array(
                    'element' => 'hide_top_bar',
                    'value' => array( 'showing' )
                )
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Load more', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'hide_load_more',
                'value'      => array(
                    'Hide' => 'hidden',
                    'Show' => 'showing',
                ),
                'std' => 'showing'
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Sort', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'hide_sort',
                'value'      => array(
                    'Hide' => 'hidden',
                    'Show' => 'showing',
                ),
                'std' => 'showing'
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Courses Per Row', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'per_row',
                'value'      => array(
                    '6' => '6',
                    '4' => '4',
                    '3' => '3',
                ),
                'std' => '6'
            ),
            array(
                'type'       => 'textfield',
                'heading'    => __( 'Image size (Ex. : 200x100)', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'image_size',
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
                'heading'    => __( 'Number of courses to show', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'posts_per_page',
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
    class WPBakeryShortCode_Stm_Lms_Ms_Courses_Grid extends WPBakeryShortCode
    {
    }
}