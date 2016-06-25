<h2 class="bpv-filter-title bpv-color-title"><?=lang('filter_result')?></h2>

<?php 
$is_outbound = '';
if(isset($search_criteria['is_outbound']) && is_numeric($search_criteria['is_outbound'])) {
    $is_outbound = $search_criteria['is_outbound'];
}
?>

<input type="hidden" name="is_outbound" id="is_outbound" value="<?=$is_outbound?>">

<?php if(isset($filter_price)):?>
<div class="bpv-filter-box">
	<h3 class="bpv-color-title">
		<span class="icon icon-price-filter"></span> <span><?=lang('filter_price')?></span>
	</h3>
	<div class="content">
		
		<?php foreach ($filter_price as $value):?>
		
			<div class="checkbox">
				<label>
			    	<input type="checkbox" name="filter_price[]" value="<?=$value['value']?>"
			    	 id="filter_price_<?=$value['value']?>"
			    	 <?php if($value['selected']):?>checked="checked"<?php endif;?>
			    	 onclick="search_sort_tours('<?=site_url(TOUR_SEARCH_PAGE)?>')"
			    	 <?php if($value['number'] == 0):?>disabled="disabled"<?php endif;?>>
			    	 
			    	<span><?=$value['label']?></span>
			    	
			    	<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
				</label>
				
			</div>
		
		<?php endforeach;?>
		
	</div>
</div>
<?php endif;?>

<?php if(isset($filter_duration)):?>
<div class="bpv-filter-box">
	<h3 class="bpv-color-title">
		<span class="icon icon-circle-duration"></span> <span><?=lang('filter_duration')?></span>
	</h3>
	<div class="content">
	
		
		<?php foreach ($filter_duration as $value):?>
		
		<?php if($value['number'] == 0) continue;?>
		
		<div class="checkbox">
			<label>
		    	<input type="checkbox" name="filter_duration[]" value="<?=$value['value']?>"
		    	 id="filter_duration_<?=str_replace('.', '_', $value['value'])?>"
		    	<?php if($value['selected']):?>checked="checked"<?php endif;?>
		    	onclick="search_sort_tours('<?=site_url(TOUR_SEARCH_PAGE)?>')"
		    	<?php if($value['number'] == 0):?>disabled="disabled"<?php endif;?>>
		    	
		    	<span <?php if($value['number'] == 0):?>class="bpv-color-disabled"<?php endif;?>>
		    		<?=$value['label']?>
		    	</span>
		    	
		    	<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
			</label>
		</div>
		
		<?php endforeach;?>
		
	</div>
</div>
<?php endif;?>

<?php if(isset($filter_departing)):?>
<div class="bpv-filter-box">
	<h3 class="bpv-color-title">
		<span class="icon icon-circle-depart"></span> <span><?=lang('filter_departing')?></span>
	</h3>
	<div class="content">
		
		<?php foreach ($filter_departing as $value):?>
		
		<div class="checkbox pd-left-0">
			<label>
		    	<input type="radio" name="filter_departing" value="<?=$value['value']?>"
		    	 id="filter_departing_<?=str_replace('.', '_', $value['value'])?>"
		    	<?php if($value['selected']):?>checked="checked"<?php endif;?>
		    	onclick="search_sort_tours('<?=site_url(TOUR_SEARCH_PAGE)?>')"
		    	<?php if($value['number'] == 0):?>disabled="disabled"<?php endif;?>>
		    	
		    	<span <?php if($value['number'] == 0):?>class="bpv-color-disabled"<?php endif;?>>
		    		<?=$value['label']?>
		    	</span>
		    	
		    	<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
			</label>
		</div>
		
		<?php endforeach;?>
		
	</div>
</div>
<?php endif;?>

<?php if(isset($filter_categories)):?>
<div class="bpv-filter-box">
	<h3 class="bpv-color-title">
		<span class="icon icon-circle-category"></span> <span><?=lang('filter_categories')?></span>
	</h3>
	<div class="content">
	
		
		<?php foreach ($filter_categories as $value):?>
		
		<div class="checkbox">
			<label>
		    	<input type="checkbox" name="filter_categories[]" value="<?=$value['value']?>"
		    	 id="filter_categories_<?=str_replace('.', '_', $value['value'])?>"
		    	<?php if($value['selected']):?>checked="checked"<?php endif;?>
		    	onclick="search_sort_tours('<?=site_url(TOUR_SEARCH_PAGE)?>')"
		    	<?php if($value['number'] == 0):?>disabled="disabled"<?php endif;?>>
		    	
		    	<span <?php if($value['number'] == 0):?>class="bpv-color-disabled"<?php endif;?>>
		    		<?=$value['label']?>
		    	</span>
		    	
		    	<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
			</label>
		</div>
		
		<?php endforeach;?>
		
	</div>
</div>
<?php endif;?>
