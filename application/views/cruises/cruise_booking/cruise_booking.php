<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
	  <li><a href="<?=site_url(CRUISE_HL_HOME_PAGE)?>"><?=lang('mnu_cruises')?></a></li>
	  <li><a href="<?=cruise_tour_build_url($tour, $check_rate_info)?>"><?=$tour['name']?></a></li>
	  <li class="active"><?=lang('cruise_book_room')?></li>
	</ol>
	
	<div class="bpv-col-right">		
		<?=$step_booking?>
		<div class="margin-top-20 margin-bottom-10 clearfix">
			<h2 class="bpv-color-title pull-left"><?=lang('cruise_book_detail')?></h2>
			<a href="<?=cruise_tour_build_url($tour, $check_rate_info)?>" role="button" class="btn btn-default btn-change-booking pull-right">
				<?=lang('change_cruise_booking')?>
			</a>
		</div>
		<div class="hotel-booking-detail">
			<div class="hotel-info clearfix margin-bottom-20">
				<div class="col-1">
					<img class="img-responsive" alt="" src="<?=get_image_path(CRUISE_TOUR, $tour['picture'], '160x120')?>">
				</div>
				<div class="col-2">
					<h3 class="bpv-color-title"><?=$tour['name']?></h3>
					<div class="margin-bottom-10">
						<strong><?=lang('tour_route')?></strong> <?=$tour['route']?>
					</div>
					<div class="margin-bottom-10">
						<?=get_tour_selected_date_txt($check_rate_info, $tour);?>
					</div>
					<div class="margin-bottom-10">
						<?=lang('tour_infor')?>
						<?=get_tour_info($check_rate_info)?>
					</div>
				</div>
			</div>
			
			<form role="form" method="post">
			
				<input type="hidden" value="" name="promotion_code" id="promotion_code_used">
				
				<?=$selected_cabins?>
				
				<?=$surcharge_detail?>
				
				<div class="margin-top-20">
					<h2 class="bpv-color-title"><?=lang('discount_code')?></h2>
					<div class="data-area" style="background-color:#FFFFCC">				
						<?=$cruise_pro_code?>
					</div>
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
						<span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;<?=lang('cruise_complete_booking')?>
					</button>
				</div>
			
			</form>
		</div>
	</div>
	<div class="bpv-col-left">
		<?=$payment_detail?>
	</div>
</div>

