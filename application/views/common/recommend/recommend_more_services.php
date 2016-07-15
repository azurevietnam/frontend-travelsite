<?=$recommend_form_data?>
<div style="line-height: 0px;">&nbsp;</div>			
<?php if(!empty($services)):?>
	<div id="block_search_result_<?=$block_id?>">
		<?php foreach($services as $service):?>
			<?=load_service_recommend_item($service, $service_type, $current_item_info)?>
		<?php endforeach;?>
	
		<div class="text-right" id="ajax_pagination_<?=$block_id?>">
			<p class="showing-results"><b><?=$paging_info['paging_text']?> <?=lang('tours')?></b></p>
			<?=$paging_info['paging_links']?>
		</div>
	</div>
	
	<script type="text/javascript">
		recommend_more_ajax_paging('<?=$block_id?>');
	</script>

<?php else:?>

	<div class="alert alert-warning" role="alert" style="margin-top:15px">
		<h2><span class="glyphicon glyphicon-warning-sign"></span> <?=$service_type == HOTEL ? lang('hotel_search_not_found') : lang('tour_search_not_found')?></h2>
	</div>
	
<?php endif;?>