<?php 
	$mobile_detect = new Mobile_Detect();
	$is_tablet = $mobile_detect->isTablet();
?>

<?=load_search_waiting(lang('tour_search_updating'),'udating')?>

	
<div class="bpv-search-left" <?php if(isset($search_overview)):?>style="display:none"<?php endif;?>>
	<h2><span class="icon icon-search"></span><?=lang('search_tour_label')?></h2>
	<div class="content clearfix">
		<form role="form" method="post" action="<?=site_url(TOUR_SEARCH_PAGE)?>" name="frmSearchForm" id="frmSearchForm">
		
            <div class="form-group clearfix">
                <label for="dep_id"><?=lang('departing_from')?></label>
                <select class="form-control" name="dep_id" id="dep_id">
                    <option value=""><?=lang('select_departing_from')?></option>
                    <?php foreach ($departure_destinations as $des):?>
                        
                        <option value="<?=$des['id']?>"  <?=set_select('dep_id', $des['id'], isset($search_criteria['dep_id']) && $search_criteria['dep_id'] == $des['id'] ? true : false)?>><?=$des['name']?></option>
                        
                    <?php endforeach;?>
                </select>
                <input type="hidden" id="departure" name="departure" value="<?= !empty($search_criteria['departure']) ? $search_criteria['departure'] : ''?>">
            </div>
		
            <div class="form-group clearfix">
                <label for="tour_destination"><?=lang('destination_search')?></label>
                <span class="icon-before div-destination">
                	<input type="text" class="form-control icon-small typeahead" data-provide="typeahead" 
                		name="destination" id="tour_destination" 
                		value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
                		placeholder="<?=lang('placeholder_tours')?>" autocomplete="off">
                </span>
                <input type="hidden" name="tour_destination_input" id="tour_destination_input">
                <input type="hidden" name="des_id" id="des_id" value="<?=isset($search_criteria['des_id'])?$search_criteria['des_id']:''?>">
            </div>
		  
            <?=$destination_suggestion?>
		  
            <div class="row form-group clearfix">
                <div class="col-xs-8">
                	<label for="tour_departure_date"><?=lang('departure_date')?></label>
                    <span class="icon-after">
                		<input type="text" class="form-control" name="startdate" id="tour_departure_date" 
                			placeholder="<?=lang('placeholder_date')?>"
                			
                				<?php 
                					$startdate = $search_criteria['is_default_date'] || empty($search_criteria['startdate']) || !check_bpv_date($search_criteria['startdate']) ? '' : $search_criteria['startdate'];
                				?>
                				value="<?=$startdate?>" autocomplete="off" <?php if($is_tablet):?>readonly="readonly"<?php endif;?>>
                				
                			
                		<span id="btn_startdate" class="icon icon-calendar"></span>
                	</span>
                </div>
            </div>
		  
            <div class="row form-group clearfix">
                <div class="col-xs-8">
                    <label for="duration"><?=lang('tour_duration')?></label>
                    <select class="form-control" id="duration" name="duration">
                    	<?php foreach ($duration_search as $key => $value):?>
                    	<option value="<?=$key?>" <?=set_select('duration', $key, $search_criteria['duration'] == $key ? true : false)?>><?=lang($value)?></option>
                    	<?php endforeach;?>
                    </select>
                </div>
            </div>
		  
            <button type="submit" id="submit" onclick="return search_sort_tours('<?=site_url(TOUR_SEARCH_PAGE)?>')" class="btn btn-bpv btn-search pull-right" name="action" value="<?=ACTION_SEARCH?>"><?=lang('btn_search_now')?></button>
		  	
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
	      	set_up_tour_calendar();

	      });
	
	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
      function() {
         // Callback
      	 set_up_tour_autocomplete();   
      }); 

	init_tour_search(true);
	
//});
</script>