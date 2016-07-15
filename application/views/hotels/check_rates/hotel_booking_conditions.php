<div class="bpt-box">
	<?php if(!empty($hotel)):?>
        <h2 class="text-highlight line-border">
            <?=lang('hotel_policies_description') . ' <b>' . $hotel['name'] . '</b>:'?>
        </h2>

        <?php if(!empty($hotel['check_in'])):?>
            <h3 class="text-highlight header-title"><?=lang('hotel_check_in')?></h3>
            <div>
                <?=$hotel['check_in']?>
            </div>
        <?php endif;?>

        <?php if(!empty($hotel['check_out'])):?>
            <h3 class="text-highlight header-title"><?=lang('hotel_check_out')?></h3>
            <div>
                <?=$hotel['check_out']?>
            </div>
        <?php endif;?>

        <?php if(!empty($hotel['cancellation_prepayment'])):?>
            <h3 class="text-highlight header-title"><?=lang('hotel_cancellation_prepayment')?></h3>
            <div>
                <?=$hotel['cancellation_prepayment']?>
            </div>
        <?php endif;?>

        <?php if(!empty($hotel['children_extrabed'])):?>
            <h3 class="text-highlight header-title"><?=lang('lb_children_price_extra_bed')?></h3>
            <div>
                <?=$hotel['children_extrabed']?>
            </div>
        <?php endif;?>

    <?php endif;?>
</div>