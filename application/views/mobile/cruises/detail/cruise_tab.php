<div class="container margin-bottom-10">
    <?=$check_rate_form?>
    
    <?=$tour_rate_table?>
</div>

<?php if(!empty($tour_booking_conditions)):?>
<div class="bpv-collapse margin-bottom-2">
    <h5 class="heading no-margin" data-target="#booking_conditions">
		<i class="glyphicon glyphicon-star"></i>
		<?=lang('field_tour_policies_title')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
	</h5>
	<div class="content" id="booking_conditions">
        <?=$tour_booking_conditions?>
	</div>
</div>
<?php endif;?>

<div class="bpv-collapse margin-bottom-2">
    <h5 class="heading no-margin" data-target="#cruise_policies">
		<i class="glyphicon glyphicon-star"></i>
		<?=lang('cruise_policies_tab')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
	</h5>
	<div class="content" id="cruise_policies">
        <?=$cruise_policies?>
	</div>
</div>

<div class="bpv-collapse margin-bottom-2">
    <h5 class="heading no-margin" data-target="#cruise_facilities">
		<i class="glyphicon glyphicon-star"></i>
		<?=lang('cruise_facilities_deckplan')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
	</h5>
	<div class="content" id="cruise_facilities">
        <?=$cruise_facilities?>
	</div>
</div>

<?php if(!empty($cruise_resources)):?>
<div class="bpv-collapse margin-bottom-2">
    <h5 class="heading no-margin" data-target="#cruise_resources">
		<i class="glyphicon glyphicon-star"></i>
		<?=lang('cruise_resouces')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
	</h5>
	<div class="content" id="cruise_resources">
        <?=$cruise_resources?>
	</div>
</div>
<?php endif;?>
