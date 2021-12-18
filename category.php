<?php get_header(); ?>

	<main role="main" class="main-content">
		<?php $queried = get_queried_object(); ?>
		<?php get_template_part( 'template-simplehead' );?>
		
		<?php if(get_field('sidebar', $queried)):?><div class="col-f-1 flex flex-space side row-reverse"><?php get_template_part('sidebar');?><div class="col-f-2-3"><?php endif;?>
		<?php if( have_rows('flexible_content', $queried) ): while ( have_rows('flexible_content', $queried) ) : the_row();?>
				<?php get_template_part( 'template-flexible-content' ); ?>
		<?php endwhile; endif; ?>
		<?php if(get_field('sidebar', $queried)):?></div></div><?php endif;?>
	</main>
<?php get_footer(); ?>
