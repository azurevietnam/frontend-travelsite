<div class="bpv-sort clearfix">
	<div class="bpv-filter-title pull-left sort-label bpv-color-title"><?=lang('sort_by')?></div>
	
	<ul class="nav nav-pills pull-left">
		<?php foreach ($sort_by as $key=>$value):?>
		
			<li <?php if($value['selected']):?>class="active"<?php endif;?>>
		    	<a href="javascript:void(0)" style="white-space: nowrap;" <?php if(!$value['selected']):?>onclick="sort_by('<?=$value['value']?>', '<?=site_url(TOUR_SEARCH_PAGE)?>')"<?php endif;?>>
		    		<?=$value['label']?>
		    	</a>
		    	
		    	<?php if($value['selected']):?>
		    		<img alt="" src="<?=get_static_resources('/media/icon/hotel_search/sort_arrow.png')?>" class="center-block" style="margin-bottom:-20px;margin-top:3px">
		    		<input type="hidden" value="<?=$value['value']?>" name="sort_by" id="sort_by_value">
		    	<?php endif;?>
	        </li>
			
		<?php endforeach;?>
        
    </ul>
</div>
