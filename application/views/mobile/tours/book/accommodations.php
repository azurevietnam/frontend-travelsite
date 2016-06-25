<h2 class="bpv-color-title margin-top-0"><?=lang('class_name')?></h2>

<?php foreach ($accommodations as $key => $acc):?>

<div class="bpv-panel">
	<div class="panel-heading">
	   <div class="panel-title">
	       <h3 class="bpv-color-title"><?=$acc['name']?></h3>
	    </div>
	    <div id="acc_<?=$acc['id']?>" class="bpv-toggle-content margin-top-10">
	    <?=$acc['content']?>
	    </div>
	</div>
	<div class="panel-body">
	   <div class="text-center bpv-color-promotion">
	       <?=lang('check_rate_title')?>
	       <i class="glyphicon glyphicon-arrow-up"></i>
	   </div>
	</div>
</div>

<?php endforeach;?>

<div class="margin-top-10 margin-bottom-10 clearfix">
	<?=load_bpv_call_us(TOUR)?>
</div>

<script>
$('.bpv-toggle').bpvToggle();
</script>
