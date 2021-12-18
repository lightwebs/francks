<?php get_header(); ?>

	<main role="main" class="main-content">
		<?php if (have_posts()): the_post(); ?>
			<h1><?php _e( 'Författararkiv för ', 'seodr' ); echo get_the_author(); ?></h1>
			<?php if (get_the_author_meta('description')) : echo wpautop(get_the_author_meta('description')); endif; ?>
		<?php rewind_posts(); while (have_posts()) : the_post(); ?>			
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if(has_post_thumbnail()):?>
					<?php the_post_thumbnail('square-size');?>
				<?php endif;?>
				<span class="date"><?php the_time('Y-m-d'); ?></span>
				<h2><?php the_title(); ?></h2>
				<?php echo custom_field_excerpt(); ?>
				<span class="btn btn-primary"><?php the_title(); ?></span>
			</a>
		<?php endwhile; else: endif; ?>
		<?php get_template_part('pagination'); ?>
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
