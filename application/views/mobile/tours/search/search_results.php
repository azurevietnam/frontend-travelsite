<div class="container">
    <?=$search_form?>
</div>

<?php if(count($tours) == 0 && !has_land_tour_search_filter($search_criteria)):?>
			
	<div class="alert alert-warning alert-dismissable">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
      
      <?php if(isset($selected_des)):?>
      	<strong><?=lang('no_tour_found_at').' "'.$selected_des['name'].'"'?></strong>
      <?php else:?>
      	<strong><?=lang('no_tour_filter_found')?></strong>
      <?php endif;?>
    </div>

<?php else:?>
    
    <div class="search-title-area">
        <h2 class="bpv-color-title hotel-search-title">
        	<?php 
                if(isset($selected_des)) {
    				echo get_search_result_title($search_criteria, $count_results, $selected_des);
    			} else {
    				echo get_search_result_title($search_criteria, $count_results, null);
    			}
        	?>
        </h2>
        
        <?php if(isset($filter_price) || isset($filter_duration) || isset($filter_departing) || isset($filter_categories) ):?>
		<div class="filtered-items">
		    <?php if(isset($filter_price)):?>
		    <?php foreach ($filter_price as $value):?>
				<?php if($value['selected']):?>
					<span class="item" onclick="remove_filter('filter_price','<?=$value['value']?>','<?=site_url(TOUR_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
				<?php endif;?>
			<?php endforeach;?>
			<?php endif;?>
			
			<?php if(isset($filter_duration)):?>
			<?php foreach ($filter_duration as $value):?>
				<?php if($value['selected']):?>
					<span class="item" onclick="remove_filter('filter_duration','<?=$value['value']?>','<?=site_url(TOUR_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
				<?php endif;?>
			<?php endforeach;?>
			<?php endif;?>
			
			<?php if(isset($filter_departing)):?>
			<?php foreach ($filter_departing as $value):?>
				<?php if($value['selected']):?>
					<span class="item" onclick="remove_filter('filter_departing','<?=$value['value']?>','<?=site_url(TOUR_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
				<?php endif;?>
			<?php endforeach;?>
			<?php endif;?>
			
			<?php foreach ($filter_categories as $value):?>
				<?php if($value['selected']):?>
					<span class="item" onclick="remove_filter('filter_categories','<?=$value['value']?>','<?=site_url(TOUR_SEARCH_PAGE)?>')"><?=$value['label']?> <span class="glyphicon glyphicon-remove removed"></span></span>
				<?php endif;?>
			<?php endforeach;?>
		</div>
		<?php endif;?>
    </div>
    
    <div class="margin-bottom-10 clearfix">
        <?php 
			$call_us = load_bpv_call_us_number(TOUR);
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
		<?=$search_sorts?>
	</div>
	
	<div id="bpv-filter" class="bpv-s-content">
		<?=$search_filters?>
	</div>
	
	<?php if(count($tours) > 0):?>
    
    	<?=$list_results?>
    
    <?php else:?>
    	
    	<div class="alert alert-warning alert-dismissable">
          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
          <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;
          <strong><?=lang('no_tour_filter_found')?></strong>
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
			init_tour_paging('<?=site_url(TOUR_SEARCH_PAGE)?>');
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