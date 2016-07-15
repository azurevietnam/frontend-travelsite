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
		<?=$my_booking_table?>
		<?=$contact_form?>
	<?php endif;?>	
</div>

