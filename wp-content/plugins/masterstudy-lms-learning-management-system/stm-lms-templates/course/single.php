<?php if( !defined( 'ABSPATH' ) ) exit; //Exit if accessed directly ?>

<?php stm_lms_register_style( 'course' ); ?>
<?php $post_id = get_the_ID(); ?>

<div class="row course-row">
            <div class="col-xs-12 col-md-9">
                <h1 class="stm_lms_course__title"><?php the_title(); ?></h1>
                <p class="page-title-info">
                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                    <span class="main-color">مشرف المادة:</span>
                    <span class="">
					<?php
$teacher_name = get_field('teacher_name');
if( $teacher_name ): ?>
    <?php echo esc_html( $teacher_name->post_title ); ?>
<?php endif; ?>
					</span>
                </p>
            </div>
            <div class="col-xs-12 col-md-3 text-center">
                <a href="#" id="join-course" class="btn btn-block join-course-btn">
                    اشترك في الدورة
		<?php 
			$price = STM_LMS_Course::get_course_price($post_id);
			//$sale_price = STM_LMS_Course::get_sale_price($post_id);
		?>
		<?php if (!empty($price)): ?>
                <span class="btn-prices">
                    <?php if (!empty($price)): ?>
                        <span class="price"><?php echo STM_LMS_Helpers::display_price($price); ?></span>
                    <?php endif; ?>
                </span>
            <?php endif; ?>
		</a>
            </div>
        </div>


<div class="row course-row">
	<div class="col-md-3">

            <?php STM_LMS_Templates::show_lms_template( 'course/sidebar' ); ?>

        </div>

	        <div class="col-md-9">

            <?php STM_LMS_Templates::show_lms_template( 'global/completed_label', array( 'course_id' => get_the_ID() ) ); ?>

            
			
            <?php STM_LMS_Templates::show_lms_template( 'course/parts/panel_info' ); ?>

            
			<?php
$intro = get_field('intro_video',false);
if( !empty($intro) ){ ?>
								
			<video class="intro-video" src="<?php echo $intro; ?>" controls>
				<source type="video/mp4" src="<?php echo $intro; ?>">
			</video>
<?php }else{ ?>
			<div class="stm_lms_course__image">
		<?php the_post_thumbnail('img-870-440'); ?>
	</div>
			<?php } ?>
			
			
			
			<?php STM_LMS_Templates::show_lms_template( 'course/parts/tabs' ); ?>

            <?php
            if( STM_LMS_Options::get_option( 'enable_related_courses', false ) ) {
                STM_LMS_Templates::show_lms_template( 'course/parts/related' );
            }
            ?>

        </div>

        
    </div>

<?php STM_LMS_Templates::show_lms_template( 'course/sticky/panel' ); ?>