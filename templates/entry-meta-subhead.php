<div class="subhead">
    <span class="postauthortop author vcard">
    	<?php echo __('by', 'ona-white-angus'); ?> <span itemprop="author"><a href="<?php echo esc_attr(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="fn" rel="author"><?php echo get_the_author() ?></a></span>
    </span>
    <span class="updated postdate"><?php echo __('on', 'ona-white-angus'); ?> <span class="postday" itemprop="datePublished"><?php echo get_the_date() ?></span></span>
    <span class="postcommentscount"><?php echo __('with', 'ona-white-angus'); ?>
    	<a href="<?php the_permalink();?>#post_comments"><?php comments_number(); ?></a>
    </span>
</div>
<?php //__('No Replies', 'ona-white-angus'), __('1 Reply', 'ona-white-angus'), __('% Replies') ?>