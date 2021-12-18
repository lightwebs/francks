	<footer class="footer secondary-bg" role="contentinfo">
		<div class="main-footer pad">
			<div class="wrap-m flex flex-space">
				<div class="col-1-2 marg-b-xs">
					<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-area-1')) ?>
				</div>
				<div class="col-1-2 flex flex-space">
					<div class="col-1-2">
						<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-area-2')) ?>
					</div>
					<div class="col-1-2">
					<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-area-3')) ?>
				</div>
				</div>		
			</div>
		</div>
		<div class="sub-footer pad-b-s">
			<div class="wrap-m flex horiz-center vert-center">
				<hr>
				<p class="copyright">&copy; Copyright <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
				<hr>
			</div>
		</div>
	</footer>

		<?php wp_footer(); ?>

	</body>
</html>
