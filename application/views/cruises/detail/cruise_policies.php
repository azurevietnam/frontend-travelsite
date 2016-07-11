<p class="item_text_desc">
	<?=lang('cruise_policies_description')?><b><?=$cruise['name']?></b>:
</p>
<div class="policy">
   
   <?=$tour_booking_conditions?>
    
    <div class="item">
    	<div class="col-item-title"><?=lang('cruise_shuttle_bus')?></div>
    	<div class="col-item-content"><?=$cruise['shuttle_bus']?></div>
    </div>
    <div class="item">
    	<div class="col-item-title"><?=lang('cruise_check_in')?></div>
    	<div class="col-item-content"><?=$cruise['check_in']?></div>
    </div>
    <div class="item">
    	<div class="col-item-title"><?=lang('cruise_check_out')?></div>
    	<div class="col-item-content"><?=$cruise['check_out']?></div>
    </div>
    <div class="item">
    	<div class="col-item-title"><?=lang('cruise_guide')?></div>
    	<div class="col-item-content"><?=$cruise['guide']?></div>
    </div>
    <?php if( !empty($cruise['note']) ):?>
    <div class="item">
    	<div class="col-item-title"><?=lang('cruise_other_notice')?></div>
    	<div class="col-item-content"><?=str_replace("\n", "<br>", $cruise['note'])?></div>
    </div>
    <?php endif;?>
</div>