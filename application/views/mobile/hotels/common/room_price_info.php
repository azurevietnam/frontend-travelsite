<?php 
	$basic_rates =  $room_rate['basic_rate'];
?>
<a href="javascript:void(0)"
	id="price_detail_<?=get_room_rate_id($room_rate)?>"> 
	<?=lang('price_detail')?>
</a>

<div id="price_detail_title_<?=get_room_rate_id($room_rate)?>" style="display: none">
	<b><?=lang('price_detail').' '.$room_rate['name']?></b>
	<span onclick="$('#price_detail_<?=get_room_rate_id($room_rate)?>').popover('hide');" class="icon btn-support-close"></span>
</div>

<div id="price_detail_content_<?=get_room_rate_id($room_rate)?>" style="display: none">
	<p><?=lang('price_detail_by_day')?>:</p>
	<table class="table table-bordered" style="min-width:280px">
      	<?php foreach($rate as $key=>$value):?>
      		<tr>
      			<td width="40%" style="vertical-align:middle;">
      				<?=format_bpv_date($key,DATE_FORMAT, true)?>
      			</td>
      			
      			<td>
      				<?php if($basic_rates[$room_rate['occupancy']][$key] > 0 && $value == 0):?>
      					<span class="bpv-price-from"><?=lang('free')?></span>
      				<?php else:?>
      				
		      			<?php if($value != $basic_rates[$room_rate['occupancy']][$key]):?>
		      				<span class="bpv-price-origin"><?=bpv_format_currency($basic_rates[$room_rate['occupancy']][$key])?></span>
		      				&nbsp;
		      			<?php endif;?>
	      				<span class="bpv-price-from"><b><?=bpv_format_currency($value)?></b></span>
      				
      				<?php endif;?>
	      		</td>
      		</tr>
      	<?php endforeach;?>
	</table>	
</div>

<script type="text/javascript">
	$('#price_detail_<?=get_room_rate_id($room_rate)?>').popover(
			{'html':true,
			'trigger':'click',
			'title':$('#price_detail_title_<?=get_room_rate_id($room_rate)?>').html(), 
			'content':$('#price_detail_content_<?=get_room_rate_id($room_rate)?>').html(),
			'placement':'bottom'}
	);
</script>