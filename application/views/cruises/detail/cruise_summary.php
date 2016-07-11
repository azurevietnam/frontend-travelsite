<div class="cruise-summary">
    <div class="clearfix text-highlight summary-title">
    <img src="<?=get_static_resources('/media/icon/cruise_summary.jpg')?>" style="margin-top: -5px">
    <?=$cruise['name']?> <span class="icon <?=get_icon_star($cruise['star'])?>"></span>
    </div>
    <ul>
        <li><label><?=lang('label_operated_by')?>:</label> <?=$cruise['partner_name']?></li>
        <li><label><?=lang('label_destination')?>:</label> <?=$cruise_properties['destination']?></li>
        <li><label><?=lang('label_since')?>:</label> <?=$cruise_properties['since']?></li>
        <li><label><?=lang('label_number_of_cabin')?>:</label> <?=$cruise['num_cabin']?></li>
        <?php if(!empty($cruise_properties['materials'])):?>
        <li><label><?=lang('label_materials')?>:</label> <?=$cruise_properties['materials']?></li>
        <?php endif;?>
    </ul>
</div>