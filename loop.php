<?php $pType = get_post_type_object(get_post_type());?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	<?php if(!get_field('ar_tjansten_tillsatt')):?>
		<article class="col-1-3 marg-b-s <?php echo $pType->name;?> <?php if ($pType->name=='kontakt') :?>rounded cntctloop<?php endif;?>">
			<?php if ($pType->name=='kontakt') :?>
				<div class="col-f-1" title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>">
			<?php else:?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>" <?php post_class(array('class'=>'col-f-1')); ?>>
			<?php endif;?>
					<?php if ( has_post_thumbnail()) : the_post_thumbnail('flowthumb', array('class'=>'marg-b-s')); else: if ($pType->name!='kontakt' && $pType->name!='kunskap'):?><img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" class="col-f-1 marg-b-s"/> <?php endif; endif;?>

					<?php if (($pType->name=='post') || ($pType->name=='karriar')) :?>
						<p class="date col-f-1"><?php the_time('j F Y'); ?> • <?php if ($pType->name=='post'): $categories = get_the_category(); elseif ($pType->name=='karriar'): echo $pType->label; else: $categories = get_the_terms(get_the_ID(), 'typ'); endif; $separator = ', '; $output = ''; if (!empty($categories)){foreach($categories as $category){$output.= esc_html($category->name ) . $separator;}echo trim( $output, $separator );}?></p>
					<?php endif;?>	
					<?php if(get_field('worktit')):?><span class="upper"><?php the_field('worktit');?></span><?php endif;?>
					<h2 class="col-f-1 postheading"><?php the_title(); ?><?php if(get_field('ar_tjansten_tillsatt')):?><span class="obsolete">TILLSATT</span><?php endif;?></h2>
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
							<a href="mailto:<?php the_sub_field('adress');?>" class="col-f-1 flex vert-center cntctinfo"><i class="icon-inbox-document-text"></i><span class="col-f-1 beside"><?php the_sub_field('adress');?></span></a>
						<?php endwhile;
						while(have_rows('telefonnummer')) : the_row();?>
							<?php $nmb = get_sub_field('nummer');?>
							<a href="tel:<?php $strip = str_replace('-', '', $nmb); echo preg_replace('/\s+/', '', $strip);?>" class="col-f-1 flex vert-center cntctinfo"><i class="lnr lnr-phone"></i><span class="col-f-1 beside"><?php echo $nmb;?></span></a>
						<?php endwhile; ?>
					<?php elseif( get_field('short')): 
						echo '<span class="col-f-1">'; the_field('short'); echo '</span>';?>
						<span class="clear btn btn-secondary"><?php _e('Läs mer', 'seodr');?></span>
					<?php else: seodr_excerpt('ordinary'); endif;?>
					<?php if ($pType->name=='kontakt') :?>
						<p class="date col-f-1 marg-t-xs"><?php $categories = get_the_terms(get_the_ID(), 'lan'); $separator = ', '; $output = ''; if (!empty($categories)){$arr = array();foreach($categories as $category){$arr[] = $category->name;}$unique_data = array_unique($arr); foreach($unique_data as $val) {$output.= $val . $separator;}echo trim( $output, $separator );}?></p>
					</div><?php else:?></a><?php endif;?>
		</article>
	<?php endif;?>

<?php endwhile; else: ?>

	<?php $classes = get_body_class(); $queried = get_queried_object(); 
	if (in_array('tax-lan',$classes)) : $backup = get_field('reservkontor', $queried); if( $backup ): foreach( $backup as $b ):
		$contacts = array(
			'post_type' => 'kontakt',
			'posts_per_page' => -1,
			'tax_query' => array(
			array('taxonomy' => 'lan', 'terms' => $b,),
			),
		);
		$posts = new WP_Query($contacts);?>

		<?php if ($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
			<article class="col-1-3 marg-b-s kontakt rounded cntctloop">
				<div class="col-f-1" title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>">
					<span class="upper"><?php the_field('worktit');?></span>
					<h2 class="col-f-1 postheading"><?php the_title(); ?></h2>
						<?php if(have_rows('mail')||have_rows('telefonnummer')): 
							while(have_rows('mail')) : the_row();?>
								<a href="mailto:<?php the_sub_field('adress');?>" class="col-f-1 flex vert-center cntctinfo"><i class="icon-inbox-document-text"></i><span class="col-f-1 beside"><?php the_sub_field('adress');?></span></a>
							<?php endwhile;
							while(have_rows('telefonnummer')) : the_row();?>
								<?php $nmb = get_sub_field('nummer');?>
								<a href="tel:<?php $strip = str_replace('-', '', $nmb); echo preg_replace('/\s+/', '', $strip);?>" class="col-f-1 flex vert-center cntctinfo"><i class="lnr lnr-phone"></i><span class="col-f-1 beside"><?php echo $nmb;?></span></a>
							<?php endwhile; ?>
						<?php endif;?>
						<p class="date col-f-1 marg-t-xs"><?php $categories = get_the_terms(get_the_ID(), 'lan'); $separator = ', '; $output = ''; if (!empty($categories)){$arr = array();foreach($categories as $category){$arr[] = $category->name;}$unique_data = array_unique($arr); foreach($unique_data as $val) {$output.= $val . $separator;}echo trim( $output, $separator );}?></p>
				</div>
			</article>
		<?php endwhile; endif;?>

	<?php endforeach; wp_reset_postdata(); endif; endif; ?>	

<?php endif; ?>
