<div class="bpv-sort clearfix">
	<div class="bpv-filter-title pull-left sort-label bpv-color-title"><?=lang('sort_result')?></div>
	
	<ul class="nav nav-pills pull-left">
		<?php foreach ($sort_by as $key=>$value):?>
		
			<li id="sort_by_<?=$value['value']?>" <?php if($value['selected']):?>class="active"<?php endif;?>>
		    	<a href="javascript:void(0)" onclick="sort_flight_by('<?=$value['value']?>')" style="white-space:nowrap;">
		    		<?=$value['label']?>
		    	</a>
		    	<img alt="" src="<?=site_url('media/icon/hotel_search/sort_arrow.png')?>" class="center-block" style="margin-bottom:-20px;margin-top:3px;<?php if(!$value['selected']):?>display:none<?php endif;?>">
	        </li>
			
		<?php endforeach;?>
        
    </ul>
    
    <div class="pull-right margin-top-10" style="white-space:nowrap;">(<?=lang('price_include_desc')?>)</div>
</div>
