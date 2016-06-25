<div class="container">
    <ol class="breadcrumb">
        <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
        <li><a href="<?=get_url(TOUR_HOME_PAGE)?>"><?=lang('mnu_tours')?></a></li>
        
        <?php if($tour['is_outbound'] == TOUR_DOMESTIC):?>
        <li><a href="<?=site_url(TOUR_DOMESTIC_PAGE)?>"><?=lang('label_domestic_tours')?></a></li>
        <?php else:?>
        <li><a href="<?=site_url(TOUR_OUTBOUND_PAGE)?>"><?=lang('label_outbound_tours')?></a></li>
        <?php endif;?>
        
        <?php if(!empty($tour['destinations'])):?>
        <?php foreach ($tour['destinations'] as $des):?>
        <li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
        <?php endforeach;?>
        <?php endif;?>
        
        <li><a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $check_rate_info)?>"><?=$tour['name']?></a></li>
        <li class="active"><?=lang('tour_booking')?></li>
    </ol>
	
	<div class="bpv-col-right">		
		<?=$step_booking?>
		<div class="margin-top-20 margin-bottom-10 clearfix">
			<h2 class="bpv-color-title pull-left"><?=lang('tour_booking_details')?></h2>
			<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $check_rate_info)?>" role="button" class="btn btn-default btn-change-booking pull-right">
				<?=lang('change_tour_booking')?>
			</a>
		</div>
		<div class="hotel-booking-detail">
			<div class="hotel-info clearfix margin-bottom-20">
				<div class="col-1">
					<img class="img-responsive" alt="" src="<?=get_image_path(TOUR, $tour['picture'], '160x120')?>">
				</div>
				<div class="col-2">
					<h3 class="bpv-color-title no-margin margin-bottom-10"><?=$tour['name']?></h3>
					<div class="margin-bottom-10">
						<strong><?=lang('lbl_tour_route')?></strong> <?=$tour['route']?>
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
				
				<?=$selected_accommodation?>
				
				<div class="margin-top-20">
					<h2 class="bpv-color-title"><?=lang('discount_code')?></h2>
					<div class="data-area" style="background-color:#FFFFCC">				
						<?=$pro_code?>
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
						<span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;<?=lang('tour_complete_booking')?>
					</button>
				</div>
			
			</form>
		</div>
	</div>
	<div class="bpv-col-left">
		<?=$payment_detail?>
	</div>
</div>

