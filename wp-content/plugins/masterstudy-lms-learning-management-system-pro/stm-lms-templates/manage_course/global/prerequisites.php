<?php

if (class_exists('STM_LMS_Prerequisites')):

    ob_start();
    include STM_LMS_PATH . '/post_type/metaboxes/components_js/autocomplete.php';
    $script = ob_get_clean();
    wp_add_inline_script(
        'vue-select2.js',
        str_replace(array(
            '<script>', '</script>'),
            array('', ''),
            $script
        ),
        'after'
    );

    ?>

    <div class="stm-lms-manage-prereq">
        <h4><?php esc_html_e('Prerequisite Courses', 'masterstudy-lms-learning-management-system-pro'); ?></h4>

        <stm-autocomplete v-bind:posts="['stm-courses']"
                          v-bind:stored_ids="fields['prerequisites']"
                          v-on:autocomplete-ids="fields['prerequisites'] = $event"></stm-autocomplete>

        <input type="hidden"
               name="prerequisites"
               v-model="fields['prerequisites']"/>

        <h4><?php esc_html_e('Prerequisite Courses Passing Percent (%)', 'masterstudy-lms-learning-management-system-pro'); ?></h4>

        <input type="text"
               name="prerequisite_passing_level"
               v-model="fields['prerequisite_passing_level']"/>
    </div>

<?php endif;