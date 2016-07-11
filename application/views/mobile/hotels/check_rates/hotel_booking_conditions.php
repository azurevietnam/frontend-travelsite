<p><?=empty($hotel) ? lang('field_hotel_policies_title') : lang('hotel_policies_description')." " . $hotel['name']?></p>

<?php if(!empty($hotel['check_in'])):?>
    <h3 class="text-highlight"><?=lang('hotel_check_in')?></h3>
    <div>
        <?=$hotel['check_in']?>
    </div>
<?php endif;?>

<?php if(!empty($hotel['check_out'])):?>
    <h3 class="text-highlight"><?=lang('hotel_check_out')?></h3>
    <div>
        <?=$hotel['check_out']?>
    </div>
<?php endif;?>

<?php if(!empty($hotel['cancellation_prepayment'])):?>
    <h3 class="text-highlight"><?=lang('hotel_cancellation_prepayment')?></h3>
    <div>
        <?=generate_string_to_list($hotel['cancellation_prepayment'])?>
    </div>
<?php endif;?>

<?php if(!empty($hotel['children_extra_bed'])):?>
    <h3 class="text-highlight"><?=lang('lb_children_price_extra_bed')?></h3>
    <div>
        <?=$hotel['children_extra_bed']?>
    </div>
<?php endif;?>