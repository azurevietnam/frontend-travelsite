<div class="container">
    <?=$cruise_search_form?>
</div>

<?php if(count($tours) == 0 && !has_tour_search_filter($search_criteria)):?>
<div class="container">	
	<div class="alert alert-warning alert-dismissable margin-top-10 margin-bottom-0">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
      
      <?php if(isset($selected_des)):?>
      	<strong><?=lang('no_tour_found_at').' "'.$selected_des['name'].'"'?></strong>
      <?php else:?>
      	<strong><?=lang('no_cruise_filter_found')?></strong>
      <?php endif;?>
    </div>
</div>
<?php else:?>
  
        <div class="search-title-area">
            <h2 class="bpv-color-title hotel-search-title">
				<?php 
					if(isset($selected_des)) {
						echo get_search_tours_result_txt($search_criteria, $count_results, $selected_des);
					} else {
						echo get_search_tours_result_txt($search_criteria, $count_results, null, $selected_cruise);
					}
				?>
			</h2>
	
	        <?php if(!empty($filter_star) || !empty($filter_facility) || !empty($filter_price)):?>
			<div class="filtered-items">
			    <?php foreach ($filter_price as $value):?>
					<?php if($value['selected']):?>
						<span class="item" onclick="remove_filter('filter_price','<?=$value['value']?>','<?=site_url(CRUISE_HL_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
					<?php endif;?>
				<?php endforeach;?>
					
				<?php foreach ($filter_star as $value):?>
					<?php if($value['selected']):?>
						<span class="item" onclick="remove_filter('filter_star','<?=$value['value']?>','<?=site_url(CRUISE_HL_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
					<?php endif;?>
				
				<?php endforeach;?>
				
				<?php if(isset($filter_facility)):?>
				<?php foreach ($filter_facility as $value):?>
					<?php if($value['selected']):?>
						<span class="item" onclick="remove_filter('filter_facility','<?=$value['value']?>','<?=site_url(CRUISE_HL_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
					<?php endif;?>
				<?php endforeach;?>
				<?php endif;?>
			</div>
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
    		<?=$cruise_search_sorts?>
    	</div>
    	
    	<div id="bpv-filter" class="bpv-s-content">
    		<?=$cruise_search_filters?>
    	</div>
    	
   

    <?php if(count($tours) > 0):?>
    
    	<?=$cruise_list_results?>
    
    <?php else:?>
    	
    	<div class="alert alert-warning alert-dismissable">
          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
          <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;
          <strong><?=lang('no_cruise_filter_found')?></strong>
        </div>
    
    <?php endif;?>
	
	<?php if(count($tours) > 0):?>
		
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
			init_cruise_paging('<?=site_url(CRUISE_HL_SEARCH_PAGE)?>');
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
</script>
