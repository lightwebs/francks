<?php get_header(); ?>

	<main role="main" class="main-content">
		<?php get_template_part( 'template-simplehead' );?>
		<section class="wrap flow flex pad">
			<?php get_template_part('loop'); ?>
			<?php get_template_part('pagination'); ?>
		</section>
	</main>

<?php get_footer(); ?>
