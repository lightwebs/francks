<?php get_header(); global $detect; ?>

	<main role="main" class="main-content">
		<?php get_template_part( 'template-simplehead' );?>
		<div class="col-f-1 flex flex-space side row-reverse">
			<?php $bar = get_field('sidebar');?>
			<?php $abtn = get_field('knappen');?>
			<?php $hh = get_field('rubriken');?>
			<?php if($bar): get_template_part('sidebar'); else:?><div class="wrap-l flex flex-space"><?php endif;?>
				<div class="col-2-3">
					<?php if($hh):?><div class="col-f-1 flex flex-space marg-t-l">
						<div class="<?php if($abtn):?>col-f-2-3<?php else:?>col-f-1<?php endif;?>"><?php echo $hh;?></div>
						<?php if ($abtn): ?>
						<div class="col-1-3 flex flex-end vert-start"><a href="<?php echo $abtn['url'];?>" target="<?php echo $abtn['target'] ? $abtn['target'] : '_self';?>" class="btn btn-primary"><?php echo $abtn['title'];?></a></div><?php endif;?>
					</div><?php endif;?>
					<?php if(has_post_thumbnail() && ($hh || get_field('brod'))):?><div class="col-f-1 content picwrap limit marg-t-m">
						<?php if($detect->isMobile() && !$detect->isTablet()):?>
								<?php the_post_thumbnail('flowthumb', array('class'=>'col-f-1'));?>
						<?php else:?>
							<?php the_post_thumbnail('custom-size', array('class'=>'col-f-1'));?>
						<?php endif;?>		
					</div><?php endif;?>
				</div>
			<?php if(!get_field('sidebar')):?>
			</div><?php endif;?>
		</div>
		<?php if(get_field('brod')):?>
			<div class="col-f-1 marg-t-l wrap-m flex flex-space">
				<?php if(get_field('brod')):?>
					<?php if(get_field('brod_2')):?>
						<div class="col-1-2">
					<?php else:?>
						<div class="wrap-m">
					<?php endif;?>
							<?php the_field('brod');?>
						</div>
				<?php endif;?>
				<?php if(get_field('brod_2')):?>
					<div class="col-1-2"><?php the_field('brod_2');?></div>
				<?php endif;?>
			</div>
		<?php endif;?>
		<div class="col-f-1 flex flex-space">
			<?php if(have_rows('tabbar')):?>
				<section class="tab-section wrap-xl pad">
					<ul class="tabs wrap-l flex">
						<?php while(have_rows('tabbar')) : the_row();?>
							<li class="tab-item b-bg white-text flex vert-center horiz-center center">
								<?php the_sub_field('tabbrubrik'); ?>
							</li>
						<?php endwhile;?>
					</ul>
					<div class="tab-content-outer wrap-l secondary-bg pad">
						<?php while(have_rows('tabbar')) : the_row();?>
							<div class="tab-content tab-content-info wrap-l">
								<?php $feat = get_sub_field('valda_inlagg'); if( $feat ): ?>
									<div class="tabslide col-f-1">
										<?php foreach( $feat as $post ): setup_postdata($post); 
											$type = get_post_type_object(get_post_type()); if ($type->name=='kontakt'):?>
												<div title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>" class="col-1-4 slideitem"><?php else:?><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>" class="col-1-4 slideitem"><?php endif;?>
												
												<?php if ($type->name!=='kontakt' && $type->name!=='kunskap'):?><div class="posttype white-bg"><?php echo esc_html($type->labels->name);?></div><?php endif;?>
												<?php if ($type->name!=='kunskap'):?><?php if ( has_post_thumbnail()) : the_post_thumbnail('flowthumb', array('class'=>'col-f-1 marg-b-xs')); else:?> <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" class="col-f-1 marg-b-xs"/> <?php endif;endif;?>
												<?php if(get_field('worktit')):?><span class="upper"><?php the_field('worktit');?></span><?php endif;?>
												<h3 class="col-f-1 postheading"><?php the_title(); ?><?php if(get_field('ar_tjansten_tillsatt')):?><span class="obsolete">TILLSATT</span><?php endif;?></h3>
												<?php if(have_rows('snabbinfo')): ?>
													<table class="atable col-f-1"><tbody class="col-f-1">
														<?php while(have_rows('snabbinfo')) : the_row();?>
															<tr class="col-f-1">
																<th><?php the_sub_field('huvud');?></th>
																<?php if(get_sub_field('innehall')):?><td><?php the_sub_field('innehall');?></td><?php endif;?>
																<?php $connect = get_sub_field('kopplat'); if( $connect ): ?>
																<td>
																	<?php foreach( $connect as $cn ):
																		 echo get_the_title( $cn->ID ) . '<span>, </span>';
																	endforeach;?>
																</td>
																<?php endif;?>
															</tr>
														<?php endwhile; ?>
													</tbody></table>
													<p class="more"><span class="text">Läs mer</span> [...]</p>
												<?php elseif(have_rows('mail')||have_rows('telefonnummer')): 
													while(have_rows('mail')) : the_row();?>
														<a href="mailto:<?php the_sub_field('adress');?>" class="col-f-1 flex vert-center cntctinfo"><i class="icon-inbox-document-text"></i><span class="col-f-1"><?php the_sub_field('adress');?></span></a>
													<?php endwhile;
													while(have_rows('telefonnummer')) : the_row();?>
														<?php $nmb = get_sub_field('nummer');?>
														<a href="tel:<?php $strip = str_replace('-', '', $nmb); echo preg_replace('/\s+/', '', $strip);?>" class="col-f-1 flex vert-center cntctinfo"><i class="lnr lnr-phone"></i><span class="col-f-1"><?php echo $nmb;?></span></a>
													<?php endwhile; ?>
												<?php elseif( get_field('short')): echo '<span class="col-f-1">'; the_field('short'); echo '</span>';?>
													<span class="btn btn-line"><?php _e('Läs mer', 'seodr');?></span>
												<?php else: seodr_excerpt('ordinary'); endif;?>
												<?php if ($type->name=='kontakt') :?>
													<p class="date col-f-1 marg-t-xs"><?php $categories = get_the_terms(get_the_ID(), 'lan'); $separator = ', '; $output = ''; if (!empty($categories)){$arr = array();foreach($categories as $category){$arr[] = $category->name;}$unique_data = array_unique($arr); foreach($unique_data as $val) {$output.= $val . $separator;}echo trim( $output, $separator );}?></p>
												</div><?php else:?></a><?php endif;?>
										<?php endforeach; wp_reset_postdata(); ?>
									</div>
								<?php endif;?>	
								<?php if(get_sub_field('textinnehall')):?><div class="col-f-1 atext"><?php the_sub_field('textinnehall');?></div><?php endif;?>
							</div>
						<?php endwhile; ?>
					</div>
				</section>
			<?php endif;?>
		</div>
		
		<?php if( have_rows('flexible_content') ): while ( have_rows('flexible_content') ) : the_row();
			get_template_part( 'template-flexible-content' );
		endwhile; endif; ?>
	</main>

<?php get_footer(); ?>
