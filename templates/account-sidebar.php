<?php
	$current_user = wp_get_current_user();
	if ( 0 == $current_user->ID ) {
    
	} else { ?> 
		<div class="kad-account-sidebar">
				<div class="kad-customer-image">
			   		<?php echo get_avatar($current_user->ID, 120 ); ?>
				</div>
				<div class="kad-customer-name">
					<h5>
		   				<?php echo esc_html($current_user->display_name); ?>
		   			</h5>
		   		</div> 
		   <div class="account_page_menu"> 
			   	<ul class="account-menu">
			   		<li>
			   			<a href="<?php echo wc_customer_edit_account_url(); ?>" class="kad_editlink"> <?php echo __('Edit Account', 'ona-white-angus');?></a>
			   		</li>
			   		<li>
			   			<a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) );?>" class="kad_logoutlink"><?php echo __('Logout', 'ona-white-angus');?></a>
			   		</li>
			   	</ul>
		   </div>
		</div>
<?php }
