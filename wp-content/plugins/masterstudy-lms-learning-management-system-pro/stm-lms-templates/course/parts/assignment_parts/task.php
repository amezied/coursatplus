<?php
/**
 * @var $content
 */
?>

<a href="#" class="all_requirements">
    <span><?php esc_html_e('All Requirements', 'masterstudy-lms-learning-management-system-pro'); ?></span>
</a>

<div class="clearfix assignment-task">
    <?php echo wp_kses_post($content); ?>
</div>