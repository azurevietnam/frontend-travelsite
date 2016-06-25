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
	<div class="clearfix margin-bottom-5">
		<div class="col-name">
			<h1 class="bpv-color-title">
				<?=$cruise['name']?>
				<span class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></span>
			</h1>
			
			<div class="cruise-info">
				<span class="pull-left margin-right-10"><?=lang('cruise_address')?></span>
				<?=$cruise['address']?>
			</div>
			
		</div>
		<div class="col-price">
			<?php if (!empty($cruise_price_from)):?>
				<?php if($cruise_price_from['price_origin'] != $cruise_price_from['price_from']):?>
					<div class="text-right">
						<span class="bpv-price-origin"><?=bpv_format_currency($cruise_price_from['price_origin'])?></span>
					</div>
				<?php endif;?>
				<div class="text-right margin-top-10">
					<span class="label-price-from"><?=lang('price_from')?></span> 
					<span class="bpv-price-from">
						<?=bpv_format_currency($cruise_price_from['price_from'])?>
						<small style="font-size: 13px; margin-bottom: 10px; color: #333"><?=lang('/pax')?></small>
					</span>
				</div>
			<?php else:?>
				<?php $params = get_contact_params($cruise, $search_criteria);?>
				<a type="button" class="btn btn-bpv btn-book-now btn-sm pull-right" 
						href="<?=get_url(CONTACT_US_PAGE, $params)?>">
					<?=lang('contact_for_price')?>
				</a>
			<?php endif;?>
			
		</div>
	</div>
	
	<?php 
		$select_date_txt = get_cruise_selected_date_txt($search_criteria);
	?>
	
	<?php if(count($highlight_facilities) > 0 || (isset($cruise_price_from) && !empty($cruise_price_from['pro_content'])) || $select_date_txt != ''):?>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-7">
			<?php if($select_date_txt != ''):?>
				<p>
					<?=$select_date_txt?>
				<p>
			<?php endif;?>
			
			<?php foreach ($highlight_facilities as $fa):?>
				<span class="bpv-important-facility" style="white-space: nowrap;"><?=$fa['name']?></span>
			<?php endforeach;?>
	
		</div>
		
		<div class="col-xs-5 text-right">
			<!-- Promotion from the Hotel -->
			<?php if (!empty($cruise_promotions)):?>
				<?php foreach ($cruise_promotions as $pro):?>
					<div class="margin-bottom-5">
						<?=load_promotion_tooltip($pro,'','left')?>
					</div>
				<?php endforeach;?>	
			<?php endif;?>
			
			<?php if (!empty($bpv_promotions)):?>
			<!-- Promotion from Best Price -->
				<?php foreach ($bpv_promotions as $bpv_pro):?>
					<div class="margin-bottom-5">
						<?=load_marketing_pro_tooltip($bpv_pro, $cruise['id'], 'left')?>
					</div>
				<?php endforeach;?>	
		
			<?php endif;?>
		</div>
	</div>
	
	<?php endif;?>
	
	<div class="image-area clearfix">
		<div class="col-main-img">
			<a href="<?=get_image_path(CRUISE, $cruise['picture'])?>" title="<?=$cruise['name']?>" data-gallery>
		        <img src="<?=get_image_path(CRUISE, $cruise['picture'], '416x312')?>" alt="<?=$cruise['name']?>">
		    </a>
		</div>
		
		<div class="col-list-img">
			<?php foreach ($cruise_photos as $photo):?>
				<a href="<?=get_image_path(CRUISE, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
		       	 <img alt="<?=$photo['caption']?>" src="<?=get_image_path(CRUISE, $photo['name'], '120x90')?>">
		    	</a>
			<?php endforeach;?>
		</div>
		
	</div>
</div>