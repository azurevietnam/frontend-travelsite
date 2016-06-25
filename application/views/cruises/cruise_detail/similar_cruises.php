<?php if(count($s_cruises) > 0):?>
	<?php if( isset($is_small_layout) && $is_small_layout ):?>
		
		<div class="bpv-box" id="box_recent_items">
			<h3 class="bpv-color-title">
				<?=lang('similar_cruises')?>
			</h3>
			<?php foreach ($s_cruises as $k => $cruise):?>
			<div class="bpt-list-sm <?=($k == count($s_cruises) - 1) ? 'no-border' : ''?>">
				<div class="col-xs-3 no-padding">
					<a href="<?=cruise_build_url($cruise, $search_criteria)?>">
						<img class="img-responsive" src="<?=get_image_path(CRUISE, $cruise['picture'], '120x90')?>">
					</a>
				</div>
				<div class="col-xs-9">
					<ul class="list-unstyled">
						<li class="item-name">
							<a href="<?=cruise_build_url($cruise, $search_criteria)?>" style="font-size: 14px; margin-top: -5px; float: left;"><?=$cruise['name']?></a>
						</li>
						<li style="float: left; clear: both; width: 100%">
							<span class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></span>
							<?php if(!empty($cruise['price_from'])):?>
							<span class="pull-right">
                                <span class="bpv-price-from" style="font-size:13px;line-height:0;font-weight:normal;">
                                	<?=bpv_format_currency($cruise['price_from'])?>
                                	<small class="price-unit" <?php if ($cruise['price_origin'] != $cruise['price_from'])?>><?=lang('/pax')?></small>
                                </span>
        					</span>
        					<?php endif;?>
						</li>
					</ul>
				</div>
			</div>
			<?php endforeach;?>
		</div>
	<?php else:?>
		<div class="similar-hotels">
			<div class="title bpv-color-title">
				<h2><?=lang('similar_cruises')?></h2>
			</div>
			<div class="content">
				<div class="row-similar clearfix">
				<?php foreach ($s_cruises as $cruise):?>
					
					<div class="col-similar">
						<a href="<?=cruise_build_url($cruise, $search_criteria)?>">
							<img class="img-responsive" src ="<?=get_image_path(CRUISE, $cruise['picture'], '268x201')?>">
						</a>
						<div class="item-name margin-top-10">
							<?=$cruise['name']?>
							<span style="display:block;">
							<span class="icon star-<?=$cruise['star']?>"></span>
							</span>	
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
								<?php if(isset($cruise['price_from'])):?>
								<a href="<?=cruise_build_url($cruise, $search_criteria)?>" class="btn btn-bpv btn-book-now" type="button"><?=lang('btn_book_now')?></a>
								<?php else:?>
									<?php 
										$params = get_contact_params($cruise, $search_criteria);
									?>
									
									<a type="button" class="btn btn-bpv btn-book-now btn-sm" 
										href="<?=cruise_build_url($cruise, $search_criteria)?>">
										<?=lang('btn_view_now')?>
									</a>		
								<?php endif;?>			
							</div>
							<div class="col-xs-6">
								<?php if(isset($cruise['price_from'])):?>
									<?php if($cruise['price_from'] != $cruise['price_origin']):?>
									<div class="bpv-price-origin text-right"><?=number_format($cruise['price_origin'])?> <?=lang('vnd')?></div>
									<?php endif;?>
									
									<div class="bpv-price-from text-right"><?=number_format($cruise['price_from'])?> <?=lang('vnd')?></div>
								<?php endif;?>
							</div>
						</div>
					</div>
				
				<?php endforeach;?>
				</div>
			</div>
		</div>
	<?php endif;?>
<?php endif;?>