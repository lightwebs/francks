<!--<div class="pagination col-f-1 flex horiz-center pad-xs marg-b-xs">-->
<div class="pagination col-f-1 flex marg-b-s">
	<div id="hidepag" class="col-f-1"><?php seodr_pagination();?></div>
	<?php if ($wp_query->max_num_pages > 1) echo '<button class="btn btn-line wrap-xxs misha_loadmore">Ladda fler ...</div>';?>
</div>