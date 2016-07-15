<div class="lst_all_hotels">
	<h3 class="highlight"><?=lang('hotel_popular_cities') ?></h3>
	<ul>
		<?php foreach ($hotel_destinations as $destination) :?>			
			<li>
				<?php if($destination['is_top_hotel']):?>
					<a href="<?=url_builder(MODULE_HOTELS, $destination['url_title'].'-'.MODULE_HOTELS)?>"><b class="highlight"><?=$destination['name']?></b> (<?=$destination['number_hotels']?>)<span class="icon star1" style="width:11px"></span></a>
				<?php else:?>
					<a href="<?=url_builder(MODULE_HOTELS, $destination['url_title'].'-'.MODULE_HOTELS)?>"><?=$destination['name']?>(<?=$destination['number_hotels']?>)</a>
				<?php endif;?>
			</li>
		<?php endforeach ;?>
	</ul>
		
</div>

		