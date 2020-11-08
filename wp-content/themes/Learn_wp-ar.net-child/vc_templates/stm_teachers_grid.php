<?php

extract(shortcode_atts(array(
	'per_page'   => '4',
	'pagination' => 'show',
	'image_size' => 'img-270-180',
	'css'        => ''
), $atts));

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

$paged = get_query_var('paged', 1);

$teachers = new WP_Query(
	array(
		'post_type'      => 'teachers',
		'posts_per_page' => $per_page,
		'paged'          => $paged
	)
);

$image_size = (!empty($image_size)) ? $image_size : 'img-270-180';


stm_module_styles('teachers_grid');
?>

<?php if ($teachers->have_posts()): ?>
    <div class="row">
		<?php while ($teachers->have_posts()): $teachers->the_post(); ?>
			<?php
			$origin_socials = array(
				'facebook',
				'linkedin',
				'twitter',
				'google-plus',
				'youtube-play',
			); ?>
			<?php $job = get_post_meta(get_the_id(), 'expert_sphere', true); ?>
		
<div class="col-xs-12 teacher-col">
                <div class="row teacher_content">
                    <div class="col-md-4">
                        <div class="teacher-side-content">
        
                            <div class="teacher_img">
								<?php if (has_post_thumbnail()){ ?>
                                <?php echo stm_get_VC_attachment_img_safe(get_post_thumbnail_id(), $image_size); ?>
								<?php }else{ ?>
								<img src="https://coursatplus.com/wp-content/plugins/ultimate-member/assets/img/default_avatar.jpg" class="gravatar avatar avatar-215 um-avatar um-avatar-default" alt="" data-default="https://coursatplus.com/wp-content/plugins/ultimate-member/assets/img/default_avatar.jpg" width="140" height="140">
								<?php } ?>
                            </div>
							
                            <h5 class="teach-box-title"><?php the_title(); ?></h5>
                            <?php if (!empty($job)): ?>
                                <div class="job heading_font"><?php echo esc_attr($job); ?></div>
                            <?php endif; ?>
                            <div class="vote-box mt-2">
                                        <span class="vote-icon">
                                            <i class="fas fa-star" aria-hidden="true"></i>
                                            <i class="fas fa-star" aria-hidden="true"></i>
                                            <i class="fas fa-star" aria-hidden="true"></i>
                                            <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                                            <i class="far fa-star" aria-hidden="true"></i>
                                        </span>
                                <span class="vote-number">5.0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="content">
								<h4 class="font-text-bold main-color hide-in-home">يدرس</h4>
								<div class="font-text-medium hide-in-home"><?php the_excerpt(); ?></div>
								<div class="w-100 border-bottom hide-in-home"></div>
								<h4 class="font-text-bold main-color hide-in-home">طرق التدريس</h4>
								<p class="font-text-medium hide-in-home">اونلاين ، بيت الطالب</p>
								<div class="w-100 border-bottom hide-in-home"></div>
								<div class="font-text-medium"><?php the_content(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
		

		<!--
            <div class="col-md-3 col-sm-4 col-xs-6 teacher-col">
                <div class="teacher_content">
					<?php if (has_post_thumbnail()): ?>
                        <div class="teacher_img">
                            <a href="<?php the_permalink(); ?>"
                               title="<?php _e('Watch teacher page', 'masterstudy'); ?>">
                                <?php echo stm_get_VC_attachment_img_safe(get_post_thumbnail_id(), $image_size); ?>
                            </a>
                            <div class="expert_socials clearfix text-center">
                                <div class="display_inline_block">
									<?php foreach ($origin_socials as $social): ?>
										<?php $current_social = get_post_custom_values($social, get_the_id()); ?>
										<?php if (!empty($current_social[0])): ?>
                                            <a class="expert-social-<?php echo esc_attr($social); ?>"
                                               href="<?php echo esc_url($current_social[0]); ?>"
                                               title="<?php echo __('View expert on', 'masterstudy') . ' ' . $social ?>">
                                                <i class="fab fa-<?php echo esc_attr(str_replace('youtube-play', 'youtube', $social)); ?>"></i>
                                            </a>
										<?php endif; ?>
									<?php endforeach; ?>
                                </div>
                            </div>
                        </div>
					<?php endif; ?>
                    <a href="<?php the_permalink(); ?>" title="<?php _e('Watch teacher page', 'masterstudy'); ?>">
                        <h4 class="title"><?php the_title(); ?></h4>
                    </a>
					<?php if (!empty($job)): ?>
                        <div class="job heading_font"><?php echo esc_attr($job); ?></div>
					<?php endif; ?>
                    <div class="content">
						<?php the_excerpt(); ?>
                    </div>
                </div>
                <div class="multiseparator"></div>
            </div>-->
		
		<?php endwhile; ?>
    </div>

	<?php
	if ($pagination === 'show') {
		echo paginate_links(array(
			'type'      => 'list',
			'total'     => $teachers->max_num_pages,
			'prev_text' => '<i class="fa fa-chevron-left"></i><span class="pagi_label">' . __('Previous', 'masterstudy') . '</span>',
			'next_text' => '<span class="pagi_label">' . __('Next', 'masterstudy') . '</span><i class="fa fa-chevron-right"></i>',
		));
	}
	?>

<?php endif; ?>
<?php wp_reset_postdata(); ?>