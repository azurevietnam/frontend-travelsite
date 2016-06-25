<div class="bpv-search">
	<h2><span><?=lang('search_hotels')?></span></h2>
	
	<div class="bpv-search-content">
		
		<form role="form" id="hotel_search_form" name="hotel_search_form" method="post" action="<?=get_url(HOTEL_SEARCH_PAGE)?>">
			
		<div class="row form-group">
			<div class="col-xs-12">
			<label for="destination"><?=lang('search_hotel_label')?></label>
				<span class="div-destination">
    				<input type="text" class="form-control" name="destination" id="destination" maxlength="100"
    					value="<?= !empty($hotel_search_criteria['destination']) ? $hotel_search_criteria['destination'] : ''?>" 
    					placeholder="<?=lang('placeholder_hotel_destination')?>" autocomplete="off">
    			</span>
    			<input type="hidden" name="hotel_destination_input" id="hotel_destination_input">
		    	<input type="hidden" name="oid" id="oid" value="<?=isset($hotel_search_criteria['oid'])?$hotel_search_criteria['oid']:''?>">
		    	<input type="hidden" id="is_update_des" value="<?=empty($hotel_search_criteria['selected_des'])?'1':'0'?>">
			</div>
		</div>
		
		
		<div class="row form-group">
				<div class="col-xs-6">
					<label for="startdate"><?=lang('check_in_date')?></label>
					<span class="icon-after">
		    			<input type="text" class="form-control bpv-date-input" name="startdate" id="startdate" maxlength="10" 
		    				placeholder="<?=lang('placeholder_date')?>"	readonly="readonly"	    				
		    				<?php 
		    					$startdate = $hotel_search_criteria['is_default'] || empty($hotel_search_criteria['startdate']) || !check_bpv_date($hotel_search_criteria['startdate']) ? '' : $hotel_search_criteria['startdate'];
		    				?>
		    				value="<?=$startdate?>">
			    			<span class="glyphicon glyphicon-calendar" id="btn_startdate"></span>
		    			</span>
				</div>
				
				<div class="col-xs-6">
					<label for="night"><?=lang('number_of_nights')?></label>
					<select class="form-control" id="night" name="night">
						<?php for($i=1; $i <= HOTEL_MAX_NIGHTS; $i++):?>
						<option value="<?=$i?>" <?=set_select('night', $i, $hotel_search_criteria['night'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
				
		</div>
		
		<?php 
    		$enddate = $hotel_search_criteria['is_default'] || empty($hotel_search_criteria['enddate']) || !check_bpv_date($hotel_search_criteria['enddate']) ? '' : $hotel_search_criteria['enddate'];
    	?>
    	
		<div class="row form-group" id="enddate_lbl" <?php if(empty($enddate)):?> style="display:none"<?php endif;?>>
		
			<div class="col-xs-12">
				<label for="enddate"><?=lang('check_out_date')?>:</label>
				<div style="display: inline-block;">
				
					<input type="hidden" id="enddate" name="enddate" value="<?=$enddate?>">
					<span id="show_search_end_date"><?=$enddate?></span>
					
				</div>
			</div>
		
		</div>
			
		<div class="row form-group margin-bottom-0">
			<div class="col-xs-12">
				<button type="submit" class="btn btn-bpv btn-search pull-right" 
					name="action" value="<?=ACTION_SEARCH?>"
					onclick="return validate_hotel_search()"><?=lang('btn_search_now')?></button>
			</div>
		</div>
		
	</form>
	
	</div>
</div>
<script type="text/javascript">

//$(document).ready(function() {
	
	var cal_load = new Loader();
	cal_load.require(
			<?=get_libary_asyn_js('jquery-ui-datepicker')?>, 
	      function() {
	         	 // Callback
	      	set_up_hotel_calendar(true);
	
	      });
	
	var au_load = new Loader();
	au_load.require(
		  <?=get_libary_asyn_js('typehead')?>, 
	      function() {
	         	 // Callback
	      	set_up_hotel_autocomplete(true);   
	      }); 
       				
	init_hotel_search(true, true);

//});
</script>