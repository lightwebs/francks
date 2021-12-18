<aside class="sidebar col-f-1-3 primary-bg" role="complementary">
	<div class="trigger"></div>
	<?php get_sidebar(); ?>
	<?php $classes = get_body_class(); if (in_array('archive',$classes) && !in_array('post-type-archive',$classes)):
		$queried = get_queried_object(); 
		$cmenu = get_field('sidebarmenu',$queried);
		$feat = get_field('kontaktpersoner',$queried, false, false);
	elseif (in_array('post-type-archive-kunskap',$classes)) :
		$cmenu = get_field('faqhead_sidebarmenu','options');
		$feat = get_field('faqhead_kontaktpersoner','options', false, false);
	elseif (in_array('post-type-archive-karriar',$classes)) :
		$cmenu = get_field('carhead_sidebarmenu','options');
		$feat = get_field('carhead_kontaktpersoner','options', false, false);
	elseif (in_array('post-type-archive-referenser',$classes)) :
		$cmenu = get_field('refhead_sidebarmenu','options');
		$feat = get_field('refhead_kontaktpersoner','options', false, false);
	elseif (in_array('post-type-archive-kontakt',$classes)) :
		$cmenu = get_field('konhead_sidebarmenu','options');
		$feat = get_field('konhead_kontaktpersoner','options', false, false);
	elseif (in_array('post-type-archive-applikationer',$classes)) :
		$cmenu = get_field('apphead_sidebarmenu','options');
		$feat = get_field('apphead_kontaktpersoner','options', false, false);
	elseif ( !is_front_page() && is_home() ) :
		$cmenu = get_field('newshead_sidebarmenu','options');
		$feat = get_field('newshead_kontaktpersoner','options', false, false);
	else:
		$cmenu = get_field('sidebarmenu');
		$feat = get_field('kontaktpersoner', false, false);
	endif;?>
	
	<?php if($cmenu):?>
		<?php wp_nav_menu( array( 'menu'=>$cmenu ) );?>
	<?php else:?>
		<?php wp_nav_menu( array( 'theme_location'=>'sidebar-menu' ) );?>
	<?php endif;?>
	
	<span class="menuhead pad-s col-f-1 primary-bg"><?php the_field('kontaktpersonrubrik','options');?></span>
	<div class="col-f-1 flex vert-center cntctpers">
		<div class="imgwrap">
			<?php $cnpc = get_field('kontaktbild','options'); if ($cnpc):?><img loading="lazy" src="<?php echo $cnpc['sizes']['thumbnail']; ?>" alt="<?php echo $cnpc['alt']; ?>" class="bg-img"/><?php endif;?>
		</div>
		<?php echo do_shortcode('[kontorlista]');?>
	</div>
	
	<?php $cntctlink = get_field('kontaktknapp','options'); if($cntctlink): ?>
		<div class="col-f-1 center"><a href="<?php echo $cntctlink['url'];?>" target="<?php echo($cntctlink['target'] ? $cntctlink['target'] : '_self');?>" class="btn btn-line"><?php echo $cntctlink['title'];?></a></div>	
	<?php endif;?>
			
</aside>
