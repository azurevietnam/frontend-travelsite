<h3 class="bpv-color-title no-margin margin-bottom-10"><span class="icon icon-info-details"></span><?=lang('tour_important_info')?></h3>

<div class="important-info">
<?php
	$notes = $tour['notes'];
	
	$notes = explode("\n", $notes);
?>
<?php if(count($notes) > 0):?>

	<ul>
		<?php foreach ($notes as $value):?>
			<?php if(!empty($value)):?>
			<li class="margin-bottom-10"><?=$value?></li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
	
<?php endif;?>

<?php if($tour['is_outbound'] == TOUR_OUTBOUND):?>
<div class="margin-top-20">
    <h4 class="bpv-color-warning"><?=lang('tour_outbound_note_title')?></h4>
    <?=lang('tour_outbound_note_content')?>
</div>
<?php endif;?>

</div>