<div class="booking_steps">
	
	<?php 
		$action = $this->uri->segment(1);
	?>
	
	<?php if($action == 'tour-booking'):?>
		<h1 class="highlight"><?=lang('how_to_book_a_trip')?></h1>
	<?php else:?>
		<h2 class="highlight"><?=lang('how_to_book_a_trip')?></h2>	
	<?php endif;?>

	<div class="row"><span class="step highlight">1</span><span id="step_1"><span class="step_content highlight"><?=lang('step_1')?></span> <span class="icon icon-help"></span></span></div>
	<div class="row" id="step_2"><span class="step highlight">2</span><span id="step_2"><span class="step_content highlight"><?=lang('step_2')?></span> <span class="icon icon-help"></span></span></div>
	<div class="row" id="step_3"><span class="step highlight">3</span><span id="step_3"><span class="step_content highlight"><?=lang('step_3')?></span> <span class="icon icon-help"></span></span></div>
	<div class="row" id="step_4"><span class="step highlight">4</span><span id="step_4"><span class="step_content highlight"><?=lang('step_4')?></span> <span class="icon icon-help"></span></span></div>
	<div class="row" id="step_5"><span class="step highlight">5</span><span id="step_5"><span class="step_content highlight"><?=lang('step_5')?></span> <span class="icon icon-help"></span></span></div>
	<div class="row" style="text-align:right;padding-top:0;padding-bottom:0"><a href="/Faqs_What-is-your-booking-process.html"><?=lang('label_learn_more') ?> &raquo;</a></div>	
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#step_1').tipsy({fallback: "<?=lang('step_1_desc')?>", gravity: 's', width: '350px', title: "<?=lang('step_1_title')?>"});
	$('#step_2').tipsy({fallback: "<?=lang('step_2_desc')?>", gravity: 's', width: '350px', title: "<?=lang('step_2_title')?>"});
	$('#step_3').tipsy({fallback: "<?=lang('step_3_desc')?>", gravity: 's', width: '350px', title: "<?=lang('step_3_title')?>"});
	$('#step_4').tipsy({fallback: "<?=lang('step_4_desc')?>", gravity: 's', width: '480px', title: "<?=lang('step_4_title')?>"});
	$('#step_5').tipsy({fallback: "<?=lang('step_5_desc')?>", gravity: 's', width: '350px', title: "<?=lang('step_5_title')?>"});
});	
</script>