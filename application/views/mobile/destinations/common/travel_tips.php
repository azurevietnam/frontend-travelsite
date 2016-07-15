<div class="mg-top-20">
    <h2 class="highlight"><b><?=lang('overview_travel_tip', $destination['name'])?></b></h2>
    <ol class="no-padding">
        <?php foreach($destination['travel_tips'] as $value):?>
            <?php if(!empty($value)):?>
                <li class="margin-left-20"><?=$value?></li>
            <?php endif;?>
        <?php endforeach;?>
    </ol>
</div>
