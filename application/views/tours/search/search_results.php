<h1 class="text-highlight">
	<?='<b>'.$cnt_total_results.'</b>'.($cnt_total_results > 1 ? ' '.lang('label_tours') : ' '.lang('label_tour'))?>
  	<?=lang_arg('label_search_results_summary', $search_criteria['destination'], date(DATE_FORMAT_DISPLAY, strtotime($search_criteria['departure_date'])))?>
  	<?php if(has_filters($search_criteria)):?>
  		<small class="text-highlight"><?=lang('label_match_following_filters')?></small>
  	<?php endif;?>	 	
</h1>

<?=isset($filtered_items) ? $filtered_items : ''?>

<?php if(!empty($list_tours)):?>
	<?=$sort_by?>
	<?=$list_tours?>
	<?=$search_paging?>
<?php else:?>
	<div class="alert alert-warning" role="alert">
		<h2><span class="glyphicon glyphicon-warning-sign"></span> <?=lang('lbl_filter_empty')?></h2>
	</div>
<?php endif;?>
