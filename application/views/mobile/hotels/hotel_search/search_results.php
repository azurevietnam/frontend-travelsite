<div class="container">
	<?=$hotel_search_form?>
</div>
	
<?php if(count($hotels) == 0 && !has_hotel_search_filter($search_criteria)):?>
<div class="container">	
	<div class="alert alert-warning alert-dismissable">
    	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
      
      	<?php if($selected_des['type'] > DESTINATION_TYPE_AREA):?>
     	 	<strong><?=lang('no_hotel_found_near').' '.$selected_des['name']?></strong>
     	<?php else:?>
      		<strong><?=lang('no_hotel_found_at').' '.$selected_des['name']?></strong>
      	<?php endif;?>
	</div>
</div>
<?php else:?>
			
	
	<h2 class="bpv-color-title hotel-search-title">
		<?=hotel_get_search_result_txt($search_criteria, $count_results, $selected_des)?>
	</h2>

	<div class="filtered-items">
		<?php foreach ($filter_price as $value):?>
			<?php if($value['selected']):?>
				<span class="item" onclick="remove_filter('filter_price','<?=$value['value']?>','<?=site_url(HOTEL_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
			<?php endif;?>
		<?php endforeach;?>
		
		<?php foreach ($filter_star as $value):?>
			<?php if($value['selected']):?>
				<span class="item" onclick="remove_filter('filter_star','<?=$value['value']?>','<?=site_url(HOTEL_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
			<?php endif;?>
		
		<?php endforeach;?>
		
		<?php if(isset($filter_area)):?>
		<?php foreach ($filter_area as $value):?>
			<?php if($value['selected']):?>
				<span class="item" onclick="remove_filter('filter_area','<?=$value['value']?>','<?=site_url(HOTEL_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
			<?php endif;?>
		<?php endforeach;?>
		<?php endif;?>
		
		<?php if(isset($filter_facility)):?>
		<?php foreach ($filter_facility as $value):?>
			<?php if($value['selected']):?>
				<span class="item" onclick="remove_filter('filter_facility','<?=$value['value']?>','<?=site_url(HOTEL_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
			<?php endif;?>
		<?php endforeach;?>
		<?php endif;?>
	</div>
		
		
	<div class="margin-bottom-10 clearfix">
		
		
		     <?php 
				$call_us = load_bpv_call_us_number(HOTEL);
			?>
			<?php if(!empty($call_us)):?>
		    <div class="search-call-us pull-left">
	        	<a href="tel:<?=format_phone_number($call_us)?>"><span class="glyphicon glyphicon-earphone"></span> <?=$call_us?></a>
	        </div>
	        <?php endif;?>
        
         
        <div class="pull-right text-right no-padding">
	        <button type="button" class="btn btn-default btn-filter" data-target="#bpv-filter">
			    <?=lang('filter_result')?> <span class="caret"></span>
			</button>
			<button type="button" class="btn btn-default btn-filter" data-target="#bpv-sort">
			    <?=lang('sort_by')?> <span class="caret"></span>
			</button>
		</div>
		
	</div>
		
	<div id="bpv-sort" class="bpv-s-content">
		<?=$hotel_search_sorts?>
	</div>
	
	<div id="bpv-filter" class="bpv-s-content">
		<?=$hotel_search_filters?>
	</div>
		

		<?php if(count($hotels) > 0):?>
			
			<?=$hotel_list_results?>
		
		<?php else:?>
			
			<div class="alert alert-warning alert-dismissable">
		      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
		      <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;
		      <strong><?=lang('no_hotel_filter_found')?></strong>
		    </div>
		
		<?php endif;?>
		
			<?php if(count($hotels) > 0):?>
				<div class="container">
					<div class="margin-top-10 margin-bottom-10">
						<a href="javascript:void(0)" onclick="go_position(0)"><?=lang('go_top')?> &raquo;</a>
					</div>
					
					<div class="margin-bottom-10 text-center">
						<?=$paging_info['paging_text']?>
					</div>
					
					<div class="text-center">
						<?=$paging_info['paging_links']?>
					</div>
				</div>
				
				<script type="text/javascript">
					init_hotel_paging('<?=site_url(HOTEL_SEARCH_PAGE)?>');
				</script>
				
			<?php endif;?>
		
		<?php endif;?>

<script type="text/javascript">

$('.btn-filter').bpvToggle(function(data) {
    
    if( $('#bpv-sort').is(":visible") && data['id'] != '#bpv-sort') {
        $('#bpv-sort').hide();
    }
    if( $('#bpv-filter').is(":visible") && data['id'] != '#bpv-filter') {
        $('#bpv-filter').hide();
    }
});
	
	function map_callback(){
		
		var map_load = new Loader();
		map_load.require(
				<?=get_libary_asyn_js('map')?>, 
		      function() {
					// do nothing on callback
		      });   
		
	}
	
	var map_api_load = new Loader();
	map_api_load.require(
		<?=get_libary_asyn_js('google-map-api', 'map_callback')?>, 
	  function() {
		// do nothing on callback
	  });   	
</script>

