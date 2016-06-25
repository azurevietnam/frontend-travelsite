<?php if(!empty($tour['service_includes']) || !empty($tour['service_excludes'])):?>

<div class="bpv-collapse margin-top-10 margin-bottom-2">
    <h5 data-target="#service_includes" class="heading no-margin service-includes">
		<i class="icon icon-star-white"></i>
		<?=str_replace(':', '', lang('service_includes'))?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
	</h5>
	<div class="content" id="service_includes">
	    <?php if(!empty($tour['service_includes'])):?>
    		<h3 class="bpv-color-title"><?=lang('service_includes')?></h3>
    		<?php
    			$includes = explode("\n", $tour['service_includes']);
    			$includes = array_filter($includes, 'trim');
    		?>
    		<ul style="margin-left: -25px">
    			<?php foreach ($includes as $item) :?>
    			<?php if (!empty($item)) :?>
    				<li class="margin-bottom-5"><?=$item?></li>
    			<?php endif;?>			
    			<?php endforeach;?>
    		</ul>
		<?php endif;?>
		
		<?php if(!empty($tour['service_excludes'])):?>
        	<h3 class="bpv-color-title"><?=lang('service_excludes')?></h3>	
    		<?php
    			$excludes = explode("\n", $tour['service_excludes']);
    			$excludes = array_filter($excludes, 'trim');
    		?>
    		<ul style="margin-left: -25px">
    			<?php foreach ($excludes as $item) :?>
    			<?php if (!empty($item)) :?>
    				<li class="margin-bottom-5"><?=$item?></li>
    			<?php endif;?>			
    			<?php endforeach;?>
    		</ul>
		<?php endif;?>
	</div>
</div>

<script>
$('.service-includes').bpvToggle();
</script>
<?php endif;?>