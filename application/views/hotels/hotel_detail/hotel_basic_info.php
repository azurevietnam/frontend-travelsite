<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev">�</a>
    <a class="next">�</a>
    <a class="close">�</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog" style="max-width:80%;margin-top:10px">
            <div class="modal-content">
                <div class="modal-header" style="padding:5px 15px">
                    <button type="button" class="close" aria-hidden="true"><span class="icon btn-support-close"></span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer" style="padding:10px">
                    <button type="button" class="btn btn-default pull-left prev btn-sm">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        <?=lang('previous_img')?>
                    </button>
                    <button type="button" class="btn btn-primary next btn-sm">
                         <?=lang('next_img')?>
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?=load_hotel_map()?>

<div class="hotel-basic-info">
	<div class="clearfix margin-bottom-20">
		<div class="col-name">
			<h1 class="bpv-color-title">
				<?=$hotel['name']?>
				<span class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></span>
			</h1>
			
			<div class="hotel-address">
				<span class="icon icon-map-xs pull-left margin-right-10"></span>
				
				
				<?php 
					$hotel_area = $parents[count($parents) - 1];
				?>
				<p style="margin-bottom:3px">
					<b><?=lang('hotel_address')?>:</b>  <?=$hotel['address']?>
					(<a href="javascript:void(0)" data-lat="<?=$hotel['latitude']?>" data-lng="<?=$hotel['longitude']?>" 
					data-place-name="<?=$hotel['name']?>" data-hotel-id="<?=$hotel['id']?>" data-des-id="<?=$hotel['destination_id']?>" data-star="<?=$hotel['star']?>"
					onclick="view_hotel_map(this)" style="font-weight:bold"><?=lang('view_map')?></a>)
				</p>
				<p style="margin-bottom:0">
					<b><?=lang('hotel_area')?>:</b> <a style="text-decoration:none" href="<?=get_url(HOTEL_DESTINATION_PAGE, $hotel_area)?>"><?=$hotel_area['name']?></a>
				</p>
				
			</div>
			
			<div></div>
				
		</div>
		<div class="col-price">
			<?php if (!empty($hotel_price_from)):?>
				
				<?php if($hotel_price_from['price_origin'] != $hotel_price_from['price_from']):?>
					<div class="text-right">
						<span class="bpv-price-origin"><?=bpv_format_currency($hotel_price_from['price_origin'])?></span>
					</div>
				<?php endif;?>
				<div class="text-right margin-top-10">
					<span class="label-price-from"><?=lang('price_from')?></span> <span class="bpv-price-from"><?=bpv_format_currency($hotel_price_from['price_from'])?></span>
				</div>
			<?php endif;?>
			
		</div>
	</div>
	
	<?php 
		$select_date_txt = get_hotel_selected_date_txt($search_criteria);
	?>
	
	<?php if(count($highlight_facilities) > 0 || (isset($hotel_price_from) && !empty($hotel_price_from['pro_content'])) || $select_date_txt != ''):?>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-8">
			<?php if($select_date_txt != ''):?>
			
				<p>
					<?=$select_date_txt?> | <b><a style="text-decoration:underline;" href='javascript:void(0)' onclick='go_check_rate_position()'><?=lang('change_booking_date')?></a></b>
				<p>
			<?php endif;?>
			
			<?php foreach ($highlight_facilities as $fa):?>
				<span class="bpv-important-facility" style="white-space: nowrap;"><?=$fa['name']?></span>
			<?php endforeach;?>
	
		</div>
		
		<div class="col-xs-4 text-right">
			<!-- Promotion from the Hotel -->
			<?php if (!empty($hotel_promotions)):?>
				<?php foreach ($hotel_promotions as $pro):?>
					<div class="margin-bottom-5">
						<?=load_promotion_tooltip($pro,'','left')?>
					</div>
				<?php endforeach;?>	
			<?php endif;?>
			
			<?php if (!empty($bpv_promotions)):?>
			<!-- Promotion from Best Price -->
				<?php foreach ($bpv_promotions as $bpv_pro):?>
					<div class="margin-bottom-5">
						<?=load_marketing_pro_tooltip($bpv_pro, $hotel['id'], 'left')?>
					</div>
				<?php endforeach;?>	
		
			<?php endif;?>
		</div>
	</div>
	
	<?php endif;?>
	
	<div class="image-area clearfix">
		<div class="col-main-img">
			<a href="<?=get_image_path(HOTEL, $hotel['picture'])?>" title="<?=$hotel['name']?>" data-gallery>
		        <img src="<?=get_image_path(HOTEL, $hotel['picture'],'416x312')?>" alt="<?=$hotel['name']?>">
		    </a>
		</div>
		
		<div class="col-list-img">
			<?php foreach ($hotel_photos as $photo):?>
				<a href="<?=get_image_path(HOTEL, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
		       	 <img alt="<?=$photo['caption']?>" src="<?=get_image_path(HOTEL, $photo['name'],'120x90')?>">
		    	</a>
			<?php endforeach;?>
		</div>
		
	</div>
</div>