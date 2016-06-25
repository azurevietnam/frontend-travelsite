
<div class="bpv-box">
    <?php if(!empty($tour['service_includes']) || !empty($tour['service_excludes'])):?>
	<h2 class="bpv-color-title"><?=lang('service_include_exclude')?></h2>
	<div class="col-xs-6">
	<h4><?=lang('service_includes')?></h4>
		<?php if(!empty($tour['service_includes'])):?>
		
		<?php
			$includes = explode("\n", $tour['service_includes']);
			$includes = array_filter($includes, 'trim');
		?>
		<ul style="padding-left: 25px">
			<?php foreach ($includes as $item) :?>
			<?php if (!empty($item)) :?>
				<li class="margin-bottom-5"><?=$item?></li>
			<?php endif;?>			
			<?php endforeach;?>
		</ul>
		<?php endif;?>
	</div>
	<div class="col-xs-6">
	<h4><?=lang('service_excludes')?></h4>
		<?php if(!empty($tour['service_excludes'])):?>
		
		<?php
			$excludes = explode("\n", $tour['service_excludes']);
			$excludes = array_filter($excludes, 'trim');
		?>
		<ul style="padding-left: 25px">
			<?php foreach ($excludes as $item) :?>
			<?php if (!empty($item)) :?>
				<li class="margin-bottom-5"><?=$item?></li>
			<?php endif;?>			
			<?php endforeach;?>
		</ul>
		<?php endif;?>
	</div>
	<?php endif;?>
	
	<div class="col-xs-12 margin-top-10">
	   <h4><?=lang('weather_cancellation_policy')?></h4>
	   <?=lang('weather_cancellation_content')?>
	</div>
</div>
