<div class="stm_lms_courses__single--title">
	<a href="<?php the_permalink(); ?>">
		<h5><?php the_title(); ?></h5>
	</a>
	<?php
$university = get_field('university',false);
$select_university = get_field('select_university',false);
	$branch = get_field('branch');
if( $university ): ?>
		<p class="stm_lms_courses__single--sub-title">
			(
			<?php echo $university; ?>
			-
			<?php echo $branch; ?>
			)
	</p>
<?php endif; ?>
	</div>