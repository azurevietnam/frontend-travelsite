<div class="bpt-col-right pull-right">
	<?php if(empty($my_bookings)):?>
		
		<div class="shopping-cart-empty">
			<h1 class="text-highlight">
				<span class="glyphicon glyphicon-shopping-cart"></span> <?=lang('cart_empty')?>
			</h1>
			<div style="margin: 20px 0 20px 23px;">
				<a class="continue-txt" href="<?=site_url()?>"><?=lang('continue_shopping')?></a>&nbsp;&nbsp;<span class="glyphicon glyphicon-arrow-right text-special"></span>	
			</div>
			<div class="empty-cart-info">
				<?=lang('my_booking_shopping_cart_empty') ?>
			</div>
		</div>
		
	<?php else:?>		
		<?=$booking_steps?>
		<div>
			<span class="glyphicon glyphicon-arrow-left text-special margin-bottom-20"></span>&nbsp;&nbsp;
			<a class="continue-txt" href="<?=site_url()?>"><?=lang('continue_shopping')?></a></div>
		<?=$my_booking_table?>
		<div class="empty-cart-info text-right">
			<a class="link" style="text-decoration: underline;font-weight: 600;font-style: italic;" href="javascript:void(0)" onclick="empty()" ><?=lang('empty_booking')?></a>
		</div>
		<div class="text-center">
			<a href="<?=get_page_url(SUBMIT_BOOKING_PAGE)?>" class="btn btn-blue btn-lg">
				<?=lang('proceed_checkout')?>
				<span class="glyphicon glyphicon-circle-arrow-right"></span>
			</a>
		</div>
		
		<?=$recommend_sevices?>
	<?php endif;?>	
</div>
<div class="bpt-col-left pull-left">
	<?=$tour_search_form?>
	
	<?=$how_to_book_trip?>

	<?=$faq_by_page?>
</div>

