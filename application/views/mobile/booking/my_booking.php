<div class="container margin-top-10">
	<?php if(empty($my_bookings)):?>
		<div class="shopping-cart-empty text-center">
			<h2 class="text-highlight">
				<span class="glyphicon glyphicon-shopping-cart"></span> <?=lang('cart_empty')?>
			</h2>
			
			<a class="btn btn-blue btn-sm" href="<?=site_url()?>">
				<?=lang('continue_shopping')?>&nbsp;&nbsp;
				<span class="glyphicon glyphicon-arrow-right text-special"></span>
			</a>
		</div>
		
	<?php else:?>		
		
		<?=$booking_steps?>
		
		<div class="text-center margin-top-10 margin-bottom-10">
			<a class="btn btn-default btn-sm" href="<?=site_url()?>">
				<span class="glyphicon glyphicon-arrow-left text-special"></span>&nbsp;&nbsp;
				<?=lang('continue_shopping')?>
			</a>
		</div>	
			
		<?=$my_booking_table?>
		
		<div class="text-right margin-bottom-20">
			<a class="link" style="text-decoration: underline;font-weight:700;font-style: italic;" href="javascript:void(0)" onclick="empty()" ><?=lang('empty_booking')?></a>
		</div>
		
		<div class="text-center">
			<a href="<?=get_page_url(SUBMIT_BOOKING_PAGE)?>" class="btn btn-blue btn-lg">
				<?=lang('proceed_checkout')?>
				<span class="glyphicon glyphicon-circle-arrow-right"></span>
			</a>
		</div>
	<?php endif;?>	
</div>
