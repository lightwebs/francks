<form class="search col-f-1 pad-m primary-bg flex horiz-center vert-center" method="get" action="<?php echo home_url(); ?>" role="search">
	<input class="search-input" type="search" name="s" placeholder="<?php the_field('placeholder', 'options'); ?>">
	<button class="search-submit btn btn-line" type="submit" role="button"><?php the_field('searchbtntext', 'options'); ?></button>
</form>
