<div class="bpt-col-right pull-right">
	<h1 style="color: #669933"><?=lang('trip_saving_dont_miss_out')?></h1>
		<?=$check_rate_form?>
	<form method="get" name="book_together" action="<?=$book_together_page?>">
		
		<?php if(!empty($check_rate_params)):?>
			
			<?php foreach($check_rate_params as $key=>$value):?>
				<?php if(is_array($value)):?>
					<?php foreach ($value as $v):?>
						<input type="hidden" name="<?=$key?>[]" value="<?=$v?>">
					<?php endforeach;?>
				<?php else:?>
					<input type="hidden" name="<?=$key?>" value="<?=$value?>">
				<?php endif;?>
			<?php endforeach;?>
			
		<?php endif;?>
		
		<?=$rate_tables?>
		<?=$extra_services?>
	</form>
</div>

<div class="bpt-col-left pull-left">
	<?=$tour_search_form?>
	<?=$how_to_book_trip?>
	<?=$faq_by_page?>
</div>

