<div class="container margin-bottom-10">
    <?=$check_rate_form?>
    
    <?=$tour_rate_table?>
</div>

<?php if(!empty($tour_booking_conditions)):?>
<div class="bpv-collapse margin-bottom-2">
    <h5 class="heading no-margin" data-target="#booking_conditions">
		<i class="glyphicon glyphicon-star"></i>
		<?=lang('field_tour_policies_title')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white icon-arrow-right-white-up"></i>
	</h5>
	<div class="content" id="booking_conditions" style="display: block;">
        <?=$tour_booking_conditions?>
	</div>
</div>
<?php endif;?>