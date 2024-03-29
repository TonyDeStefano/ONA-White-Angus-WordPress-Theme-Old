<?php get_header(); 
 	get_template_part('templates/page', 'header'); ?>
	
   		<div id="content" class="container">
   			<div class="row">
      			<div class="main <?php echo esc_attr( pinnacle_main_class() ); ?> kad_404_page" role="main">
  					<h4 class="sectiontitle"><?php _e('Sorry, but the page you were trying to view does not exist.', 'ona-white-angus'); ?></h4>

						<p><?php _e('It looks like this was the result of either:', 'ona-white-angus'); ?></p>
							<ul>
								  <li><?php _e('a mistyped address', 'ona-white-angus'); ?></li>
								  <li><?php _e('an out-of-date link', 'ona-white-angus'); ?></li>
								  <li><?php _e('incorrect permalink settings', 'ona-white-angus'); ?></li>
							</ul>
						<p><?php _e("You can return back to the site's homepage and see if you can find what you are looking for or use the search form below.", 'one-white-angus'); ?></p>
						<div class="search_form_404"><?php get_search_form(); ?></div>
				</div>
				<?php get_sidebar(); ?>
      		</div><!-- /.row-->
    	</div><!-- /.content -->
  	</div><!-- /.wrap -->
  	<?php get_footer(); ?>