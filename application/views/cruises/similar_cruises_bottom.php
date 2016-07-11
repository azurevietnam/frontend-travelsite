<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if(!empty($similar_cruises)):?>
	<div class="clearfix"></div>
	
	<div class="similar_cruise_header">
		
		<h2 class="highlight">
			<?php $cruise_type = get_similar_cruise_type($cruise);?>
			
			<?php if($cruise['cruise_destination'] == HALONG_CRUISE_DESTINATION):?>
    		    <?=lang_arg('label_similar_halong_cruises', $cruise_type['budget'])?>
    		<?php else:?>
    		    <?=lang_arg('label_similar_mekong_cruises', $cruise_type['budget'])?>
    		<?php endif;?>	
		</h2>
	
	</div>
	
	<div class="similar_cruise_body">
	
		<div style="float: left;">
		<?php foreach ($similar_cruises as $ckey => $cruise):?>
			<?php if($ckey < 4):?>
				<div class="similar_item" <?php if($ckey < 3):?>style="margin-right: 22px;"<?php endif;?>>
					
					<a class="item_name" href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><b><?=$cruise['name']?></b></a>
					
					<?php $star_infor = get_star_infor($cruise['star'], 0);?>
					<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
					
				</div>
			<?php endif;?>
		<?php endforeach;?>
		</div>
		
		<?php foreach ($similar_cruises as $ckey => $cruise):?>
			<?php if($ckey < 4):?>
				<div class="similar_item" <?php if($ckey < 3):?>style="margin-right: 22px;"<?php endif;?>>
					<a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>">				
						<img class="item_img" alt="<?=$cruise['name']?>" src="<?=$this->config->item('cruise_220_165_path').$cruise['picture']?>"/>					
					</a>
					
					<?php if($cruise['review_score'] > 0):?>
						
						<span class="review_text"><?=review_score_lang($cruise['review_score'])?></span>
						&nbsp;-&nbsp;
						<span class="review_score">
							<b><?=$cruise['review_score']?></b> <?=lang('common_paging_of')?> <a style="text-decoration: underline;" href="<?=url_builder(CRUISE_REVIEWS, $cruise['url_title'], true)?>"><?=$cruise['num_reviews'].''.lang('reviews')?></a>								
						</span>
						
					<?php endif;?>
					
				</div>
			<?php endif;?>
		<?php endforeach;?>
		
		<div class="more_tour" style="margin-bottom: 0; margin-top: 5px;">
			<span class="arrow">&rsaquo;</span><?=$cruise_type['more_text']?>
		</div>
	</div>
<?php endif;?>