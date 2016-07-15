<p><?=empty($cruise) ? '' : lang('field_cruise_policies_title', $cruise['name'])?></p>
<?php if(empty($cruise)):?>
	<?php if(!empty($tour['service_includes'])):?>
	    <h3 class="text-highlight"><?=lang('label_price_includes')?></h3>
	    <?=generate_string_to_list($tour['service_includes'], 'bpt-list-standard')?>
	<?php endif;?>
	
	<?php if(!empty($tour['service_excludes'])):?>
	    <h3 class="text-highlight"><?=lang('label_price_excludes')?></h3>
	    <?=generate_string_to_list($tour['service_excludes'], 'bpt-list-standard')?>
	<?php endif;?>
<?php endif;?>

<?php if(!empty($tour['cancellation_policy'])):?>
	<h3 class="text-highlight"><?=lang('lb_cancellation_by_customer')?></h3>
	<?=generate_string_to_list($tour['cancellation_policy'], 'bpt-list-standard')?>
<?php endif;?>


<div class="clearfix"><?=$cancellation_weather?></div>

<?php if(!empty($tour['children_extrabed'])):?>
	<h3 class="text-highlight"><?=lang('lb_children_price_extra_bed')?></h3>
    <?=generate_string_to_list($tour['children_extrabed'], 'bpt-list-standard')?>
<?php endif;?>

<?php if(!empty($cruise)):?>
    <h3 class="text-highlight"><?=lang('cruise_shuttle_bus')?></h3>
    <div class="margin-bottom-10">
        <?=$cruise['shuttle_bus']?>
    </div>

    <h3 class="text-highlight"><?=lang('cruise_check_in')?></h3>
    <div class="margin-bottom-10">
        <?=$cruise['check_in']?>
    </div>

    <h3 class="text-highlight"><?=lang('cruise_check_out')?></h3>
    <div class="margin-bottom-10">
        <?=$cruise['check_out']?>
    </div>

    <h3 class="text-highlight"><?=lang('cruise_guide')?></h3>
    <div>
        <?=$cruise['guide']?>
    </div>
<?php endif;?>