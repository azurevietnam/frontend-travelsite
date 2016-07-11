<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if(!empty($similar_cruises)):?>
	
	<div id="my_viewed_cruise_list" class="left_list_item_block">
	
		<h2 class="highlight"><span class="icon icon-similar"></span>
		<?php $cruise_type = get_similar_cruise_type($cruise);?>
		
		<?php if($cruise['cruise_destination'] == HALONG_CRUISE_DESTINATION):?>
		    <?=lang_arg('label_similar_halong_cruises', $cruise_type['budget'])?>
		<?php else:?>
		    <?=lang_arg('label_similar_mekong_cruises', $cruise_type['budget'])?>
		<?php endif;?>
		</h2>		
		<?php $cnt=count($similar_cruises)-1;?>
		<?php foreach ($similar_cruises as $ckey => $cruise):?>
			<div class="cruise_program_item" id="viewed_cruise_<?=$cruise['id']?>">
				<div class="similar-cruise-name">
					<span class="arrow">&rsaquo;</span><a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
					<?php 
					$star_infor = get_star_infor($cruise['star'], 0);
					?>
					<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
					<?php if ($cruise['num_reviews'] > 0):?>	
					<span class="cruise-review-score"><?=review_score_lang($cruise['review_score'])?></span>
					<?php endif;?>
				</div>
				<div style="margin-left: 10px; margin-bottom: 5px"><?=by_partner($cruise)?></div>
			</div>
		<?php endforeach;?>
		
		<div class="more_tour">
			<span class="arrow">&rsaquo;</span><?=$cruise_type['more_text']?>
		</div>
	
	</div>
	
	<?php endif;?>