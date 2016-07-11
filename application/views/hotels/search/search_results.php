<?php if(!empty($list_hotels)):?>
	<?=$sort_by?>
	<?=$list_hotels?>
	<?=$search_paging?>
<?php else:?>
	<div class="alert alert-warning" role="alert">
		<h2><span class="glyphicon glyphicon-warning-sign"></span> <?=lang('lbl_filter_empty')?></h2>
	</div>
<?php endif;?>
