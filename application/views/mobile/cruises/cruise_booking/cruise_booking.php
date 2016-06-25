<?=$step_booking?>

<form role="form" method="post">

<input type="hidden" value="" name="promotion_code" id="promotion_code_used">

<div class="container">

	<div class="booking-info margin-bottom-10">
	
    	<div class="clearfix margin-top-10 margin-bottom-10">
            <img class="img-responsive pull-left margin-right-10" src="<?=get_image_path(CRUISE_TOUR, $tour['picture'], '160x120')?>">
            <h5 class="bpv-color-title margin-top-0"><b><?=$tour['name']?></b></h5>
            <strong><?=lang('tour_route')?></strong> <?=$tour['route']?>
        </div>
    
	    <div class="row">
            <div class="col-xs-6"><b><?=lang('departure_date')?>:</b></div>
	        <div class="col-xs-6 text-right"><?=format_bpv_date($check_rate_info['startdate'], DATE_FORMAT, true)?></div>
	    </div>  
	    <div class="row">
            <div class="col-xs-6"><b><?=lang('end_date')?>:</b></div>
            <div class="col-xs-6 text-right"><?=format_bpv_date($check_rate_info['enddate'], DATE_FORMAT, true)?></div>
	    </div>
	    <div class="row">
            <div class="col-xs-6"><b><?=lang('tour_infor')?></b></div>
            <div class="col-xs-6 text-right"><?=get_tour_info($check_rate_info)?></div>
	    </div>
	    <div>
            <a href="<?=cruise_tour_build_url($tour, $check_rate_info)?>" class="pull-right">
              <i class="glyphicon glyphicon-edit"></i><?=lang('change_cruise_booking')?>
            </a>
	    </div>
	</div>
	
	<?=$selected_cabins?>
	
	<?=$surcharge_detail?>
	
	<div class="margin-top-20">
		<?=$payment_detail?>
	</div>

	<div class="margin-top-20">
		<?=$customer_contact?>
	</div>

</div>
<div class="container margin-top-20">
	<?=$payment_method?>
</div>
<div class="container">
	<p>* <?=lang_arg('c_term_agreement', lang('c_complete_booking'))?></p>

	<div class="margin-top-20">
		<button type="submit" name="action" value="<?=ACTION_MAKE_BOOKING?>" class="btn btn-bpv btn-lg center-block"
			onclick="return validate_contact_form()">
			<span class="icon icon-circle-arrow-right"></span>&nbsp;<?=lang('cruise_complete_booking')?>
		</button>
	</div>
</div>
</form>
