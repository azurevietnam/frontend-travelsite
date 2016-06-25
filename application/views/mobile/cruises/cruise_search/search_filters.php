<?php if(isset($filter_price)):?>
<div class="bpv-filter">
	<div class="title bpv-color-title">
		<span class="icon icon-price-filter"></span> <span><?=lang('filter_price')?></span>
	</div>
	<div class="content">
		
		<?php foreach ($filter_price as $value):?>
		
			<div class="checkbox">
				<label>
			    	<input type="checkbox" name="filter_price[]" value="<?=$value['value']?>"
			    	 id="filter_price_<?=$value['value']?>"
			    	 <?php if($value['selected']):?>checked="checked"<?php endif;?>
			    	 onclick="search_sort_cruises('<?=site_url(CRUISE_HL_SEARCH_PAGE)?>')"
			    	 <?php if($value['number'] == 0):?>disabled="disabled"<?php endif;?>>
			    	 
			    	<span><?=$value['label']?></span>
			    	
			    	<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
				</label>
				
			</div>
		
		<?php endforeach;?>
		
	</div>
</div>
<?php endif;?>

<?php if(isset($filter_star)):?>
<div class="bpv-filter">
	<div class="title bpv-color-title">
		<span class="icon icon-star-filter"></span> <span><?=lang('filter_star')?></span>
	</div>
	<div class="content">
	
		
		<?php foreach ($filter_star as $value):?>
		
		<div class="checkbox margin-bottom-20">
			<label>
		    	<input type="checkbox" name="filter_star[]" value="<?=$value['value']?>"
		    	 id="filter_star_<?=str_replace('.', '_', $value['value'])?>"
		    	<?php if($value['selected']):?>checked="checked"<?php endif;?>
		    	onclick="search_sort_cruises('<?=site_url(CRUISE_HL_SEARCH_PAGE)?>')"
		    	<?php if($value['number'] == 0):?>disabled="disabled"<?php endif;?>>
		    	
		    	<span <?php if($value['number'] == 0):?>class="bpv-color-disabled"<?php endif;?>>
		    		<span class="icon star-<?=str_replace('.', '_', $value['value'])?>"></span>
		    		
		    		<?=$value['label']?>
		    	</span>
		    	
		    	<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
			</label>
		</div>
		
		<?php endforeach;?>
		
	</div>
</div>
<?php endif;?>

<?php if(isset($filter_facility)):?>
<div class="bpv-filter">
	<div class="title bpv-color-title">
		<span class="icon icon-facility-filter"></span> <span><?=lang('filter_facility')?></span>
	</div>
	<div class="content">
		<?php $index = 0;?>
		<?php foreach ($filter_facility as $value):?>
			<?php $index++?>
		<div class="checkbox margin-bottom-20 <?php if($index > $filter_limit):?>hidden-item<?php endif;?>" <?php if($index > $filter_limit):?>style="display:none"<?php endif;?>>
			<label>
		    	
		    	<input type="checkbox" name="filter_facility[]" value="<?=$value['value']?>" 
		    	id="filter_facility_<?=$value['value']?>"
		    	<?php if($value['selected']):?>checked="checked"<?php endif;?>
		    	onclick="search_sort_cruises('<?=site_url(CRUISE_HL_SEARCH_PAGE)?>')">
		    	<span <?php if($value['is_important']):?>class="bpv-filter-important-item"<?php endif;?>><?=$value['label']?></span>
		    	<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
			    	
			</label>
			
		</div>
		<?php endforeach;?>
		
		<?php if(count($filter_facility) > $filter_limit):?>
			<div><a href="javascript:void(0)" onclick="show_more(this)" show="hide"><?=lang('view_more')?></a></div>
		<?php endif;?>
		
	</div>
</div>
<?php endif;?>