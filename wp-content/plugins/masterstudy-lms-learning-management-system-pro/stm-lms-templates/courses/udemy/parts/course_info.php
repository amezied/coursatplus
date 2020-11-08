<?php if (!defined('ABSPATH')) exit; //Exit if accessed directly ?>

<?php
/**
 * @var $post_id
 * @var $post_status
 * @var $rates
 * @var $average
 * @var $total
 * @var $percent
 * @var $sale_price
 * @var $price
 * @var $author_id
 */

$author_info = get_post_meta($post_id, 'udemy_visible_instructors', true);
$level = get_post_meta($post_id, 'level', true);
$duration = get_post_meta($post_id, 'duration_info', true);
$lectures = STM_LMS_Course::curriculum_info(get_post_meta($post_id, 'curriculum', true));



?>

<div class="stm_lms_courses__single--info">

	<?php if (!empty($author_info[0])): ?>

        <div class="stm_lms_courses__single--info_author">
            <div class="stm_lms_courses__single--info_author__avatar">
                <img src="<?php echo wp_kses_post($author_info[0]['image_100x100']); ?>" />
            </div>
            <div class="stm_lms_courses__single--info_author__login">
				<?php echo wp_kses_post($author_info[0]['display_name']); ?>
            </div>
        </div>

	<?php endif; ?>

    <div class="stm_lms_courses__single--info_title">
        <a href="<?php the_permalink(); ?>">
            <h4><?php the_title(); ?></h4>
        </a>
    </div>

    <div class="stm_lms_courses__single--info_rate">

		<?php if (!empty($average)): ?>
            <div class="star-rating star-rating__big">
                <span style="width: <?php echo esc_attr($percent); ?>%">
                    <strong class="rating"><?php echo sanitize_text_field($average); ?></strong>
                </span>
            </div>


            <div class="average-rating-stars__av heading_font">
                <strong><?php echo floatval($average) ?></strong> (<?php echo intval($total); ?>)
            </div>
		<?php endif; ?>

		<?php if (!empty($post_status)): ?>
            <div class="stm_lms_courses__single--info_status <?php echo esc_attr($post_status['status']); ?>">
				<?php echo esc_attr($post_status['label']); ?>
            </div>
		<?php endif; ?>

    </div>

    <div class="stm_lms_courses__single--info_excerpt">
		<?php
		echo stm_lms_minimize_word(wp_kses_post(strip_shortcodes(get_the_excerpt())), 150, '...');
		?>
    </div>

    <div class="stm_lms_courses__single--info_meta">
		<?php STM_LMS_Templates::show_lms_template('courses/parts/meta', compact('level', 'duration', 'lectures')); ?>
    </div>

    <div class="stm_lms_courses__single--info_preview">
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="heading_font">
			<?php esc_html_e('Preview this course', 'masterstudy-lms-learning-management-system-pro'); ?>
        </a>
    </div>

    <div class="stm_lms_courses__single--info_bottom">
		<?php STM_LMS_Templates::show_lms_template('global/wish-list', array('course_id' => $post_id)); ?>
		<?php STM_LMS_Templates::show_lms_template('global/price', compact('price', 'sale_price')); ?>
    </div>


</div>