<?php global $detect; if( get_row_layout() == 'colsec' ): ?>
<?php $colsize = get_sub_field('colsize');?>
<!--- Cols ---->
    <section class="columns<?php if (($colsize=='onetwo') || ($colsize=='twoone') || ($colsize=='two')):?> half<?php endif;?> wrap-xl <?php the_sub_field('marg');?> <?php the_sub_field('bakgrundsfarg');?> <?php the_sub_field('spec_class');?>">
		<?php $pic = get_sub_field('bakgrundsbild'); if ($pic):?>
			<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['url']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img tone"/>
		<?php endif;?>
		<?php 
			$col1 = get_sub_field('kolumn_1');
			$col2 = get_sub_field('kolumn_2');
			$col3 = get_sub_field('kolumn_3');
			$col4 = get_sub_field('kolumn_4');
		?>
		<div class="<?php the_sub_field('space');?> <?php the_sub_field('wrapping');?> flex flex-space forcolrev <?php if($col2['content']=='Slideshow'):?>containsslide<?php endif;?>">
			
			<!------ Kolumn 1 ------>
			<?php if ($col1['content']=='Text'):?>
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if($colsize=='one'):?>1<?php elseif($colsize=='two'):?>1-2<?php elseif($colsize=='onetwo'):?>1-3<?php elseif($colsize=='twoone'):?>2-3<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif($colsize=='four'):?>1-4<?php endif;?> flex vert-center <?php echo $col1['bakgrundsfarg']; ?>">
					<?php $pic = $col1['bg_1']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img <?php echo $col1['tonad_bild'];?>"/>
					<?php endif;?>
					<div class="<?php if($col1['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?> col-f-1">
						<?php echo $col1['text'];?>
						<?php if($col1['knapp_1']):?>
							<div class="flex col-f-1 <?php echo $col1['knapplacering'];?>">
								<a href="<?php echo($col1['knapp_1']['url']);?>" target="<?php echo($col1['knapp_1']['target'] ? $col1['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col1['knappvariant'];?>"><?php echo($col1['knapp_1']['title']);?></a>
							</div>
						<?php endif;?>
					</div>
				</div>
			<!-- Puff -->
			<?php elseif ($col1['content']=='Puff'):?>
				<a href="<?php echo($col1['knapp_1']['url']);?>" target="<?php echo($col1['knapp_1']['target'] ? $col1['knapp_1']['target'] : '_self');?>" class="puff col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if($colsize=='one'):?>1<?php elseif($colsize=='two'):?>1-2<?php elseif($colsize=='onetwo'):?>1-3<?php elseif($colsize=='twoone'):?>2-3<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif($colsize=='four'):?>1-4<?php endif;?> flex vert-center <?php echo $col1['bakgrundsfarg']; ?>">
					<?php $pic = $col1['bg_1']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img <?php echo $col1['tonad_bild'];?>"/>
					<?php endif;?>
					<div class="col-f-1 content">
						<?php echo $col1['text'];?>
						<div class="flex col-f-1 <?php echo $col1['knapplacering'];?>">
							<span class="btn <?php echo $col1['knappvariant'];?>"><?php echo($col1['knapp_1']['title']);?></span>
						</div>
					</div>
				</a>
			<!-- Bild -->	
			<?php elseif (($col1['content']=='Bild')):?>			
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if($colsize=='one'):?>1<?php elseif($colsize=='two'):?>1-2<?php elseif($colsize=='onetwo'):?>1-3<?php elseif($colsize=='twoone'):?>2-3<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif($colsize=='four'):?>1-4<?php endif;?> content picwrap">
					<?php $pic = $col1['bg_1']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['flowthumb']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
					<?php endif;?>
				</div>
			<!-- Bildspel -->
			<?php elseif ($col1['content']=='Bildspel'):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if($colsize=='one'):?>1<?php elseif($colsize=='two'):?>1-2<?php elseif($colsize=='onetwo'):?>1-3<?php elseif($colsize=='twoone'):?>2-3<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif($colsize=='four'):?>1-4<?php endif;?> <?php if($col1['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?> flex">
					<div id="<?php echo $col1['bildspelsid'];?>" class="bildspel col-f-1">
						<?php $images = $col1['bildspel']; if( $images ): ?>
							<?php foreach( $images as $image_id ): ?>
								<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo esc_url($image_id['sizes']['flowthumb']); else: echo esc_url($image_id['sizes']['large']); endif;?>" alt="<?php echo esc_attr($image_id['alt']); ?>" />
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			<!-- Film -->			
			<?php elseif ($col1['content']=='Film'):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if($colsize=='one'):?>1<?php elseif($colsize=='two'):?>1-2<?php elseif($colsize=='onetwo'):?>1-3<?php elseif($colsize=='twoone'):?>2-3<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif($colsize=='four'):?>1-4<?php endif;?> <?php if($col1['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?>">
					<?php if($col1['film']):?>
						<video width="100%" controls <?php if ($col1['autoplay']==true):?>autoplay muted<?php endif;?>>
							<source src="<?php echo $col1['film'];?>" type="video/mp4">
							<?php $pic = $col1['bg_1']; if ($pic):?>
								<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['flowthumb']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
							<?php endif;?>
						</video>
					<?php else:?>
						<?php $iframe = $col1['video']; preg_match('/src="(.+?)"/', $iframe, $matches); $src = $matches[1];$params = array('controls' => 0,'hd' => 1, 'autohide' => 1); $new_src = add_query_arg($params, $src . '&modestbranding=1&showinfo=0&rel=0'); $iframe = str_replace($src, $new_src, $iframe); $attributes = 'frameborder="0"'; $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);?>
						<div class="embed-container"><?php echo $iframe; ?></div>
					<?php endif; ?>
				</div>
			<?php endif;?> 
			<!------ Kolumn 2 ------>
			<?php if ($col2['content']=='Text'&&$colsize!='one'):?>
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='one'):?>1<?php elseif ($colsize=='two'):?>1-2<?php elseif ($colsize=='onetwo'):?>2-3<?php elseif ($colsize=='twoone'):?>1-3<?php elseif ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif ($colsize=='four'):?>1-4<?php endif;?> flex vert-center <?php echo $col2['bakgrundsfarg']; ?>">
					<?php $pic = $col2['bg_2']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img <?php echo $col2['tonad_bild'];?>"/>
					<?php endif;?>
					<div class="<?php if($col2['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?> col-f-1">
						<?php echo $col2['text'];?>
						<?php if($col2['knapp_1']):?>
							<div class="flex col-f-1 <?php echo $col2['knapplacering'];?>">
								<a href="<?php echo($col2['knapp_1']['url']);?>" target="<?php echo($col2['knapp_1']['target'] ? $col2['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col2['knappvariant'];?>"><?php echo($col2['knapp_1']['title']);?></a>
							</div>
						<?php endif;?>
					</div>
				</div>
			<!-- Puff -->
			<?php elseif ($col2['content']=='Puff'&&$colsize!='one'):?>
				<a href="<?php echo($col2['knapp_1']['url']);?>" target="<?php echo($col2['knapp_1']['target'] ? $col2['knapp_1']['target'] : '_self');?>" class="puff col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='one'):?>1<?php elseif ($colsize=='two'):?>1-2<?php elseif ($colsize=='onetwo'):?>2-3<?php elseif ($colsize=='twoone'):?>1-3<?php elseif ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif ($colsize=='four'):?>1-4<?php endif;?> flex vert-center <?php echo $col2['bakgrundsfarg']; ?>">
					<?php $pic = $col2['bg_2']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img <?php echo $col2['tonad_bild'];?>"/>
					<?php endif;?>
					<div class="col-f-1 content">
						<?php echo $col2['text'];?>
						<div class="flex col-f-1 <?php echo $col2['knapplacering'];?>">
							<span class="btn <?php echo $col2['knappvariant'];?>"><?php echo($col2['knapp_1']['title']);?></span>
						</div>
					</div>
				</a>
			<!-- Bild -->
			<?php elseif (($col2['content']=='Bild'&&$colsize!='one')):?>
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='one'):?>1<?php elseif ($colsize=='two'):?>1-2<?php elseif ($colsize=='onetwo'):?>2-3<?php elseif ($colsize=='twoone'):?>1-3<?php elseif ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif ($colsize=='four'):?>1-4<?php endif;?> content picwrap">
					<?php $pic = $col2['bg_2']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['flowthumb']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
					<?php endif;?>
				</div>
			<!-- Bildspel -->
			<?php elseif ($col2['content']=='Bildspel'&&$colsize!='one'):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='one'):?>1<?php elseif ($colsize=='two'):?>1-2<?php elseif ($colsize=='onetwo'):?>2-3<?php elseif ($colsize=='twoone'):?>1-3<?php elseif ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif ($colsize=='four'):?>1-4<?php endif;?> <?php if($col2['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?> flex">
					<div id="<?php echo $col2['bildspelsid'];?>" class="bildspel col-f-1">
						<?php $images2 = $col2['bildspel2']; if( $images2 ): ?>
							<?php foreach( $images2 as $image_id2 ): ?>
								<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo esc_url($image_id2['sizes']['flowthumb']); else: echo esc_url($image_id2['sizes']['large']); endif;?>" alt="<?php echo esc_attr($image_id2['alt']); ?>" />
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			<!-- Slideshow -->
			<?php elseif ($col2['content']=='Slideshow'&&$colsize!='one'):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if (get_sub_field('colsize')=='two'):?>1-2<?php elseif (get_sub_field('colsize')=='onetwo'):?>2-3<?php elseif (get_sub_field('colsize')=='twoone'):?>1-3<?php endif;?> slidewrap">
					<?php $featured = $col2['slideshow']; if( $featured ): ?>
						<div id="<?php echo $col2['slideid'];?>" class="slideshow col-f-1">
							<?php foreach( $featured as $post ): setup_postdata($post); ?>
								<a href="<?php the_permalink(); ?>" class="slideitem col-f-1 flex flex-end">
									<?php if ( has_post_thumbnail()) : the_post_thumbnail('square-size', array('class'=>'bg-img')); else:?> <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" class="bg-img"/> <?php endif;?>
									<?php $type = get_post_type_object(get_post_type()); ?>
									<div class="posttype white-bg"><?php echo esc_html($type->labels->name);?></div>
									<div class="fadelayer col-f-1 flex flex-space">
										<h2 class="white-text"><?php the_title(); ?></h2>
										<i class="white-text icon-arrow-thin-right"></i>
									</div>
								</a>
							<?php endforeach; ?>
						</div>
					<?php wp_reset_postdata(); endif; ?>
				</div>
			<!-- Film -->			
			<?php elseif ($col2['content']=='Film'&&$colsize!='one'):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='one'):?>1<?php elseif ($colsize=='two'):?>1-2<?php elseif ($colsize=='onetwo'):?>2-3<?php elseif ($colsize=='twoone'):?>1-3<?php elseif ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-4<?php elseif ($colsize=='four'):?>1-4<?php endif;?> <?php if($col2['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?>">
					<?php if($col2['film']):?>
						<video width="100%" controls <?php if ($col2['autoplay']==true):?>autoplay muted<?php endif;?>>
							<source src="<?php echo $col2['film'];?>" type="video/mp4">
							<?php $pic = $col2['bg_2']; if ($pic):?>
								<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['flowthumb']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
							<?php endif;?>
						</video>
					<?php else:?>
						<?php $iframe = $col2['video']; preg_match('/src="(.+?)"/', $iframe, $matches); $src = $matches[1];$params = array('controls' => 0,'hd' => 1, 'autohide' => 1); $new_src = add_query_arg($params, $src . '&modestbranding=1&showinfo=0&rel=0'); $iframe = str_replace($src, $new_src, $iframe); $attributes = 'frameborder="0"'; $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);?>
						<div class="embed-container"><?php echo $iframe; ?></div>
					<?php endif; ?>
				</div>
			<?php endif;?> 
			<!------ Kolumn 3 ------>
			<?php if ($col3['content']=='Text'&&($colsize=='three'||$colsize=='four')):?>
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-2<?php elseif ($colsize=='four'):?>1-4<?php endif;?> flex vert-center <?php echo $col3['bakgrundsfarg']; ?>">
					<?php $pic = $col3['bg_3']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img <?php echo $col3['tonad_bild'];?>"/>
					<?php endif;?>
					<div class="<?php if($col3['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?> col-f-1">
						<?php echo $col3['text'];?>
						<?php if($col3['knapp_1']):?>
							<div class="flex col-f-1 <?php echo $col3['knapplacering'];?>">
								<a href="<?php echo($col3['knapp_1']['url']);?>" target="<?php echo($col3['knapp_1']['target'] ? $col3['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col3['knappvariant'];?>"><?php echo($col3['knapp_1']['title']);?></a>
							</div>
						<?php endif;?>
					</div>
				</div>
			<!-- Puff -->
			<?php elseif ($col3['content']=='Puff'&&($colsize=='three'||$colsize=='four')):?>
				<a href="<?php echo($col3['knapp_1']['url']);?>" target="<?php echo($col3['knapp_1']['target'] ? $col3['knapp_1']['target'] : '_self');?>" class="puff col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-2<?php elseif ($colsize=='four'):?>1-4<?php endif;?> flex vert-center <?php echo $col3['bakgrundsfarg']; ?>">
					<?php $pic = $col3['bg_3']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img <?php echo $col3['tonad_bild'];?>"/>
					<?php endif;?>
					<div class="col-f-1 content">
						<?php echo $col3['text'];?>
						<div class="flex col-f-1 <?php echo $col3['knapplacering'];?>">
							<span class="btn <?php echo $col3['knappvariant'];?>"><?php echo($col3['knapp_1']['title']);?></span>
						</div>
					</div>
				</a>
			<!-- Bild -->
			<?php elseif ($col3['content']=='Bild'&&($colsize=='three'||$colsize=='four')):?>
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-2<?php elseif ($colsize=='four'):?>1-4<?php endif;?> content">
					<?php $pic = $col3['bg_3']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['flowthumb']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
					<?php endif;?>
				</div>
			<!-- Bildspel -->
			<?php elseif ($col3['content']=='Bildspel'&&($colsize=='three'||$colsize=='four')):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-2<?php elseif ($colsize=='four'):?>1-4<?php endif;?> <?php if($col3['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?> flex">
					<div id="<?php echo $col3['bildspelsid'];?>" class="bildspel col-f-1">
						<?php $images3 = $col3['bildspel3']; if( $images3 ): ?>
							<?php foreach( $images3 as $image_id3 ): ?>
								<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo esc_url($image_id3['sizes']['flowthumb']); else: echo esc_url($image_id3['sizes']['large']); endif;?>" alt="<?php echo esc_attr($image_id3['alt']); ?>" />
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			<!-- Film -->			
			<?php elseif ($col3['content']=='Film'&&($colsize=='three'||$colsize=='four')):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?><?php if ($colsize=='three'):?>1-3<?php elseif($colsize=='fourtwo'):?>1-2<?php elseif ($colsize=='four'):?>1-4<?php endif;?> <?php if($col3['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?>">
					<?php if($col3['film']):?>
						<video width="100%" controls <?php if ($col3['autoplay']==true):?>autoplay muted<?php endif;?>>
							<source src="<?php echo $col3['film'];?>" type="video/mp4">
							<?php $pic = $col3['bg_3']; if ($pic):?>
								<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['flowthumb']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
							<?php endif;?>
						</video>
					<?php else:?>
						<?php $iframe = $col3['video']; preg_match('/src="(.+?)"/', $iframe, $matches); $src = $matches[1];$params = array('controls' => 0,'hd' => 1, 'autohide' => 1); $new_src = add_query_arg($params, $src . '&modestbranding=1&showinfo=0&rel=0'); $iframe = str_replace($src, $new_src, $iframe); $attributes = 'frameborder="0"'; $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);?>
						<div class="embed-container"><?php echo $iframe; ?></div>
					<?php endif; ?>
				</div>
			<?php endif;?> 
			<!------ Kolumn 4 ------>
			<?php if ($col4['content']=='Text'&&$colsize=='four'):?>
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?>1-4 flex vert-center <?php echo $col4['bakgrundsfarg']; ?>">
					<?php $pic = $col4['bg_4']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img <?php echo $col4['tonad_bild'];?>"/>
					<?php endif;?>
					<div class="<?php if($col4['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?> col-f-1">
						<?php echo $col4['text'];?>
						<?php if($col4['knapp_1']):?>
							<div class="flex col-f-1 <?php echo $col4['knapplacering'];?>">
								<a href="<?php echo($col4['knapp_1']['url']);?>" target="<?php echo($col4['knapp_1']['target'] ? $col4['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col4['knappvariant'];?>"><?php echo($col4['knapp_1']['title']);?></a>
							</div>
						<?php endif;?>
					</div>
				</div>
			<!-- Puff -->
			<?php elseif ($col4['content']=='Puff'&&$colsize=='four'):?>
				<a href="<?php echo($col4['knapp_1']['url']);?>" target="<?php echo($col4['knapp_1']['target'] ? $col4['knapp_1']['target'] : '_self');?>" class="puff col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?>1-4 flex vert-center <?php echo $col4['bakgrundsfarg']; ?>">
					<?php $pic = $col4['bg_4']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img <?php echo $col4['tonad_bild'];?>"/>
					<?php endif;?>
					<div class="col-f-1 content">
						<?php echo $col4['text'];?>
						<div class="flex col-f-1 <?php echo $col4['knapplacering'];?>">
							<span class="btn <?php echo $col4['knappvariant'];?>"><?php echo($col4['knapp_1']['title']);?></span>
						</div>
					</div>
				</a>
			<!-- Bild -->
			<?php elseif ($col4['content']=='Bild'&&$colsize=='four'):?>
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?>1-4 content">
					<?php $pic = $col4['bg_4']; if ($pic):?>
						<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['flowthumb']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
					<?php endif;?>
				</div>
			<!-- Bildspel -->
			<?php elseif ($col4['content']=='Bildspel'&&$colsize=='four'):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?>1-4 <?php if($col4['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?> flex">
					<div id="<?php echo $col4['bildspelsid'];?>" class="bildspel col-f-1">
						<?php $images = $col4['bildspel'];$size = 'large'; if( $images ): ?>
							<?php foreach( $images as $image_id4 ): ?>
								<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo esc_url($image_id4['sizes']['flowthumb']); else: echo esc_url($image_id4['sizes']['large']); endif;?>" alt="<?php echo esc_attr($image_id4['alt']); ?>" />
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			<!-- Film -->			
			<?php elseif ($col4['content']=='Film'&&$colsize=='four'):?>	
				<div class="col-<?php if (get_sub_field('colspace')==false):?>f-<?php endif;?>1-4 <?php if($col4['bakgrundsfarg']!='none-bg'): ?>content<?php endif;?>">
					<?php if($col4['film']):?>
						<video width="100%" controls <?php if ($col4['autoplay']==true):?>autoplay muted<?php endif;?>>
							<source src="<?php echo $col4['film'];?>" type="video/mp4">
							<?php $pic = $col4['bg_4']; if ($pic):?>
								<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['flowthumb']; else: echo $pic['sizes']['large']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
							<?php endif;?>
						</video>
					<?php else:?>
						<?php $iframe = $col4['video']; preg_match('/src="(.+?)"/', $iframe, $matches); $src = $matches[1];$params = array('controls' => 0,'hd' => 1, 'autohide' => 1); $new_src = add_query_arg($params, $src . '&modestbranding=1&showinfo=0&rel=0'); $iframe = str_replace($src, $new_src, $iframe); $attributes = 'frameborder="0"'; $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);?>
						<div class="embed-container"><?php echo $iframe; ?></div>
					<?php endif; ?>
				</div>
			<?php endif;?> 
		</div>
	</section>
<?php elseif( get_row_layout() == 'iconsec' ): ?>
<?php $colsize = get_sub_field('colsize');?>
<!--- Cols ---->
    <section class="columns wrap-xl <?php the_sub_field('marg');?> <?php the_sub_field('bakgrundsfarg');?> <?php the_sub_field('spec_class');?>">
		<?php $pic = get_sub_field('bakgrundsbild'); if ($pic):?>
			<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['url']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
		<?php endif;?>
		<div class="<?php the_sub_field('space');?> <?php the_sub_field('wrapping');?> flex flex-space iconwrap">
			<?php if(get_sub_field('intro')):?>
				<div class="col-f-1 intro marg-b-xs"><div class="wrap-s"><?php the_sub_field('intro');?></div></div>
			<?php endif;?>
			<?php 
			$col1 = get_sub_field('kolumn_1');
			$col2 = get_sub_field('kolumn_2');
			$col3 = get_sub_field('kolumn_3');
			$col4 = get_sub_field('kolumn_4');
			$col5 = get_sub_field('kolumn_5');
			$col6 = get_sub_field('kolumn_6');
			?>
			<!------ Kolumn 1 ------>
			<div class="col-<?php if($colsize=='one'):?>f-1<?php elseif($colsize=='two'):?>1-2<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='four'):?>1-4<?php elseif($colsize=='five'):?>1-5<?php elseif($colsize=='six'):?>1-6<?php endif;?> center iconitem <?php echo $col1['bakgrundsfarg']; ?>">
				<?php $pic = $col1['bg_1']; if ($pic):?><img loading="lazy" src="<?php echo $pic['sizes']['thumbnail']; ?>" alt="<?php echo $pic['alt']; ?>" class="thumb"/><?php else:?><i class="flex horiz-center vert-center <?php echo $col1['ikon'];?>"></i><?php endif;?>
				<?php echo $col1['text'];?>
				<?php if($col1['knapp_1']):?>
					<div class="col-f-1 center">
						<a href="<?php echo($col1['knapp_1']['url']);?>" target="<?php echo($col1['knapp_1']['target'] ? $col1['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col1['knappvariant'];?>"><?php echo($col1['knapp_1']['title']);?></a>
					</div>
				<?php endif;?>
			</div> 
			<!------ Kolumn 2 ------>
			<?php if ($colsize!='one'):?>
				<div class="col-<?php if($colsize=='two'):?>1-2<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='four'):?>1-4<?php elseif($colsize=='five'):?>1-5<?php elseif($colsize=='six'):?>1-6<?php endif;?> center iconitem <?php echo $col2['bakgrundsfarg']; ?>">
					<?php $pic = $col2['bg_1']; if ($pic):?><img loading="lazy" src="<?php echo $pic['sizes']['thumbnail']; ?>" alt="<?php echo $pic['alt']; ?>" class="thumb"/><?php else:?><i class="flex horiz-center vert-center <?php echo $col2['ikon'];?>"></i><?php endif;?>
					<?php echo $col2['text'];?>
					<?php if($col2['knapp_1']):?>
						<div class="col-f-1 center">
							<a href="<?php echo($col2['knapp_1']['url']);?>" target="<?php echo($col2['knapp_1']['target'] ? $col2['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col2['knappvariant'];?>"><?php echo($col2['knapp_1']['title']);?></a>
						</div>
					<?php endif;?>
				</div>
			<?php endif;?> 
			<!------ Kolumn 3 ------>
			<?php if ($colsize=='three'||$colsize=='four'||$colsize=='five'||$colsize=='six'):?>
				<div class="col-<?php if($colsize=='three'):?>1-3<?php elseif($colsize=='four'):?>1-4<?php elseif($colsize=='five'):?>1-5<?php elseif($colsize=='six'):?>1-6<?php endif;?> center iconitem <?php echo $col3['bakgrundsfarg']; ?>">
					<?php $pic = $col3['bg_1']; if ($pic):?><img loading="lazy" src="<?php echo $pic['sizes']['thumbnail']; ?>" alt="<?php echo $pic['alt']; ?>" class="thumb"/><?php else:?><i class="flex horiz-center vert-center <?php echo $col3['ikon'];?>"></i><?php endif;?>
					<?php echo $col3['text'];?>
					<?php if($col3['knapp_1']):?>
						<div class="col-f-1 center">
							<a href="<?php echo($col3['knapp_1']['url']);?>" target="<?php echo($col3['knapp_1']['target'] ? $col3['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col3['knappvariant'];?>"><?php echo($col3['knapp_1']['title']);?></a>
						</div>
					<?php endif;?>
				</div>
			<?php endif;?> 
			<!------ Kolumn 4 ------>
			<?php if ($colsize=='four'||$colsize=='five'||$colsize=='six'):?>
				<div class="col-<?php if($colsize=='four'):?>1-4<?php elseif($colsize=='five'):?>1-5<?php elseif($colsize=='six'):?>1-6<?php endif;?> center iconitem <?php echo $col4['bakgrundsfarg']; ?>">
					<?php $pic = $col4['bg_1']; if ($pic):?><img loading="lazy" src="<?php echo $pic['sizes']['thumbnail']; ?>" alt="<?php echo $pic['alt']; ?>" class="thumb"/><?php else:?><i class="flex horiz-center vert-center <?php echo $col4['ikon'];?>"></i><?php endif;?>
					<?php echo $col4['text'];?>
					<?php if($col4['knapp_1']):?>
						<div class="col-f-1 center">
							<a href="<?php echo($col4['knapp_1']['url']);?>" target="<?php echo($col4['knapp_1']['target'] ? $col4['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col4['knappvariant'];?>"><?php echo($col4['knapp_1']['title']);?></a>
						</div>
					<?php endif;?>
				</div>
			<?php endif;?> 
			<!------ Kolumn 5 ------>
			<?php if ($colsize=='five'||$colsize=='six'):?>
				<div class="col-<?php if($colsize=='five'):?>1-5<?php elseif($colsize=='six'):?>1-6<?php endif;?> center iconitem <?php echo $col5['bakgrundsfarg']; ?>">
					<?php $pic = $col5['bg_1']; if ($pic):?><img loading="lazy" src="<?php echo $pic['sizes']['thumbnail']; ?>" alt="<?php echo $pic['alt']; ?>" class="thumb"/><?php else:?><i class="flex horiz-center vert-center <?php echo $col5['ikon'];?>"></i><?php endif;?>
					<?php echo $col5['text'];?>
					<?php if($col5['knapp_1']):?>
						<div class="col-f-1 center">
							<a href="<?php echo($col5['knapp_1']['url']);?>" target="<?php echo($col5['knapp_1']['target'] ? $col5['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col5['knappvariant'];?>"><?php echo($col5['knapp_1']['title']);?></a>
						</div>
					<?php endif;?>
				</div>
			<?php endif;?>
			<!------ Kolumn 6 ------>
			<?php if ($colsize=='six'):?>
				<div class="col-1-6 center iconitem <?php echo $col6['bakgrundsfarg']; ?>">
					<?php $pic = $col6['bg_1']; if ($pic):?><img loading="lazy" src="<?php echo $pic['sizes']['thumbnail']; ?>" alt="<?php echo $pic['alt']; ?>" class="thumb"/><?php else:?><i class="flex horiz-center vert-center <?php echo $col6['ikon'];?>"></i><?php endif;?>
					<?php echo $col6['text'];?>
					<?php if($col6['knapp_1']):?>
						<div class="col-f-1 center">
							<a href="<?php echo($col6['knapp_1']['url']);?>" target="<?php echo($col6['knapp_1']['target'] ? $col6['knapp_1']['target'] : '_self');?>" class="btn <?php echo $col6['knappvariant'];?>"><?php echo($col6['knapp_1']['title']);?></a>
						</div>
					<?php endif;?>
				</div>
			<?php endif;?>
			<?php $mainbtn = get_sub_field('knapp_2'); if($mainbtn):?>
				<div class="col-f-1 center marg-t-xs"><a href="<?php echo($mainbtn['url']);?>" target="<?php echo($mainbtn['target'] ? $mainbtn['target'] : '_self');?>" class="btn <?php the_sub_field('knappvariant');?>"><?php echo($mainbtn['title']);?></a></div>
			<?php endif;?>
		</div>
	</section>
<?php elseif( get_row_layout() == 'filter'): ?>
<!--- Inläggsflöde med filtrering ---->
	<section class="columns wrap-xl <?php the_sub_field('marg');?> <?php the_sub_field('bakgrundsfarg');?>">
		<?php $pic = get_sub_field('bakgrundsbild'); if ($pic):?>
			<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['url']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
		<?php endif;?>
		<div class="<?php the_sub_field('space');?> <?php the_sub_field('wrapping');?> flex flex-space">
			<?php if(get_sub_field('intro')):?>
				<div class="col-f-1 intro">
					<?php the_sub_field('intro');?>
				</div>
			<?php endif;?>
			<?php $ptype = get_sub_field('filtercat'); 
			$colsize = get_sub_field('colsize');
			if($colsize=='two'): $c='2'; elseif($colsize=='three'): $c='3'; elseif($colsize=='four'): $c='4'; endif;
			if( $ptype ): ?>
				<div class="filterblock col-f-1 flex">
					<?php foreach( $ptype as $pt): ?>
						<?php if ($pt=='post'): $title = 'Nyheter'; else:
						$p = get_post_type_object( $pt ); $title = $p->labels->name; endif;
						if ($pt=='post'): $btn = get_sub_field('knapptext_aktuellt'); 
						elseif ($pt=='kunskap'): $btn = get_sub_field('knapptext_kunskap');
						elseif ($pt=='karriar'): $btn = get_sub_field('knapptext_karriar');
						elseif ($pt=='referenser'): $btn = get_sub_field('knapptext_referenser'); endif;?>

						<button class="filters btn btn-line" data-filter="<?php echo $pt; ?>"><?php echo $title; ?></button>
						<?php $arr = array('post_type' => $pt, 'posts_per_page' => $c, 'orderby'=>'date', 'order'=>'DESC'); 
						$query = new WP_Query( $arr );?>
						<?php if ($query->have_posts()) : ?>
							<div class="filteritems col-f-1 flex marg-t-m <?php echo $pt;?>">
								<?php while ($query->have_posts()) : $query->the_post();?> 
									<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>" class="col-<?php if($colsize=='two'):?>1-2<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='four'):?>1-4<?php endif;?> marg-b-xs">
										<?php if ( has_post_thumbnail()) : the_post_thumbnail('flowthumb', array('class'=>'col-f-1 marg-b-s')); else:?> <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" class="col-f-1 marg-b-s"/> <?php endif;?>
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
											<p class="more"><span class="text"><?php the_field('las_merknapp','options');?></span> [...]</p>
										<?php elseif( get_field('short')): the_field('short');?>
											<span class="btn btn-secondary"><?php the_field('las_merknapp','options');?></span>
										<?php else: seodr_excerpt('ordinary'); endif;?>
									</a>
								<?php endwhile; wp_reset_postdata(); ?>
								<div class="col-f-1 center">
									<a href="<?php echo get_post_type_archive_link($pt);?>" class="btn btn-primary">
										<?php echo $btn;?>
									</a>
								</div>
							</div>
						<?php endif;?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php elseif( get_row_layout() == 'chosen'): ?>
<!--- Utvalda inlägg ---->
	<section class="columns wrap-xl <?php the_sub_field('marg');?> <?php the_sub_field('bakgrundsfarg');?>">
		<?php $pic = get_sub_field('bakgrundsbild'); if ($pic):?>
			<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['url']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img"/>
		<?php endif;?>
		<div class="<?php the_sub_field('space');?> <?php the_sub_field('wrapping');?> flex flex-space chooseflow">
			<?php if(get_sub_field('intro')):?>
				<div class="col-f-1 intro marg-b-s">
					<?php the_sub_field('intro');?>
				</div>
			<?php endif;?>
			<?php $colsize = get_sub_field('colsize');?>
			<?php $feat = get_sub_field('choose'); if( $feat ): foreach( $feat as $post ): setup_postdata($post); 
				$type = get_post_type_object(get_post_type()); if ($type->name=='kontakt'):?>
					<div title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>" class="col-<?php if($colsize=='two'):?>1-2<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='four'):?>1-4<?php endif;?> marg-b-xs">
				<?php else:?>
					<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>" id="post-<?php the_ID(); ?>" class="col-<?php if($colsize=='two'):?>1-2<?php elseif($colsize=='three'):?>1-3<?php elseif($colsize=='four'):?>1-4<?php endif;?> marg-b-xs">
				<?php endif;?>
					<?php if ($type->name!=='kontakt'):?><div class="posttype white-bg"><?php echo esc_html($type->labels->name);?></div><?php endif;?>
					<?php if ( has_post_thumbnail()) : the_post_thumbnail('flowthumb', array('class'=>'col-f-1 marg-b-s')); else:?> <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" class="col-f-1 marg-b-s"/> <?php endif;?>
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
						<p class="more"><span class="text"><?php the_field('las_merknapp','options');?></span> [...]</p>
					<?php elseif(have_rows('mail')||have_rows('telefonnummer')): 
						while(have_rows('mail')) : the_row();?>
							<a href="mailto:<?php the_sub_field('adress');?>" class="col-f-1 flex vert-center cntctinfo"><i class="icon-inbox-document-text"></i><span class="col-f-1 beside"><?php the_sub_field('adress');?></span></a>
						<?php endwhile;
						while(have_rows('telefonnummer')) : the_row();?>
							<?php $nmb = get_sub_field('nummer');?>
							<a href="tel:<?php $strip = str_replace('-', '', $nmb); echo preg_replace('/\s+/', '', $strip);?>" class="col-f-1 flex vert-center cntctinfo"><i class="lnr lnr-phone"></i><span class="col-f-1 beside"><?php echo $nmb;?></span></a>
						<?php endwhile; ?>
					<?php elseif( get_field('short')): the_field('short');?>
						<span class="btn btn-secondary"><?php the_field('las_merknapp','options');?></span>
					<?php else: seodr_excerpt('ordinary'); endif;?>
					<?php if ($type->name=='kontakt') :?>
						<p class="date col-f-1 marg-t-xs"><?php $categories = get_the_terms(get_the_ID(), 'lan'); $separator = ', '; $output = ''; if (!empty($categories)){$arr = array();foreach($categories as $category){$arr[] = $category->name;}$unique_data = array_unique($arr); foreach($unique_data as $val) {$output.= $val . $separator;}echo trim( $output, $separator );}?></p>
					</div><?php else:?></a><?php endif;?>
			<?php endforeach; wp_reset_postdata(); endif; ?>
			<?php $choosebtn = get_sub_field('knapp_1');
			if($choosebtn):?>
				<div class="col-f-1 center">
					<a href="<?php echo($choosebtn['url']);?>" target="<?php echo($choosebtn['target'] ? $choosebtn['target'] : '_self');?>" class="btn <?php the_sub_field('knappvariant');?>"><?php echo($choosebtn['title']);?></a>
				</div>
			<?php endif;?>
		</div>
	</section>
<?php elseif( get_row_layout() == 'flow'): ?>
<!--- Inläggsflöde ---->
	<section class="four wrap-xl <?php the_sub_field('marg');?> <?php the_sub_field('bakgrundsfarg');?>">
		<div class="flex <?php the_sub_field('space');?> <?php the_sub_field('wrapping');?> flow">
        	<div class="flex col-f-1">
				<?php $classes = get_body_class(); if (in_array('paged',$classes)): get_template_part( 'pagination' ); endif;
				get_template_part('loop'); get_template_part( 'pagination' ); ?>					
			</div>
		</div>
	</section>
<?php elseif( get_row_layout() == 'mapping'): ?>
<!--- Karta & kontakter ---->
	<section class="four wrap-xl <?php the_sub_field('marg');?> <?php the_sub_field('bakgrundsfarg');?>">
		<div class="flex flex-space <?php the_sub_field('space');?> <?php the_sub_field('wrapping');?>">
			<div class="col-f-1-3 center"><?php echo do_shortcode('[map]');?></div>
			<div id="mapfilter" class="filterblock col-f-1-2">
				<h2>Filtrera kontor via kartan</h2>
				<?php $terms = get_terms(array('taxonomy'=>'lan','parent'=>0,'hide_empty'=>0,'orderby'=>'title')); 
				foreach($terms as $ter):?>
					<div class="filteritems col-f-1 marg-t-s <?php echo $ter->slug; ?>">
						<h2 class="col-f-1 blue-text"><?php echo $ter->name;?></h2>
						<?php $cat = get_terms($ter->taxonomy, array('parent'=>$ter->term_id,'orderby'=>'title')); 
						if($cat) : foreach($cat as $t):?>
							<div class="contactblock col-f-1 primary-bg marg-t-s">
								<h3 class="col-f-1"><?php echo $t->name;?></h3>
								<?php $contactcontent = get_field('kontaktinfo',$t);?>		
								<?php echo preg_replace('/class=".*?"/', '', $contactcontent);?>
								<a href="<?php echo get_term_link( $t );?>" class="btn btn-primary">
									<?php the_field('kontorknapp', 'options');?>
								</a>
							</div>
						<?php endforeach; else: ?>
							<?php $backup = get_field('reservkontor', $ter); if( $backup ): ?>
								<?php foreach( $backup as $b ): ?>
									<div class="contactblock col-f-1 primary-bg marg-t-s">
										<h3 class="col-f-1"><?php echo esc_html( $b->name ); ?></h3>
										<?php $contactcontent = get_field('kontaktinfo',$b);?>		
										<?php echo preg_replace('/class=".*?"/', '', $contactcontent);?>
										<a href="<?php echo esc_url(get_term_link($b));?>" class="btn btn-primary">
											<?php the_field('kontorknapp', 'options');?>
										</a>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php endif;?>
					</div>
				<?php endforeach;?>	
			</div>
		</div>
	</section>

<?php endif; ?>