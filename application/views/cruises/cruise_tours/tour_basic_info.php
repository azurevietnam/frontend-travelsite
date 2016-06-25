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
        <div class="modal-dialog" style="max-width:83%;margin-top:10px">
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

<div class="hotel-basic-info">
	<div class="clearfix margin-bottom-10">
		<div class="col-name">
			<h1 class="bpv-color-title">
				<?=$tour['name']?>
				<span class="icon star-<?=str_replace('.', '_', $tour['star'])?>"></span>
			</h1>
			
			<div class="cruise-info margin-bottom-5">
				<span class="pull-left margin-right-10"><?=lang('cruise_name')?></span>
				<?php $cruise = array('id' => $tour['cruise_id'], 'url_title' => $tour['cruise_url_title'])?>
				<a href="<?=cruise_build_url($cruise)?>"><?=$tour['cruise_name']?></a>
			</div>
			
			<div class="cruise-info margin-bottom-5">
				<span class="pull-left margin-right-10"><?=lang('tour_duration')?>:</span>
				<?=get_tour_duration($tour)?>
			</div>
			
			<div class="cruise-info margin-bottom-5">
				<span class="pull-left margin-right-10"><?=lang('tour_route')?></span>
				<?=$tour['route']?>
			</div>
			
			<div></div>
				
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
				<?php $params = get_contact_params($tour, $search_criteria);?>
				<a type="button" class="btn btn-bpv btn-book-now btn-sm pull-right" 
						href="<?=get_url(CONTACT_US_PAGE, $params)?>">
					<?=lang('contact_for_price')?>
				</a>
			<?php endif;?>
			
			<?php if(!empty($tour['promotions'])):?>
				<?php foreach ($tour['promotions'] as $pro):?>
					<div class="margin-bottom-5 text-right">
						<?=load_promotion_tooltip($pro, $tour['id'])?>
					</div>
				<?php endforeach;?>
			<?php endif;?>
			
			<?php if(!empty($tour['bpv_promotions'])):?>
				<?php foreach ($tour['bpv_promotions'] as $bpv_pro):?>
					<div class="margin-bottom-5 text-right">
						<?=load_marketing_pro_tooltip($bpv_pro, $tour['cruise_id'])?>
					</div>
				<?php endforeach;?>
			<?php endif;?>
			
		</div>
	</div>
	
	<div class="image-area clearfix">
		<div class="col-main-img">
			<a href="<?=get_image_path(CRUISE_TOUR, $tour['picture'])?>" title="<?=$tour['name']?>" data-gallery>
		        <img src="<?=get_image_path(CRUISE_TOUR, $tour['picture'],'416x312')?>" alt="<?=$tour['name']?>">
		    </a>
		</div>
		
		<div class="col-list-img">
			<?php foreach ($tour_photos as $photo):?>
			<?php if( !empty($photo['cruise_id'])): ?>
				<a href="<?=get_image_path(CRUISE, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
		       		<img alt="<?=$photo['caption']?>" src="<?=get_image_path(CRUISE, $photo['name'], '120x90')?>">
		    	</a>
			<?php else:?>
				<a href="<?=get_image_path(CRUISE_TOUR, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
		       		<img alt="<?=$photo['caption']?>" src="<?=get_image_path(CRUISE_TOUR, $photo['name'],'120x90')?>">
		    	</a>
			<?php endif;?>
			<?php endforeach;?>
		</div>
		
	</div>
</div>