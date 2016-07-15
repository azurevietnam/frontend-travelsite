<div role="tabpanel" class="bpt-tab bpt-tab-tours">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#hotel_rate" aria-controls="hotel_rate" role="tab" data-toggle="tab"><?=lang('check_rates')?></a>
        </li>
        <li role="presentation">
            <a href="#hotel_facilities" aria-controls="hotel_facilities" role="tab" data-toggle="tab"><?=lang('field_facilities')?></a>
        </li>
        <li role="presentation">
            <a href="#hotel_policies" aria-controls="hotel_policies" role="tab" data-toggle="tab"><?=lang('field_policies')?></a>
        </li>
    </ul>
</div>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="hotel_rate">
    	<?=$check_rate_form?>

        <?= !empty($hotel_rate_table) ? $hotel_rate_table : ''?>

        <?= !empty($extra_saving_recommend) ? $extra_saving_recommend : ''?>

        <?php if(!empty($photo_list)):?>
            <h2 class="text-highlight header-title"><?=lang('lbl_hotel_photos', $hotel['name'])?></h2>
            <?=$photo_list?>
        <?php endif;?>
    </div>

    <div role="tabpanel" class="tab-pane" id="hotel_facilities">
        <?=$hotel_facilities?>
    </div>
    <div role="tabpanel" class="tab-pane" id="hotel_policies">
        <?=$hotel_booking_conditions?>
    </div>

</div>