<div id="contentLeft">
	
		<div id="searchForm" style="margin-bottom: 10px;">
			<?=$tour_search_view?>
		</div>
		
		<?=$booking_step?>
		
		<div id="tour_faq" class="left_list_item_block">
			<?=$faq_context?>
		</div>
			
</div>

<div id="contentMain">
	
	<form id="frm_check_rate_together" name="frm_check_rate_together" method="post">	
	
	<h1 style="padding-left: 0; color: #669933"><?=lang('trip_saving_dont_miss_out')?></h1>
	<div style="width: 100%; float: left;">
		<?=$check_rate_together?>
	</div>
	<div style="width: 100%; float: left; margin-top: 10px;">
		<div style="float: left;">
			<h2 class="highlight" style="padding-left: 0">
				<span><?=$service_1['name']?></span>
				<span style="font-size: 11px; font-weight: normal;">
				(
				<?php if($service_1['service_type'] == TOUR):?>
					<a href="<?=url_builder(TOUR_DETAIL, $service_1['url_title'], true)?>" target="_blank" class="link_function"><?=lang('view_your_detail')?></a>
				<?php else:?>
					<a href="<?=url_builder(TOUR_DETAIL, $service_1['url_title'], true)?>" target="_blank" class="link_function"><?=lang('view_hotel_detail')?></a>
				<?php endif;?>
				)
				</span>
			</h2>
		</div>
		<?=$rate_view_1?>
	</div>
	
	<div style="width: 100%; float: left; margin-top: 10px;">
		<div style="float: left;">
			<h2 class="highlight" style="padding-left: 0">
				<span><?=$service_2['name']?></span>
				<span style="font-size: 11px; font-weight: normal;">
				(
				<?php if($service_2['service_type'] == TOUR):?>
					<a href="<?=url_builder(TOUR_DETAIL, $service_2['url_title'], true)?>" target="_blank" class="link_function"><?=lang('view_your_detail')?></a>
				<?php else:?>
					<a href="<?=url_builder(HOTEL_DETAIL, $service_2['url_title'], true)?>" target="_blank" class="link_function"><?=lang('view_hotel_detail')?></a>
				<?php endif;?>
				)
				</span>
			</h2>
		</div>
		<?=$rate_view_2?>
	</div>
	
	<?php if(isset($action) && $action == 'check_rate'):?>
		
		<div style="float: left;width: 100%; margin-top: 7px; color: #B30000; display: none;" id="warning_selection_<?=$service_1['id']?>">
				* <?=lang('tour_accommodation_select')?> <?=$service_1['name']?>
		</div>
		
		<?php if($mode == 1):?>
			<div style="float: left;width: 100%; margin-top: 7px; color: #B30000; display: none;" id="warning_selection_<?=$service_2['id']?>">
				* <?=lang('hotel_accommodation_select')?> <?=$service_2['name']?>
			</div>
		<?php else:?>
			<div style="float: left;width: 100%; margin-top: 7px; color: #B30000; display: none;" id="warning_selection_<?=$service_2['id']?>">
				* <?=lang('tour_accommodation_select')?> <?=$service_2['name']?>
			</div>
		<?php endif;?>
	
		<div style="width: 100%; float: left; display: none; margin-top: 10px;" id="book_extra_services">
				
			<h2 class="highlight" style="padding-left: 0"><?=lang('book_extra_services')?></h2>
			
			<?=$book_extra_services?>
			
		</div>
	
	<?php endif;?>
	
	
	
	<div style="float: right; margin: 0; margin-top: 20px;">
				
		
		<?php if(isset($action) && $action == 'check_rate'):?>
		
			<div class="btn_back" onclick="backStep()" style="float: left; margin-right: 15px; margin-top: 2px">		
				<?=lang('lb_back')?>
			</div>
				
			<div class="btn_general btn_next" onclick="nextStep()" style="float: left;">
				<span class="icon icon-cart-bg" style="margin-bottom: -1px"></span>
				<span><?=lang('add_cart')?></span>
			</div>
		<?php else:?>
			<div class="btn_back" onclick="backStep()" style="float: left; margin-top: 2px">		
				<?=lang('lb_back')?>
			</div>
		<?php endif;?>
	</div>
	
	</form>
</div>

<script type="text/javascript">

	function backStep(){

		window.location.href = 'Tour_'+ '<?=$this->uri->segment(2)?>' + '.html';
	}

	function nextStep(){

		if (!is_warning_selection(false)){

			<?php 
				$mode = $this->uri->segment(4);
			?>
			
			document.frm_check_rate_together.action = '/booktogether/<?=$service_1['url_title']?>/<?=$service_2['url_title']?>/<?=$mode?>/';

			document.frm_check_rate_together.submit();

		}
		
		

	}
	
</script>
