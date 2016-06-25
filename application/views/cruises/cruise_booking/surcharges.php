<?php if(count($surcharges)> 0):?>
	<p><?=lang('cb_surcharge_note')?></p>
	<div class="bpv-rate-table clearfix margin-bottom-20 clearfix">		
	<table>
		<thead>
			<tr>
				<td align="center" class="col-surcharge-name"><?=lang('cb_surcharge_name')?></td>
				<td align="center" class="col-extra-bed"><?=lang('cb_surcharge_unit')?></td>
				<td align="center" class="col-condition"><?=lang('cb_surcharge_apply')?></td>
				<td align="center" class="col-total-price"><?=lang('cb_surcharge_total')?></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($surcharges as $sur):?>
			<tr>
				<td>
					<div id="sur_desc_<?=$sur['id']?>" style="display:none">
						<?=$sur['description']?>
					</div>
					<div>
						<b><?=$sur['name']?></b>
						
						<?php if($sur['description'] != ''):?>
						
							<a href="javascript:void(0)" style="font-size:11px" id="sur_detail_<?=$sur['id']?>">(<?=lang('cb_view_detail')?>)</a>
							
								<script type="text/javascript">
									$('#sur_detail_<?=$sur['id']?>').popover(
											{'html':true,
											'trigger':'hover',
											'title':"<?=$sur['name']?>", 
											'content':$('#sur_desc_<?=$sur['id']?>').html(),
											'placement':'bottom'}
									);
								</script>
											
						<?php endif;?>
					</div>
					
					
				</td>
				<td align="center" nowrap="nowrap" style="text-align: center;">
					<?php if($sur['charge_type'] == SUR_PER_ADULT_PER_BOOKING):?>
						<b><?=bpv_format_currency($sur['adult_amount'])?></b> /<?=strtolower(lang('adult_label'))?>
						
						<?php if( !empty($sur['children_amount']) ):?>
							<br><b><?=bpv_format_currency($sur['children_amount'])?></b> /<?=strtolower(lang('children_label'))?>
						<?php endif;?>
					<?php elseif($sur['charge_type'] == SUR_PER_ROOM_PRICE):?>
						<b><?=$sur['adult_amount'].lang('cb_sur_percentage_per_total')?></b>
					<?php endif;?>
				</td>
				<td style="text-align:center;">
					<?=get_cruise_surcharge_apply_for($check_rate_info, $sur)?>
				</td>
				<td>
					<span class="bpv-price-from sur-info" id="total_charge_<?=$sur['id']?>" c-type="<?=$sur['charge_type']?>" charge="<?=$sur['adult_amount']?>" rate="<?=$sur['total_charge']?>">
						<?=bpv_format_currency($sur['total_charge'])?>
					</span>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	</div>
	
<?php endif;?>