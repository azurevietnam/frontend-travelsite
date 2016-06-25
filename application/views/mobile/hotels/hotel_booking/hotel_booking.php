<?=$step_booking?>

<form role="form" method="post">

<input type="hidden" value="" name="promotion_code" id="promotion_code_used">
	
<div class="container">
		<div class="booking-info margin-bottom-10">
			<div class="clearfix margin-top-10 margin-bottom-10">
	            <img class="img-responsive pull-left margin-right-10" src="<?=get_image_path(HOTEL, $hotel['picture'], '160x120')?>">
	            <h5 class="bpv-color-title margin-top-0"><b><?=$hotel['name']?></b> <i class="icon star-<?=$hotel['star']?>"></i></h5>
	            <strong><?=lang('hotel_address')?></strong> : <?=$hotel['address']?>
	        </div>
	        	
			<div class="row">
		          <div class="col-xs-6"><b><?=lang('checkin_date')?>:</b></div>
			      <div class="col-xs-6 text-right"><?=format_bpv_date($check_rate_info['startdate'], DATE_FORMAT, true)?></div> 
			</div>
			<div class="row">
		          <div class="col-xs-6"><b><?=lang('checkout_date')?>:</b></div>
			      <div class="col-xs-6 text-right"><?=format_bpv_date($check_rate_info['enddate'], DATE_FORMAT, true)?></div> 
			</div>
			<div>
            	<a href="<?=hotel_build_url($hotel, $check_rate_info)?>" class="pull-right">
              		<i class="glyphicon glyphicon-edit"></i><?=lang('change_hotel_booking')?>
           		</a>
	    	</div>
					
		</div>
	
		
		<?=$selected_rooms?>
		
		<?=$surcharge_detail?>
		
	
		
		<div class="margin-top-20">
			<?=$payment_detail?>
		</div>
		
	
		
		<div class="margin-top-20">
			<?=$customer_contact?>
		</div>
		
		<div class="margin-top-20">
			<?=$payment_method?>
		</div>
		
		<p class="margin-top-20">* <?=lang_arg('c_term_agreement', lang('c_complete_booking'))?></p>
		
		<div class="margin-top-20">
			<button type="submit" name="action" value="<?=ACTION_MAKE_BOOKING?>" class="btn btn-bpv btn-lg center-block" onclick="return validate_contact_form()">
				<span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;<?=lang('c_complete_booking')?>
			</button>
		</div>
</div>
</form>
<script type="text/javascript">
$('.bpv-toggle').bpvToggle();
</script>
