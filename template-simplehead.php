<?php global $detect; $classes = get_body_class(); if (in_array('archive',$classes) && !in_array('post-type-archive',$classes)):
	$queried = get_queried_object(); 
	$ifpuff = get_field('showpuff',$queried); $puff = get_field('puff',$queried); $pic2 = $puff['bg_1'];
	$bg = get_field('bakgrund',$queried); $pic = $bg['toppbild']; $vid = $bg['video']; $slide = $bg['bildspel'];
	$btn_l = get_field('knapplank',$queried); $btn_2 = get_field('bonusknapp',$queried);
	$btn_v = get_field('knappvariant',$queried);
	if (in_array('category',$classes)):
		$alttitle = get_field('alternativ_sidrubrik',$queried); $title = single_cat_title( "", false );
	else:
		$alttitle = get_field('alternativ_sidrubrik',$queried); $title = single_term_title( "", false );
	endif;
elseif (in_array('post-type-archive-kunskap',$classes)) :
	$ifpuff = get_field('faqhead_showpuff','options'); $puff = get_field('faqhead_puff','options'); 
	$bg = get_field('faqhead_bakgrund','options'); $pic2 = $puff['bg_1'];
	$pic = $bg['toppbild']; $vid = $bg['video']; $slide = $bg['bildspel'];
	$alttitle = get_field('faqhead_alternativ_sidrubrik','options'); $title = post_type_archive_title( '', false );
	$btn_l = get_field('faqhead_knapplank','options'); $btn_v = get_field('faqhead_knappvariant','options');
	$btn_2 = get_field('faqhead_bonusknapp','options');
elseif (in_array('post-type-archive-karriar',$classes)) :
	$ifpuff = get_field('carhead_showpuff','options'); $puff = get_field('carhead_puff','options');
	$bg = get_field('carhead_bakgrund','options'); $pic2 = $puff['bg_1'];
	$pic = $bg['toppbild']; $vid = $bg['video']; $slide = $bg['bildspel'];
	$alttitle = get_field('carhead_alternativ_sidrubrik','options'); $title = post_type_archive_title( '', false );
	$btn_l = get_field('carhead_knapplank','options'); $btn_v = get_field('carhead_knappvariant','options');
	$btn_2 = get_field('carhead_bonusknapp','options');
elseif (in_array('post-type-archive-referenser',$classes)) :
	$ifpuff = get_field('refhead_showpuff','options'); $puff = get_field('refhead_puff','options');
	$bg = get_field('refhead_bakgrund','options'); $pic2 = $puff['bg_1'];
	$pic = $bg['toppbild']; $vid = $bg['video']; $slide = $bg['bildspel'];
	$alttitle = get_field('refhead_alternativ_sidrubrik','options'); $title = post_type_archive_title( '', false );
	$btn_l = get_field('refhead_knapplank','options'); $btn_v = get_field('refhead_knappvariant','options');
	$btn_2 = get_field('refhead_bonusknapp','options');
elseif (in_array('post-type-archive-kontakt',$classes)) :
	$ifpuff = get_field('konhead_showpuff','options'); $puff = get_field('konhead_puff','options');
	$bg = get_field('konhead_bakgrund','options'); $pic2 = $puff['bg_1'];
	$pic = $bg['toppbild']; $vid = $bg['video']; $slide = $bg['bildspel'];
	$alttitle = get_field('konhead_alternativ_sidrubrik','options'); $title = post_type_archive_title( '', false );
	$btn_l = get_field('konhead_knapplank','options'); $btn_v = get_field('konhead_knappvariant','options');
	$btn_2 = get_field('konhead_bonusknapp','options');
elseif (in_array('post-type-archive-applikationer',$classes)) :
	$ifpuff = get_field('apphead_showpuff','options'); $puff = get_field('apphead_puff','options');
	$bg = get_field('apphead_bakgrund','options'); $pic2 = $puff['bg_1'];
	$pic = $bg['toppbild']; $vid = $bg['video']; $slide = $bg['bildspel'];
	$alttitle = get_field('apphead_alternativ_sidrubrik','options'); $title = post_type_archive_title( '', false );
	$btn_l = get_field('apphead_knapplank','options'); $btn_v = get_field('apphead_knappvariant','options');
	$btn_2 = get_field('apphead_bonusknapp','options');
elseif ( !is_front_page() && is_home() ) :
	$ifpuff = get_field('newshead_showpuff','options'); $puff = get_field('newshead_puff','options');
	$bg = get_field('newshead_bakgrund','options'); $pic2 = $puff['bg_1'];
	$pic = $bg['toppbild']; $vid = $bg['video']; $slide = $bg['bildspel'];
	$alttitle = get_field('newshead_alternativ_sidrubrik','options'); $title = 'Aktuellt';
	$btn_l = get_field('newshead_knapplank','options'); $btn_v = get_field('newshead_knappvariant','options');
	$btn_2 = get_field('newshead_bonusknapp','options');
elseif (in_array('search',$classes)) :
	$title = ' " ' . get_search_query() . ' " ';
else:
	$ifpuff = get_field('showpuff'); $puff = get_field('puff'); if ( $puff) $pic2 = $puff['bg_1'];
	$bg = get_field('bakgrund'); $pic = $bg['toppbild']; $vid = $bg['video']; $slide = $bg['bildspel'];
	$alttitle = get_field('alternativ_sidrubrik'); $title = get_the_title();
	$btn_l = get_field('knapplank'); $btn_v = get_field('knappvariant'); $btn_2 = get_field('bonusknapp');
endif;?>

<section class="columns<?php if ($ifpuff):?> half<?php endif;?> wrap-xl flex dark-bg">
	<div id="singlehead" class=" <?php if($ifpuff):?>col-f-2-3<?php else:?>col-f-1<?php endif;?>">
		<div class="wrap-l content">
			<?php if(in_array('search',$classes)): echo sprintf( __('%s sökresultat ', 'seodr'), $wp_query->found_posts);endif;?>
			<?php if($alttitle): echo $alttitle; else:?><h1 class="postheading"><?php echo $title;?> <?php if(get_field('ar_tjansten_tillsatt')):?><span class="obsolete">TILLSATT</span><?php endif;?></h1><?php endif;?>
			<?php if ( !is_front_page() ) :?>
				<div class="col-f-1 flex vert-center">
					<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
				</div>
			<?php endif;?>
			<?php if($btn_l && $btn_2):?><div id="btnwrap" class="col-f-1"><?php endif;?>
				<?php if($btn_l):?>
					<a href="<?php echo $btn_l['url'];?>" target="<?php echo($btn_l['target'] ? $btn_l['target'] : '_self');?>" class="btn <?php echo $btn_v;?>"><?php echo $btn_l['title'];?></a>
				<?php endif;?>
				<?php if($btn_2):?>
					<a href="<?php echo $btn_2['url'];?>" target="<?php echo($btn_2['target'] ? $btn_2['target'] : '_self');?>" class="btn btn-headbonus flex vert-center"><?php if (strpos($btn_2['url'],'you') !== false): echo '<i class="lnr lnr-camera-video"></i>'; endif; echo '<span>' . $btn_2['title'] . '</span>';?></a>
				<?php endif;?>
			<?php if($btn_l && $btn_2):?></div><?php endif;?>
		</div>
		<?php $backup = get_field('backuppic','options'); if ($vid):?>
			<video width="100%" autoplay muted class="bg-img tone">
				<source src="<?php echo $vid;?>" type="video/mp4">
				<?php if ($pic):?>
					<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['url']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img tone"/>
				<?php else:?>
					<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $backup['sizes']['square-size']; else: echo $backup['url']; endif;?>" alt="<?php echo $backup['alt'];?>" class="bg-img tone"/>
				<?php endif;?>
			</video>
		<?php elseif ($slide):?>
			<div id="<?php echo $bg['bildspelsid'];?>" class="bildspel col-f-1 tone">
				<?php foreach( $slide as $image_id ): ?>
					<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo esc_url($image_id['sizes']['square-size']); else: echo esc_url($image_id['url']); endif;?>" alt="<?php echo esc_attr($image_id['alt']); ?>" class="bg-img" />
				<?php endforeach; ?>
			</div>
		<?php elseif ($pic):?>
			<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic['sizes']['square-size']; else: echo $pic['url']; endif;?>" alt="<?php echo $pic['alt']; ?>" class="bg-img tone"/>
		<?php else:?>
			<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $backup['sizes']['square-size']; else: echo $backup['url']; endif;?>" alt="<?php echo $backup['alt'];?>" class="bg-img tone"/>
		<?php endif; ?>
	</div>
	<?php if($ifpuff):?>
		<?php if ($puff['content']=='Text'):?>
		<!-- Text -->
			<div id="headbox" class="col-f-1-3 flex vert-center <?php echo $puff['bakgrundsfarg']; ?>">
				<div class="wrap-l pad-m content">
					<?php echo $puff['text'];?>
					<?php if($puff['knapp_1']):?>
						<div class="flex col-f-1 <?php echo $puff['knapplacering'];?>">
							<a href="<?php echo($puff['knapp_1']['url']);?>" target="<?php echo($puff['knapp_1']['target'] ? $puff['knapp_1']['target'] : '_self');?>" class="btn <?php echo $puff['knappvariant'];?>"><?php echo($puff['knapp_1']['title']);?></a>
						</div>
					<?php endif;?>
				</div>
			</div>
		<?php elseif ($puff['content']=='Puff'):?>
		<!-- Puff -->
			<a href="<?php echo($puff['knapp_1']['url']);?>" target="<?php echo($puff['knapp_1']['target'] ? $puff['knapp_1']['target'] : '_self');?>" class="puff col-f-1-3 flex vert-center <?php echo $puff['bakgrundsfarg']; ?>">
				<?php if ($pic2):?>
					<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic2['sizes']['square-size']; else: echo $pic2['sizes']['large']; endif;?>" alt="<?php echo $pic2['alt']; ?>" class="bg-img <?php echo $puff['tonad_bild'];?>"/>
				<?php endif;?>
				<div class="col-f-1 content">
					<?php echo $puff['text'];?>
					<div class="flex col-f-1 <?php echo $puff['knapplacering'];?>">
						<span class="btn <?php echo $puff['knappvariant'];?>"><?php echo($puff['knapp_1']['title']);?></span>
					</div>
				</div>
			</a>
		<?php elseif ($puff['content']=='Bild'):?>	
		<!-- Bild -->			
			<div class="col-f-1-3 content">
				<?php if ($pic2):?>
					<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic2['sizes']['square-size']; else: echo $pic2['sizes']['large']; endif;?>" alt="<?php echo $pic2['alt']; ?>" class="bg-img"/>
				<?php endif;?>
			</div>
		<?php elseif ($puff['content']=='Bildspel'):?>	
		<!-- Bildspel -->
			<div class="col-f-1-3 content flex">
				<div id="<?php echo $puff['bildspelsid'];?>" class="col-f-1">
					<?php $images = $puff['bildspel']; if( $images ): ?>
						<?php foreach( $images as $image_id ): ?>
							<img data-no-lazy="1" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo esc_url($image_id['sizes']['square-size']); else: echo esc_url($image_id['sizes']['large']); endif;?>" alt="<?php echo esc_attr($image_id['alt']); ?>"/>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>	
		<?php elseif ($puff['content']=='Slideshow'):?>	
		<!-- Slideshow -->
			<div class="col-f-1-3 content flex">
				<?php $featured = $puff['slideshow']; if( $featured ): ?>
					<div id="<?php echo $puff['slideid'];?>" class="col-f-1">
						<?php foreach( $featured as $post ): setup_postdata($post); ?>
							<a href="<?php the_permalink(); ?>" class="slideitem col-f-1">
								<?php if ( has_post_thumbnail()) : the_post_thumbnail('square-size'); else:?> <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp"/> <?php endif;?>
								<h2 class="col-f-1"><?php the_title(); ?></h2>
								<span class="btn btn-primary"><?php the_title();?></span>
							</a>
						<?php endforeach; ?>
					</div>
				<?php wp_reset_postdata(); endif; ?>
			</div>			
		<?php elseif ($puff['content']=='Film'):?>	
		<!-- Film -->	
			<div class="col-f-1-3 content">
				<?php if($puff['film']):?>
					<video width="100%" controls <?php if ($puff['autoplay']==true):?>autoplay muted<?php endif;?>>
						<source src="<?php echo $puff['film'];?>" type="video/mp4">
						<?php if ($pic2):?>
							<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $pic2['sizes']['square-size']; else: echo $pic2['sizes']['large']; endif;?>" alt="<?php echo $pic2['alt']; ?>" class="bg-img"/>
						<?php endif;?>
					</video>
				<?php else:?>
					<?php $iframe = $puff['video']; preg_match('/src="(.+?)"/', $iframe, $matches); $src = $matches[1];$params = array('controls' => 0,'hd' => 1, 'autohide' => 1); $new_src = add_query_arg($params, $src . '&modestbranding=1&showinfo=0&rel=0'); $iframe = str_replace($src, $new_src, $iframe); $attributes = 'frameborder="0"'; $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);?>
					<div class="embed-container"><?php echo $iframe; ?></div>
				<?php endif; ?>
			</div>
		<?php endif;
	endif;?> 
</section>