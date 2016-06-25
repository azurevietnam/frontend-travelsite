<?php 
	$mobile_detect = new Mobile_Detect();
	$is_tablet = $mobile_detect->isTablet();
?>

<?=load_search_waiting(lang('hotel_search_updating'),'udating')?>

<div class="bpv-search-left" <?php if(isset($hotel_search_overview)):?>style="display:none"<?php endif;?>>
	<h1><span class="icon icon-search"></span><?=lang('search_hotel_label')?></h1>
	<div class="content clearfix">
		<form role="form" method="post" action="<?=site_url(HOTEL_SEARCH_PAGE)?>" name="frmSearchForm" id="frmSearchForm">
		  <div class="form-group clearfix">
		    <label for="destination"><?=lang('search_hotel_label')?></label>
		    <span class="icon-before div-destination">
    			<input type="text" class="form-control icon-small typeahead" data-provide="typeahead" 
    				name="destination" id="destination" 
    				value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
    				placeholder="<?=lang('placeholder_hotel_destination')?>" autocomplete="off">
    		</span>
    		<input type="hidden" name="hotel_destination_input" id="hotel_destination_input">
    		<input type="hidden" name="oid" id="oid" value="<?=isset($search_criteria['oid'])?$search_criteria['oid']:''?>">
		  </div>
		  <div id="suggestion-des" class="hide">
             <h3 class="bpv-color-title">
                 <?=lang('suggestion_destinations')?>
                 <span class="icon btn-support-close" onclick="$('#destination').popover('hide');"></span>
             </h3>
             <ul>
             <?php foreach ($suggestion_destinations as $des): ?>
                 <li><a href="javascript:void(0)" data-name="<?=$des['name']?>" data-id="<?=$des['id']?>" data-url-title="<?=$des['url_title']?>"><?=$des['name']?></a></li>
             <?php endforeach;?>
             </ul>
         </div>
		  <div class="row form-group clearfix">
		  	<div class="col-xs-8">
		  		<label for="startdate"><?=lang('check_in_date')?></label>
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
		    <label for="night"><?=lang('number_of_nights')?></label>
		    <select class="form-control" id="night" style="width:30%" name="night">
				<?php for($i=1; $i <= HOTEL_MAX_NIGHTS; $i++):?>
				<option value="<?=$i?>" <?=set_select('night', $i, $search_criteria['night'] == $i ? true : false)?>><?=$i?></option>
				<?php endfor;?>
			</select>
		  </div>	
			
		  <div class="form-group clearfix">
		    <div>
		    	<label for="enddate"><?=lang('check_out_date')?></label>
		    </div>
		    <div>
		    	
		    	<?php 
    					$enddate = $search_criteria['is_default'] || empty($search_criteria['enddate']) || !check_bpv_date($search_criteria['enddate']) ? '' : $search_criteria['enddate'];
    				?>
	    				
	    				
			    <span class="help-block" id="show_search_end_date"><?=$enddate?></span>
				<input type="hidden" id="enddate" name="enddate" value="<?=$enddate?>">
			</div>
		  </div>
		  	
		  <button type="submit" id="submit" onclick="return search_sort_hotels('<?=site_url(HOTEL_SEARCH_PAGE)?>')" class="btn btn-bpv btn-search pull-right" name="action" value="<?=ACTION_SEARCH?>"><?=lang('btn_search_now')?></button>
		  	
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
      	set_up_hotel_calendar();

 
      });

	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
      function() {
         	 // Callback
      	set_up_hotel_autocomplete();   
      }); 
        				
	init_hotel_search(false);
//});
</script>