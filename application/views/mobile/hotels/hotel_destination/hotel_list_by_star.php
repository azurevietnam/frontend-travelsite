<?php if(!empty($h_5_stars) || !empty($h_4_stars) || !empty($h_3_stars)):?>
<div class="all-hotel-in-des">
	<div class="container">
		<?php if(!empty($h_5_stars)):?>
		<div class="clearfix">
			<h2 class="bpv-color-title">
				<?=lang('5_star_hotels_in') . ' ' . $destination['name']?>
				
				<span class="icon star-5"></span>
			</h2>
			
			<?php foreach ($h_5_stars as $hotel) :?>
				<div class="col">
					<a href="<?=hotel_build_url($hotel)?>"><?=$hotel['name']?></a>
				</div>
			<?php endforeach;?>
		</div>
		<?php endif;?>
		
		<?php if(!empty($h_4_stars)):?>
		<div class="clearfix">
			<h2 class="bpv-color-title">
				<?=lang('4_star_hotels_in') . ' ' . $destination['name']?>
				
				<span class="icon star-4"></span>
			</h2>
			
			<?php foreach ($h_4_stars as $hotel) :?>
				<div class="col">
					<a href="<?=hotel_build_url($hotel)?>"><?=$hotel['name']?></a>
				</div>
			<?php endforeach;?>
		</div>
		<?php endif;?>
		
		<?php if(!empty($h_3_stars)):?>
		<div class="clearfix">
			<h2 class="bpv-color-title">
				<?=lang('3_star_hotels_in') . ' ' . $destination['name']?>
				
				<span class="icon star-3"></span>
			</h2>
			
			<?php foreach ($h_3_stars as $hotel) :?>
				<div class="col">
					<a href="<?=hotel_build_url($hotel)?>"><?=$hotel['name']?></a>
				</div>
			<?php endforeach;?>
		</div>
		<?php endif;?>
	</div>
</div>
<?php endif;?>