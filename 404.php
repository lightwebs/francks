<?php get_header(); global $detect; ?>

	<main role="main" class="main-content dark-bg">
		<div id="singlehead"></div>
		<article id="post-404" class="wrap-s pad-l content">
				<span class="four-o-four secondary-text">404</span>
				<?php the_field('text404', 'options');?>

				<?php $btn1 = get_field('knapp_1', 'options'); $btn2 = get_field('knapp_2', 'options');?>
				<?php if($btn1):?><a href="<?php echo($btn1['url']);?>" target="<?php echo($btn1['target']);?>" class="btn <?php the_field('knappvariant_1','options');?>"><?php echo($btn1['title']);?></a><?php endif;?>
				<?php if($btn2):?><a href="<?php echo($btn2['url']);?>" target="<?php echo($btn2['target']);?>" class="btn <?php the_field('knappvariant_2','options');?>"><?php echo($btn2['title']);?></a><?php endif;?>

				
		</article>
		<?php $backup = get_field('backuppic','options'); if ($backup):?>
			<img loading="lazy" src="<?php if($detect->isMobile() && !$detect->isTablet()): echo $backup['sizes']['square-size']; else: echo $backup['url']; endif;?>" alt="<?php echo $backup['alt']; ?>" class="bg-img tone"/>
		<?php endif; ?>
	</main>

<?php get_footer(); ?>