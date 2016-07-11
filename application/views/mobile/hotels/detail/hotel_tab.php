<div class="container margin-bottom-10">
    <?=$check_rate_form?>

    <?=$hotel_rate_table?>
</div>


<div class="bpv-collapse margin-bottom-2">
    <h5 class="heading no-margin" data-target="#hotel_policies">
		<i class="glyphicon glyphicon-star"></i>
		<?=lang('field_policies')?>
		<i class="bpv-toggle-icon glyphicon glyphicon-menu-right pull-right"></i>
	</h5>
	<div class="content" id="hotel_policies">
        <?=$hotel_booking_conditions?>
	</div>
</div>

<div class="bpv-collapse margin-bottom-2">
    <h5 class="heading no-margin" data-target="#hotel_facilities">
		<i class="glyphicon glyphicon-star"></i>
		<?=lang('field_facilities')?>
		<i class="bpv-toggle-icon glyphicon glyphicon-menu-right pull-right"></i>
	</h5>
    <?php if(!empty($hotel_facilities)):?>
        <div class="content" id="hotel_facilities">
            <?=$hotel_facilities?>
        </div>
    <?php endif;?>
</div>