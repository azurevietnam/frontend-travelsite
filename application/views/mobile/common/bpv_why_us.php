<div class="bpv-unbox bpv-why-us">
	<h2 class="bpv-color-title">
		<?php if($page == HOME_PAGE):?>
			<?=lang('why_choose_us')?>
		<?php endif;?>
		
		<?php if($page == FLIGHT_HOME_PAGE):?>
			<?=lang('why_choose_us_flight')?>
		<?php endif;?>
	</h2>
	<div class="col-xs-6">
		<ul class="list-unstyled why-us">
			
			<?php if($page == HOME_PAGE):?>
			<li>
				<span class="icon icon-best"></span>
				<span><?=lang('why_choose_us_1')?></span>
			</li>
			<li>
				<span class="icon icon-wide-selection"></span>
				<?=lang('why_choose_us_2')?>
			</li>
			<li>
				<span class="icon icon-checker"></span>
				<?=lang('why_choose_us_3')?>
			</li>
			<?php endif;?>
			
			<?php if($page == FLIGHT_HOME_PAGE):?>
				<li>
					<span class="icon icon-best"></span>
					<span><?=lang('why_choose_us_1_flight')?></span>
				</li>
				<li>
					<span class="icon icon-wide-selection"></span>
					<?=lang('why_choose_us_2_flight')?>
				</li>
				<li>
					<span class="icon icon-checker"></span>
					<?=lang('why_choose_us_3_flight')?>
				</li>
			<?php endif;?>
			
		</ul>
	</div>
	<div class="col-xs-6">
		<ul class="list-unstyled why-us">
			<li>
				<span class="icon icon-groupon"></span>
				<?=lang('why_choose_us_4')?>
			</li>
			<li>
				<span class="icon icon-lowest-fee"></span>
				<?=lang('why_choose_us_5')?>
			</li>
			<li>
				<span class="icon icon-book-together"></span>
				<?=lang('why_choose_us_6')?>
			</li>
		</ul>
	</div>
</div>