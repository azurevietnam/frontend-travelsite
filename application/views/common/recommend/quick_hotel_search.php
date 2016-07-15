<div class="bpt-quick-search recommend-item">
	<div class="row">
		<div class="col-des">
			<div class="col-des-text">
				<label><?=lang('destination')?>:</label>
			</div>
			<div class="col-des-input">
				<input type="text" class="form-control input-sm" id="destination_<?=$block_id?>" name="destination_<?=$block_id?>" value="<?=$search_params['destination']?>" placeholder="<?=lang('search_placeholder')?>">
				<input type="hidden" id="destination_id_<?=$block_id?>" name="destination_id_<?=$block_id?>" value="<?=$search_params['destination_id']?>">
				<input type="hidden" id="hotel_id_<?=$block_id?>" name="hotel_id_<?=$block_id?>" value="<?=$search_params['hotel_id']?>">
			</div>
		</div>
		<div class="col-select">
		
			<div class="col-select-text">
				<label><?=lang('duration')?>:</label>
			</div>		
			
			<div class="col-select-input" style="margin-top: -5px;">
				<?php for($i = 5; $i >= 2; $i--):?>
					<div class="checkbox" style="display:inline-block;padding-right: 10px">
						<label>
							<input type="checkbox" value="<?=$i?>" <?=set_checkbox('stars', $i, !empty($search_params['stars']) && in_array($i, $search_params['stars']))?> name="stars[]">
							<?=$i?>*
						</label>
					</div>
				<?php endfor;?>	
			</div>
			
		</div>

	</div>
	<div class="row col-sort margin-top-10">
		<div class="col-sort-text"><label style="padding-top: 7px; margin-left:10px;"><?=lang('label_sort_by')?>:</label></div>
		<div class="col-sort-input">
			<ul class="list-inline" >
				<?php foreach($hotel_sort_by as $key=>$value):?>
					<?php 
						$act_class = $key == $search_params['sort_by'] ? 'active' : '';
					?>
					<li class="<?=$act_class?>"><a href="javascript:void(0)" onclick="bt_sort_by('<?=$block_id?>', '<?=$key?>')"><?=$value?></a></li>
				<?php endforeach;?>
			</ul>
			
			<input type="hidden" id="sort_by_<?=$block_id?>" name="sort_by" value="<?=$search_params['sort_by']?>">
		</div>
		<div class="col-seach text-right">
			<div class="btn btn-primary" onclick="search_more('<?=$block_id?>')"><?=lang('label_quick_search')?></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	set_quick_search_des_auto('<?=$block_id?>','hotel');
</script>