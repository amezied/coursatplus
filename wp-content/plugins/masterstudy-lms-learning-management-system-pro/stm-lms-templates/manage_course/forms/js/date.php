<?php ob_start(); ?>

    <script>
        <?php
        ob_start();
        include STM_LMS_PATH . '/post_type/metaboxes/components/date.php';
        $template = preg_replace("/\r|\n/", "", ob_get_clean());
        ?>

        Vue.component('date-picker', DatePicker.default);
        Vue.component('stm-date', {
            props: ['current_date'],
            data: function () {
                return {
                    date: []
                }
            },
            mounted: function () {
                if (typeof this.current_date !== 'undefined') {
                    this.date.push(new Date(parseInt(this.current_date)));
                }
            },
            template: '<?php echo $template; ?>',
            methods: {
                dateChanged(newDate) {
                    this.$emit('date-changed', new Date(newDate).getTime());
                }
            },
        });
    </script>

<?php wp_add_inline_script('stm-lms-manage_course', str_replace(array('<script>', '</script>'), '', ob_get_clean())); ?>