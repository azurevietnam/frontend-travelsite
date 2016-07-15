<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<?php if ($this->session->userdata('MENU') == MNU_HALONG_CRUISES):?>
		<h1 class="highlight"><?=lang('cruise_best_deal_halong')?></h1>
	<?php else :?>
		<h1 class="highlight"><?=lang('cruise_best_deal_mekong')?></h1>
	<?php endif;?>


<div id="tabs">
	<ul>
		<?php foreach ($stars as $key => $value) :?>
																						
			<li><a href="#tabs-<?=$key?>"><?=$value.' '.lang('star')?></a></li>
		
		<?php endforeach ;?>
	</ul>	
	
	<?php foreach ($stars as $key => $value) :?>
		<div id="tabs-<?=$key?>">
			<?php foreach ($cruies_by_stars[$value] as $ckey => $cruise) :?>
				<div class="cruise_item<?php if ($ckey > 0) :?> margin_top_10<?php endif;?>">
					<div class="cruise_image">
						<img width="100%" height="100%" src="<?=site_url($this->config->item('cruise_small_path')).$cruise['picture']?>"></img>
					</div>
					
					<h3 class="cruise_name">
						<a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
						<?php 
							$star_title = "";
							$star_image_name = "";
							if($cruise['star'] == 1){
								$star_title = lang('1_star_title');
								$star_image_name = "1sterren4.png";
							} else if ($cruise['star'] == 2){
								$star_title = lang('2_star_title');
								$star_image_name = "2sterren4.png";
							} else if ($cruise['star'] == 3){
								$star_title = lang('3_star_title');
								$star_image_name = "3sterren4.png";
							} else if ($cruise['star'] == 4){
								$star_title = lang('4_star_title');
								$star_image_name = "4sterren4.png";
							} else if ($cruise['star'] == 5){
								$star_title = lang('5_star_title');
								$star_image_name = "5sterren4.png";
							}
						?>
						<span style="white-space: nowrap;">
							<img title="<?=$star_title?>" alt="<?=$star_title?>" src="<?=base_url() .'media/'.$star_image_name?>"></img>
						</span>
					
					</h3>
			
					
					<p class="cruise_desc">
						<?=character_limiter($cruise['description'], CRUISE_DESCRIPTION_CHR_LIMIT)?>
						<a class="function" href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>">More</a>
					</p>
					
					<div class="cruise_programs" style="float: left;">
						<?php foreach ($cruise['programs'] as $program):?>
							<div style="clear: both; padding: 5px 0">
								<a href="<?=url_builder(CRUISE_PROGRAM_DETAIL, $program['url_title'], true)?>"><?=$program['name']?></a>
								<?php if($program['min_price']['offer_price'] > 0):?>
								<span class="price_from_main">
									<span style="font-weight: normal;">From:</span>								
									<?php if($program['min_price']['price'] != $program['min_price']['offer_price']):?>
										<span style="text-decoration:line-through;"><?=CURRENCY_SYMBOL?><?=number_format($program['min_price']['price'], CURRENCY_DECIMAL)?></span>
	            							&nbsp;
									<?php endif;?>
									<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($program['min_price']['offer_price'], CURRENCY_DECIMAL)?></span>
								</span>
								<?php endif;?>
							</div>
						<?php endforeach;?>
					</div>
					<?php if($cruise['num_reviews'] > 0):?>
						<div class="cruise_review round_coner" style="float: right;">
							<div class="row"><span class="review_score"><?=$cruise['review_score']?></span> out of 5</div>
							<div class="row"><a href="<?=url_builder(CRUISE_REVIEWS, $cruise['url_title'], true)?>"><?=$cruise['num_reviews']?> reviews</a></div>
						</div>
					<?php endif;?>
				</div>
			<?php endforeach ;?>
			
			<?php if ($this->session->userdata('MENU') == MNU_HALONG_CRUISES):?>
				<a class="more_cruise" href="javascript: void(0);" onclick="more_cruise(<?=$value?>, 0)"><?=str_replace('%s', $value.' '.lang('star'), stripcslashes(lang('cruise_more_halong')))?></a>&nbsp;&nbsp;&nbsp;
			<?php else :?>
				<a class="more_cruise" href="javascript: void(0);" onclick="more_cruise(<?=$value?>, 1)"><?=str_replace('%s', $value.' '.lang('star'), stripcslashes(lang('cruise_more_mekong')))?></a>&nbsp;&nbsp;&nbsp;
			<?php endif;?>
			
		</div>
	<?php endforeach ;?>

</div>

<script>
	$(function() {
		$( "#tabs" ).tabs();
	});

	function more_cruise(star, location){
		
		$("#cruise_destinations").val("<?=lang('cruise_search_title')?>");

		$('input[id^=cruise_star_]').each(function(index) {
		
			if ($(this).val() == star){
				
				$(this).attr('checked', true);
				
			} else {
				$(this).attr('checked', false);
			}
		});

		$("#departure_port").val(location);			
		
		$("#duration option[value='']").attr('selected', 'selected');

		document.frmSearchForm.action = getSearchUrl(true);
		
		document.frmSearchForm.submit();
	}
</script>
