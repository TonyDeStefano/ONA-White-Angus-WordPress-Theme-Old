<time class="updated" datetime="<?php echo get_the_time('c'); ?>" pubdate>
	<?php echo get_the_date(); ?>
</time>
<p class="byline author vcard">
	<?php echo __('By', 'ona-white-angus'); ?>	<a href="<?php echo esc_attr(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>
</p>
