<div class="lst_all_hotels">
	<h3 class="highlight"><?=lang('hotel_5_start_in', $des['name']) ?></h3>
	<ul>
		<?php foreach ($h_5_stars as $hotel) :?>			
			<li>
				<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
				<?php if($hotel['is_new']):?>
					
					<span style="font-weight: normal;" class="special"><?=lang('obj_new') ?></span>
					
				<?php endif;?>	
				
				
			</li>
		<?php endforeach ;?>
	</ul>
	
	<h3 class="highlight clearfix"><?=lang('hotel_4_start_in', $des['name']) ?></h3>
	<ul>
		<?php foreach ($h_4_stars as $hotel) :?>			
			<li>
				<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
				<?php if($hotel['is_new']):?>
					
					<span style="font-weight: normal;" class="special"><?=lang('obj_new') ?></span>
					
				<?php endif;?>	
				
				
			</li>
		<?php endforeach ;?>
	</ul>
	
	<h3 class="highlight clearfix"><?=lang('hotel_3_start_in', $des['name']) ?></h3>
	<ul>
		<?php foreach ($h_3_stars as $hotel) :?>			
			<li>
				<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
				<?php if($hotel['is_new']):?>
					
					<span style="font-weight: normal;" class="special"><?=lang('obj_new') ?></span>
					
				<?php endif;?>	
				
				
			</li>
		<?php endforeach ;?>
	</ul>	

</div>

		