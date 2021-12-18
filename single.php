<?php get_header(); global $detect;?>

	<main role="main" class="main-content">
		<?php get_template_part( 'template-simplehead' );?>
		<?php if(get_field('sidebar')):?><div class="col-f-1 flex flex-space side row-reverse"><?php get_template_part('sidebar');?><div class="col-f-2-3"><?php endif;?>
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" class="wrap-l flex flex-space pad-l">
					<?php if(has_post_thumbnail() || have_rows('snabbinfo') || have_rows('details')):?>
						<div class="<?php if(get_field('sidebar')):?>col-f-1 marg-b-m<?php else:?>col-1-3<?php endif;?>">
							<?php if($detect->isMobile() && !$detect->isTablet()):?>
								<?php the_post_thumbnail('square-size'); ?>
							<?php else:?>
								<?php the_post_thumbnail('large'); ?>
							<?php endif;?>
							<?php if (get_post(get_post_thumbnail_id())->post_excerpt): ?>
								<span class="featured-image-caption">
									<?php echo wp_kses_post(get_post(get_post_thumbnail_id())->post_excerpt); ?>
								</span>
							<?php endif; ?>
							<?php if(have_rows('snabbinfo')): ?>
								<table class="atable col-f-1 marg-t-m"><tbody class="col-f-1">
									<?php while(have_rows('snabbinfo')) : the_row();?>
										<tr class="col-f-1">
											<th><?php the_sub_field('huvud');?></th>
											<?php if(get_sub_field('innehall')):?>
												<td><?php the_sub_field('innehall');?></td>
											<?php endif;?>
											<?php $connect = get_sub_field('kopplat'); if( $connect ): ?>
											<td>
												<?php foreach( $connect as $cn ):?>
													<a href="<?php echo esc_url(get_permalink( $cn->ID));?>">
														<?php echo esc_html(get_the_title($cn->ID));?>
													</a><span>, </span>
												<?php endforeach;?>
											</td>
											<?php endif;?>
										</tr>
									<?php endwhile; ?>
								</tbody></table>
							<?php endif;?>
							<?php if(have_rows('details')): ?>
								<table class="atable col-f-1 marg-t-xs"><tbody class="col-f-1">
									<?php while(have_rows('details')) : the_row();?>
										<tr class="col-f-1">
											<th><?php the_sub_field('huvud');?></th>
											<?php if(get_sub_field('innehall')):?>
												<td><?php the_sub_field('innehall');?></td>
											<?php endif;?>
											<?php $connect = get_sub_field('kopplat'); if( $connect ): ?>
											<td>
												<?php foreach( $connect as $cn ):?>
													<a href="<?php echo esc_url(get_permalink( $cn->ID));?>">
														<?php echo esc_html(get_the_title($cn->ID));?>
													</a><span>, </span>
												<?php endforeach;?>
											</td>
											<?php endif;?>
										</tr>
									<?php endwhile; ?>
								</tbody></table>
							<?php endif;?>
						</div>
					<?php endif;?>
					<div class="col-2-3 textcontent">
						<div class="col-f-1">
							<?php if(get_field('worktit')):?><span class="upper"><?php the_field('worktit');?></span><?php endif;?>
							<?php $classes = get_body_class(); 
							if (in_array('single-post',$classes) || in_array('single-karriar',$classes)) :?>
								<p class="date"><?php the_time('j F Y'); ?> <!--• <?php the_category(', '); ?>--></p>
							<?php endif;?>
							<?php if(have_rows('mail')||have_rows('telefonnummer')): 
								while(have_rows('mail')) : the_row();?>
									<a href="mailto:<?php the_sub_field('adress');?>" class="col-f-1 flex vert-center cntctinfo"><i class="icon-inbox-document-text"></i><span class="col-f-1 beside"><?php the_sub_field('adress');?></span></a>
								<?php endwhile;
								while(have_rows('telefonnummer')) : the_row();?>
									<?php $nmb = get_sub_field('nummer');?>
									<a href="tel:<?php $strip = str_replace('-', '', $nmb); echo preg_replace('/\s+/', '', $strip);?>" class="col-f-1 flex vert-center cntctinfo"><i class="lnr lnr-phone"></i><span class="col-f-1 beside"><?php echo $nmb;?></span></a>
								<?php endwhile; ?>
							<?php endif;?>
							<?php the_content(); ?>
						</div>
						<?php if( have_rows('flexible_content') ): while ( have_rows('flexible_content') ) : the_row();
							get_template_part( 'template-flexible-content' );
						endwhile; endif; ?>
					</div>
				</article>
			<?php endwhile; endif; ?>
		<?php if(get_field('sidebar')):?></div></div><?php endif;?>
	</main>

<?php get_footer(); ?>