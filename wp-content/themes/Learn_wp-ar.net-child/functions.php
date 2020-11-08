    <?php
    add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
    function enqueue_parent_styles() {
       wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    }

add_filter("um_confirm_user_password_form_edit_field","um_user_password_form_edit_field", 10, 2 );
add_filter("um_user_password_form_edit_field","um_user_password_form_edit_field", 10, 2 );
function um_user_password_form_edit_field( $output, $set_mode ){
    
    ob_start();
    ?>
    <div id='um-field-show-passwords' style='text-align:right;display:block;'>
    	
    	<a href='#'><i class='um-faicon-eye-slash'></i>
			<!--<?php _e("Show password","ultimate-member"); ?>-->
		</a>
    </div>
    <script type='text/javascript'>
	    jQuery('#um-field-show-passwords a').click(function(){ 
		    
		    jQuery(this).parent("div").find("i").toggleClass(function() {
		    	if ( jQuery( this ).hasClass( "um-faicon-eye-slash" ) ) {
	                //jQuery( this ).parent("div").find("a").text('<?php _e("Hide password","ultimate-member"); ?>');
		    		jQuery( this ).removeClass( "um-faicon-eye-slash" )
		    		jQuery(".um-form").find(".um-field-password").find("input[type=password]").attr("type","text");
		    	   return "um-faicon-eye";
			    }
				 
				jQuery( this ).removeClass( "um-faicon-eye" );
				//jQuery( this ).parent("div").find("a").text('<?php _e("Show password","ultimate-member"); ?>');
			    jQuery(".um-form").find(".um-field-password").find("input[type=text]").attr("type","password");
			  
                return "um-faicon-eye-slash";
			});

		    return false; 

		});
	</script>
    <?php 
	return $output.ob_get_clean();

}
?>