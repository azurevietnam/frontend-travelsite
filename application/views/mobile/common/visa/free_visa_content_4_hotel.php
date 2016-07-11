<span><b><?=lang('popup_free_departure_from')?>:&nbsp;</b> <span class="highlight">01 Aug 2013</span></span> <span><b>to</b> <span class="highlight">31 Dec 2014.</span></span>

<?php 
	$book_obj = isset($hotel) ? '<b>'.$hotel['name'].'</b>' : lang('popup_free_this_hotel');
?>

<p style="margin:5px 0">
	<?=lang_arg('popup_free_arrival', FREE_VISA_RATE, $book_obj)?>
	<p style="margin-top:5px; margin-bottom:0"><b><?=lang('conditions_title')?>:</b></p>
	<p style="margin-top:5px; margin-bottom:0"><?=lang_arg('popup_free_apply_book', $book_obj)?></p>
	<p style="margin-top:5px; margin-bottom:0"><?=lang('popup_free_stamp_fee')?></p>
	<p style="margin-top:5px 0"><?=lang('popup_free_promotion_not_be')?></p>	
	<p style="margin-top:5px 0"><?=lang_arg('popup_free_an_amount', FREE_VISA_RATE)?></p>
	<p style="margin-top:5px 0"><?=lang('popup_free_after_make_book')?></p>
	<a href="<?=site_url('/ads/halongbay-free-visa-20130815.html')?>"><?=lang('message_click_here')?></a> <?=lang('popup_free_see_more')?>
</p>

<b class="price"><?=lang('popup_free_big_save')?></b>