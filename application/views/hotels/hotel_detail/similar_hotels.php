
<?php if(count($s_hotels) > 0):?>
<div class="similar-hotels">
	<div class="bpv-color-title">
		<h2><?=lang('same_class_hotels')?></h2>
	</div>
	<div class="content">
		<div class="row-similar clearfix">
		<?php foreach ($s_hotels as $key=>$hotel):?>
			
			<?php 
				if($key >=4) break;
			?>
			
			<div class="col-similar">
				<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
				<img src ="<?=get_image_path(HOTEL, $hotel['picture'],'268x201')?>" class="img-responsive">
				</a>
				<div class="item-name margin-top-10">
					<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
					<?=$hotel['name']?>
					</a>
					<span style="display:block;">
					<span class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></span>
					</span>	
				</div>
				<div class="margin-top-5">
					<?=$hotel['address']?>
				</div>
				<!-- 
				<div class="margin-top-10">
					<span class="item-review-text bpv-color-very-good"><?=lang('rev_very_good')?> <span class="bpv-color-title">9,1</span></span>
					<span>
						20 <?=lang('rev_txt')?>
					</span>
				</div>
				
				 -->
				<div class="row margin-top-10">
					<div class="col-xs-6">
						<?php if(isset($hotel['price_from'])):?>
						<?php if($hotel['price_from'] != $hotel['price_origin']):?>
						<div class="bpv-price-origin"><?=number_format($hotel['price_origin'])?> <?=lang('vnd')?></div>
						<?php endif;?>
						
						<div class="bpv-price-from"><?=number_format($hotel['price_from'])?> <?=lang('vnd')?></div>
						<?php endif;?>
					</div>
					<div class="col-xs-6">
						<a href="<?=hotel_build_url($hotel, $search_criteria)?>" class="btn btn-bpv btn-book-now" type="button"><?=lang('btn_book_now')?></a>
					</div>
				</div>
				
			</div>
		
		<?php endforeach;?>
		</div>
	</div>
</div>
<?php endif;?>