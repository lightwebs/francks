<?php get_header(); ?>

	<main role="main" class="main-content">
		<?php get_template_part( 'template-simplehead' );?>
		
		<div class="col-f-1 center secondary-bg filterbar">
			<p class="kindofhead"><?php _e('Kategorier:', 'seodr');?></p>
			<?php $categories = get_categories( array('orderby' => 'name','order'   => 'ASC') );
			foreach( $categories as $category ):?>
				<a href="<?php echo get_category_link($category->term_id); ?>" class="btn btn-line navig"><?php echo esc_html( $category->name ); ?></a>
			<?php endforeach;?>
		</div>
		<?php if(get_field('newshead_sidebar', 'options')):?><div class="col-f-1 flex flex-space side row-reverse"><?php get_template_part('sidebar');?><div class="col-f-2-3"><?php endif;?>
		<?php if( have_rows('news_flexible_content', 'options') ): while ( have_rows('news_flexible_content', 'options') ) : the_row(); get_template_part( 'template-flexible-content' ); endwhile; endif; ?>
		<?php if(get_field('newshead_sidebar', 'options')):?></div></div><?php endif;?>
	</main>

<?php get_footer(); ?>
