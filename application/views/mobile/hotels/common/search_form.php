
<?=load_search_waiting(lang('hotel_search_updating'),'udating')?>

<div class="bpv-search" style="display:none">
	<h1><?=lang('search_hotel_label')?></h1>
	<div class="bpv-search-content">
		<form role="form" method="post" action="<?=site_url(HOTEL_SEARCH_PAGE)?>" name="frmSearchForm" id="frmSearchForm">
		  <div class="row form-group clearfix">
		  	<div class="col-xs-12">
			    <label for="destination"><?=lang('search_hotel_label')?></label>
			    <span class="div-destination">
	    			<input type="text" class="form-control icon-small" data-provide="typeahead" 
	    				name="destination" id="destination" 
	    				value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
	    				placeholder="<?=lang('placeholder_hotel_destination')?>" autocomplete="off">
	    			
	    		</span>
	    		<input type="hidden" name="hotel_destination_input" id="hotel_destination_input">
	    		<input type="hidden" name="oid" id="oid" value="<?=isset($search_criteria['oid'])?$search_criteria['oid']:''?>">
		 	</div>
		  </div>
		  
		  <div class="row form-group">
		  	<div class="col-xs-6">
		  		<label for="startdate"><?=lang('check_in_date')?></label>
			    <span class="icon-after">
		    		<input type="text" class="form-control bpv-date-input" name="startdate" id="startdate" readonly="readonly"
		    			placeholder="<?=lang('placeholder_date')?>"
		    			
		    				<?php 
		    					$startdate = $search_criteria['is_default'] || empty($search_criteria['startdate']) || !check_bpv_date($search_criteria['startdate']) ? '' : $search_criteria['startdate'];
		    				?>
		    				value="<?=$startdate?>" autocomplete="off">
		    				
		    			
		    		<span id="btn_startdate" class="glyphicon glyphicon-calendar"></span>
	    		</span>
    		</div>
    		
    		<div class="col-xs-6">
    		 	<label for="night"><?=lang('number_of_nights')?></label>
			    <select class="form-control" id="night" name="night">
					<?php for($i=1; $i <= HOTEL_MAX_NIGHTS; $i++):?>
					<option value="<?=$i?>" <?=set_select('night', $i, $search_criteria['night'] == $i ? true : false)?>><?=$i?></option>
					<?php endfor;?>
				</select>
    		</div>
		  </div>
		  
		  <?php 
    			$enddate = $search_criteria['is_default'] || empty($search_criteria['enddate']) || !check_bpv_date($search_criteria['enddate']) ? '' : $search_criteria['enddate'];
    	  ?>
    					
		  <div class="row form-group" id="enddate_lbl" <?php if(empty($enddate)):?>style="display:none"<?php endif;?>>
		    <div class="col-xs-12">
		    	<label for="enddate"><?=lang('check_out_date')?>:</label>
		  
			    <div style="display: inline-block;">
			      	<span class="help-block" id="show_search_end_date"><?=$enddate?></span>
					<input type="hidden" id="enddate" name="enddate" value="<?=$enddate?>">
				</div>
			</div>
		  </div>
		  
		  <div class="row">
		  	<div class="col-xs-12">
		  		<button type="submit" id="submit" onclick="return search_sort_hotels('<?=site_url(HOTEL_SEARCH_PAGE)?>')" class="btn btn-bpv btn-search btn-block" name="action" value="<?=ACTION_SEARCH?>"><?=lang('btn_search_now')?></button>
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
        				
	init_hotel_search(false, true);

//});
</script>