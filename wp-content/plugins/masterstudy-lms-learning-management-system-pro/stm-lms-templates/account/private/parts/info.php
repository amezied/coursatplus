<?php
/**
 * @var $current_user
 */

?>

<div class="stm_lms_user_side">

    <div class="stm-lms-user-avatar-edit ">
        <?php $my_avatar = get_user_meta($current_user['id'], 'stm_lms_user_avatar', true); ?>
        <input type="file"/>
        <?php if (!empty($my_avatar)): ?>
            <i class="lnricons-cross delete_avatar"></i>
        <?php endif; ?>
        <i class="lnricons-pencil"></i>
        <?php if (!empty($current_user['avatar'])): ?>
            <div class="stm-lms-user_avatar">
                <?php echo wp_kses_post($current_user['avatar']); ?>
            </div>
        <?php endif; ?>
    </div>

    <h3 class="student_name stm_lms_update_field__first_name"><?php echo esc_attr($current_user['login']); ?></h3>
	<div class="main-bg text-white user-account-sitting-title">
		<i class="fas fa-cogs"></i>
		لوحة التحكم الخاصة بالطالب
	</div>
	
	<ul class="user-account-list">
		<li class="user-account-list-item" data-container-open=".stm_lms_private_information">
			<a href="#">
				<i class="far fa-folder-open"></i>
				الكورسات المسجلة
			</a>
		</li>
		<li class="user-account-list-item open user-account-parent-list-item">
			<a href="#">
				<i class="far fa-user"></i>
				حسابي
			</a>
			<ul class="user-account-list-item-list">
				<li class="user-account-list-item" data-container-open=".stm_lms_edit_account">
					<a href="#">المعلومات الشخصية</a>
				</li>
				<li class="user-account-list-item" data-container-open=".stm_lms_edit_account">
					<a href="#">تغيير الرقم السري</a>
				</li>
			</ul>
		</li>
		<li class="user-account-list-item">
			<a href="<?php echo wp_logout_url('/'); ?>">
				<i class="fas fa-sign-out-alt"></i>
				تسجيل الخروج
			</a>
		</li>
	</ul>

    <!--<div class="stm_lms_profile_buttons_set 2">
        <div class="stm_lms_profile_buttons_set__inner">

            <?php do_action('stm_lms_before_profile_buttons_all', $current_user); ?>

            <?php STM_LMS_Templates::show_lms_template('account/private/parts/messages_btn', array('current_user' => $current_user)); ?>

            <?php STM_LMS_Templates::show_lms_template('account/private/parts/my_certificates_btn', array('current_user' => $current_user)); ?>

            <?php STM_LMS_Templates::show_lms_template('account/private/parts/edit_profile_btn', array('current_user' => $current_user)); ?>

            <?php do_action('stm_lms_after_profile_buttons_all', $current_user); ?>

        </div>
    </div>-->

</div>