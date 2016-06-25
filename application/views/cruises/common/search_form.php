
<?php 
	$mobile_detect = new Mobile_Detect();
	$is_tablet = $mobile_detect->isTablet();
?>

<?=load_search_waiting(lang('cruise_search_updating'),'udating')?>

	
<div class="bpv-search-left" <?php if(isset($cruise_search_overview)):?>style="display:none"<?php endif;?>>
	<h2><span class="icon icon-search"></span><?=lang('cruise_search_title')?></h2>
	<div class="content clearfix">
		<form role="form" method="post" action="<?=site_url(CRUISE_HL_SEARCH_PAGE)?>" name="frmSearchForm" id="frmSearchForm">
		  <div class="form-group clearfix">
		    <label for="destination"><?=lang('search_cruise_label')?></label>
		    <span class="icon-before div-destination">
    			<input type="text" class="form-control icon-small typeahead" data-provide="typeahead" 
    				name="destination" id="destination" 
    				value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
    				placeholder="<?=lang('placeholder_cruises')?>" autocomplete="off">
    		</span>
    		<input type="hidden" name="cruise_destination_input" id="cruise_destination_input">
    		<input type="hidden" name="oid" id="oid" value="<?=isset($search_criteria['oid'])?$search_criteria['oid']:''?>">
		  </div>
		  
		  <div id="suggestion-des" class="hide">
		     <h3 class="bpv-color-title">
		         <?=lang('halong_popular_cruises')?>
		         <span class="icon btn-support-close" onclick="$('#destination').popover('hide');"></span>
		     </h3>
		     <ul>
		     <?php foreach ($popular_cruises as $cruise): ?>
		         <li><a href="javascript:void(0)" data-name="<?=$cruise['name']?>" data-id="<?=$cruise['id']?>" data-url-title="<?=$cruise['url_title']?>"><?=$cruise['name']?></a></li>
		     <?php endforeach;?>
		     </ul>
		 </div>
		  
		  <div class="row form-group clearfix">
		  	<div class="col-xs-8">
		  		<label for="startdate"><?=lang('departure_date')?></label>
			    <span class="icon-after">
		    		<input type="text" class="form-control" name="startdate" id="startdate" 
		    			placeholder="<?=lang('placeholder_date')?>"
		    			
		    				<?php 
		    					$startdate = $search_criteria['is_default'] || empty($search_criteria['startdate']) || !check_bpv_date($search_criteria['startdate']) ? '' : $search_criteria['startdate'];
		    				?>
		    				value="<?=$startdate?>" autocomplete="off" <?php if($is_tablet):?>readonly="readonly"<?php endif;?>>
		    				
		    			
		    		<span id="btn_startdate" class="icon icon-calendar"></span>
	    		</span>
    		</div>
		  </div>
		  
		  <div class="form-group clearfix">
		    <label for="duration"><?=lang('tour_duration')?></label>
		    <select class="form-control" id="duration" style="width:40%" name="duration">
				<?php foreach ($duration_search as $key => $value):?>
				<option value="<?=$key?>" <?=set_select('duration', $key, $search_criteria['duration'] == $key ? true : false)?>><?=lang($value)?></option>
				<?php endforeach;?>
			</select>
		  </div>
		  <div class="form-group clearfix">
		    <label for="end_date"><?=lang('end_date')?></label>
		    <div style="display: block;">
					<?php 
    					$enddate = $search_criteria['is_default'] || empty($search_criteria['enddate']) || !check_bpv_date($search_criteria['enddate']) ? '' : $search_criteria['enddate'];
    				?>
    				
					<input type="hidden" id="enddate" name="enddate" value="<?=$enddate?>">
				<span id="show_search_end_date"><?=$enddate?></span>
			</div>
		  </div>
		  	
		  <button type="submit" id="submit" onclick="return search_sort_cruises('<?=site_url(CRUISE_HL_SEARCH_PAGE)?>')" class="btn btn-bpv btn-search pull-right" name="action" value="<?=ACTION_SEARCH?>"><?=lang('btn_search_now')?></button>
		  	
		</form>
	</div>
</div>
<script type="text/javascript">
    				
$(document).ready(function() {
	
	var cal_load = new Loader();
	cal_load.require(
			<?=get_libary_asyn_js('jquery-ui-datepicker')?>, 
	      function() {
	         	 // Callback
	      	set_up_cruise_calendar();
	
	      });
	
	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
	  function() {
	     	 // Callback
	  	set_up_cruise_autocomplete();   
	  }); 
	init_cruise_search(false);

	
});
</script>