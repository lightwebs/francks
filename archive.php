<?php get_header(); ?>
<?php $classes = get_body_class();?>

	<main role="main" class="main-content">
		<?php get_template_part( 'template-simplehead' );?>
		
		<?php if ((!in_array('post-type-archive-kontakt',$classes)) && (!in_array('post-type-archive-kunskap',$classes)) ) :?>
			<?php $tax = $wp_query->get_queried_object(); $terms = get_object_taxonomies($tax->name); if($terms):?>
			<div class="col-f-1 center secondary-bg filterbar">
				<p class="kindofhead"><?php _e('Kategorier:', 'seodr');?></p>
				 <?php foreach($terms as $term): $tt = get_terms($term, array('orderby' => 'term_order', 'parent' => $tax->term_id, 'hide_empty'=>false));
				foreach ( $tt as $t ) : ?>
					<a href="<?php echo get_term_link($t->term_id); ?>" class="btn btn-line navig"><?php echo $t->name; ?></a>
				<?php endforeach;endforeach;?>
			</div>
		<?php endif; endif;?>
		
		<?php if (in_array('post-type-archive-kunskap',$classes)) :?>
			<!-- Kyl-och värmeskola -->
			<?php if(get_field('faqhead_sidebar', 'options')):?><div class="col-f-1 flex flex-space side row-reverse"><?php get_template_part('sidebar');?><div class="col-f-2-3"><?php endif;?>
			<?php if( have_rows('faq_flexible_content', 'options') ): while ( have_rows('faq_flexible_content', 'options') ) : the_row(); get_template_part('template-flexible-content'); endwhile; endif; ?>
			<?php if(get_field('faqhead_sidebar', 'options')):?></div></div><?php endif;?>
		<?php elseif (in_array('post-type-archive-karriar',$classes)) :?>
			<!-- Karriär -->
			<?php if(get_field('carhead_sidebar', 'options')):?><div class="col-f-1 flex flex-space side row-reverse"><?php get_template_part('sidebar');?><div class="col-f-2-3"><?php endif;?>
			<?php if( have_rows('car_flexible_content', 'options') ): while ( have_rows('car_flexible_content', 'options') ) : the_row(); get_template_part('template-flexible-content'); endwhile; endif; ?>
			<?php if(get_field('carhead_sidebar', 'options')):?></div></div><?php endif;?>
		<?php elseif (in_array('post-type-archive-referenser',$classes)) :?>
			<!-- Referenser -->
			<?php if(get_field('refhead_sidebar', 'options')):?><div class="col-f-1 flex flex-space side row-reverse"><?php get_template_part('sidebar');?><div class="col-f-2-3"><?php endif;?>
			<?php if( have_rows('ref_flexible_content', 'options') ): while ( have_rows('ref_flexible_content', 'options') ) : the_row(); get_template_part('template-flexible-content'); endwhile; endif; ?>
			<?php if(get_field('refhead_sidebar', 'options')):?></div></div><?php endif;?>
		<?php elseif (in_array('post-type-archive-kontakt',$classes)) :?>
			<!-- Kontakt -->
			<?php if(get_field('konhead_sidebar', 'options')):?><div class="col-f-1 flex flex-space side row-reverse"><?php get_template_part('sidebar');?><div class="col-f-2-3"><?php endif;?>
			<?php if( have_rows('kon_flexible_content', 'options') ): while ( have_rows('kon_flexible_content', 'options') ) : the_row(); get_template_part('template-flexible-content'); endwhile; endif; ?>
			<?php if(get_field('konhead_sidebar', 'options')):?></div></div><?php endif;?>
		<?php elseif (in_array('post-type-archive-applikationer',$classes)) :?>
			<!-- Applikationer -->
			<?php if(get_field('apphead_sidebar', 'options')):?><div class="col-f-1 flex flex-space side row-reverse"><?php get_template_part('sidebar');?><div class="col-f-2-3"><?php endif;?>
			<?php if( have_rows('app_flexible_content', 'options') ): while ( have_rows('app_flexible_content', 'options') ) : the_row(); get_template_part('template-flexible-content'); endwhile; endif; ?>
			<?php if(get_field('apphead_sidebar', 'options')):?></div></div><?php endif;?>
		<?php endif;?>
		<!--end-->
	</main>

<?php get_footer(); ?>
