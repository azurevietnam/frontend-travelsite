<div class="tour-info">
    <div class="col-name">
        <h1 class="bpv-color-title"><?=$tour['name']?></h1>
        <div style="display: block; clear: both; width: 100%">
            <label><?=lang('lbl_tour_code')?></label><?=$tour['code']?>
        </div>
        <div>
            <label><?=lang('lbl_duration')?></label><?=get_duration_text($tour)?>
        </div>
        <div>
            <label><?=lang('lbl_tour_route')?></label><?=$tour['route']?>
        </div>
        <div class="margin-bottom-5">
            <?=get_departure_date_text($tour)?>
        </div>
    </div>
    <div class="col-price">
        <?php if (!empty($tour['price_from'])):?>
			<?php if($tour['price_origin'] != $tour['price_from']):?>
				<div class="text-right">
					<span class="bpv-price-origin"><?=bpv_format_currency($tour['price_origin'])?></span>
				</div>
			<?php endif;?>
			<div class="text-right margin-top-10">
				<span class="label-price-from"><?=lang('price_from')?></span> 
				<span class="bpv-price-from"><?=bpv_format_currency($tour['price_from'])?>
				<small style="font-size: 13px; margin-bottom: 10px; color: #333"><?=lang('/pax')?></small>
				</span>
			</div>
		<?php else:?>
			<?php $params = get_tour_contact_params($tour, $search_criteria);?>
			<a type="button" class="btn btn-bpv btn-book-now btn-sm margin-bottom-5 pull-right" 
					href="<?=get_url(CONTACT_US_PAGE, $params)?>">
				<?=lang('contact_for_price')?>
			</a>
		<?php endif;?>
		
		<?php if(!empty($tour['promotions'])):?>
			<?php foreach ($tour['promotions'] as $pro):?>
				<div class="margin-bottom-5 text-right pull-right">
					<?=load_promotion_tooltip($pro, $tour['id'])?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		
		<?php if(!empty($tour['bpv_promotions'])):?>
			<?php foreach ($tour['bpv_promotions'] as $bpv_pro):?>
				<div class="margin-bottom-5 text-right pull-right">
					<?=load_marketing_pro_tooltip($bpv_pro, $tour['id'])?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
    </div>
</div>