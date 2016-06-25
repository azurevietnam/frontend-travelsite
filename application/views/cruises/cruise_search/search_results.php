<div class="container margin-bottom-20">
	<div class="bpv-col-left">
	
		<?=$cruise_search_overview?>
		
		<?=$cruise_search_form?>
		
		<?=$cruise_search_filters?>
	</div>
	<div class="bpv-col-right">
		<ol class="breadcrumb">
		  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
		  <li><a href="<?=site_url(CRUISE_HL_HOME_PAGE).'/'?>"><?=lang('mnu_cruises')?></a></li>
		  
		  <li class="active">
		 	<?=lang('cruise_search_title')?>
		  </li>
		</ol>
		
		<?php if(count($tours) == 0 && !has_tour_search_filter($search_criteria)):?>
			
			<div class="alert alert-warning alert-dismissable">
		      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
		      
		      <?php if(isset($selected_des)):?>
		      	<strong><?=lang('no_tour_found_at').' "'.$selected_des['name'].'"'?></strong>
		      <?php else:?>
		      	<strong><?=lang('no_cruise_filter_found')?></strong>
		      <?php endif;?>
		    </div>
		
		<?php else:?>
		
		<div class="search-title-area clearfix">
			<div class="col-1">
				
				<h1 class="bpv-color-title hotel-search-title">
					<?php 
						if(isset($selected_des)) {
							echo get_search_tours_result_txt($search_criteria, $count_results, $selected_des);
						} else {
							echo get_search_tours_result_txt($search_criteria, $count_results, null, $selected_cruise);
						}
					?>
				</h1>
		
				<?php if(isset($filter_star) || isset($filter_facility)):?>
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
			<div class="col-2">
				<?=load_bpv_call_us(CRUISE)?>
			</div>
			
		</div>
		
		<?=$cruise_search_sorts?>
		
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
				
				<div>
					<div style="float:left; padding:7px 0;">
						<a href="javascript:void(0)" onclick="go_position(0)"><?=lang('go_top')?> &raquo;</a>
					</div>
				
					<div class="pull-right">
						
						<?=$paging_info['paging_links']?>
						
						<div style="float:right; padding:7px 0; margin-right:15px;">
							<?=$paging_info['paging_text']?>
						</div>
	
					</div>

				</div>
				
				<script type="text/javascript">
					init_cruise_paging('<?=site_url(CRUISE_HL_SEARCH_PAGE)?>');
				</script>
				
			<?php endif;?>
		
		<?php endif;?>
	</div>

</div>

