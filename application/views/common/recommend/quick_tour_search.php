<div class="bpt-quick-search recommend-item">
	<div class="row">
		<div class="col-des">
			<div class="col-des-text">
				<label><?=lang('destination')?>:</label>
			</div>
			<div class="col-des-input">
				<input type="text" class="form-control input-sm" id="destination_<?=$block_id?>" name="destination_<?=$block_id?>" value="<?=$search_params['destination']?>" placeholder="<?=lang('search_placeholder')?>">
				<input type="hidden" id="destination_id_<?=$block_id?>" name="destination_id_<?=$block_id?>" value="<?=$search_params['destination_id']?>">
			</div>
		</div>
		<div class="col-select">
		
			<div class="col-select-text">
				<label><?=lang('duration')?>:</label>
			</div>		
			
			<div class="col-select-input">
				<select id="duration_<?=$block_id?>" name="duration" class="form-control input-sm">
					<option value="">
						<?=lang('select_all')?>
					</option>
					
					<?php foreach ($dur_list as $key => $value) :?>
					<option value="<?=$key?>"
						<?=set_select('duration', $key, strval($key) == $search_params['duration'])?>>
						<?=lang($value)?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
			
		</div>

	</div>
	<div class="row col-sort margin-top-10">
		<div class="col-sort-text"><label style="padding-top: 7px; margin-left:10px;"><?=lang('label_sort_by')?>:</label></div>
		<div class="col-sort-input">
			<ul class="list-inline">
				<?php foreach($tour_sort_by as $key=>$value):?>
					<?php 
						$act_class = $key == $search_params['sort_by'] ? 'active' : '';
					?>
					<li class="<?=$act_class?>"><a href="javascript:void(0)" onclick="bt_sort_by('<?=$block_id?>', '<?=$key?>')"><?=$value?></a></li>
				<?php endforeach;?>
			</ul>
			
			<input type="hidden" id="sort_by_<?=$block_id?>" name="sort_by" value="<?=$search_params['sort_by']?>">
		</div>
		<div class="col-seach text-right">
			<div class="btn btn-blue btn-default" onclick="search_more('<?=$block_id?>')"><?=lang('label_quick_search')?></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	set_quick_search_des_auto('<?=$block_id?>','tour');
</script>