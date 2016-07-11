<h1 class="highlight"><?=lang('vietnam_visa_exemption')?></h1>
<p><?=lang('vietnam_visa_exemption_desc')?></p>
<table class="tour_accom" style="margin-bottom: 20px">
	<thead>
		<tr>
			<th style="padding: 7px"><?=lang('lb_countries')?></th>
			<th style="padding: 7px"><?=lang('term_of_residence')?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($countries as $country):?>
	<?php if($country['voa_accepted'] == 2):?>
	<tr>
		<td><?=$country['name']?></td>
		<td>
			<?php $asia = array(22,22,90,62,156,138,166);?>
			<?php if(in_array($country['id'], $asia)):?>
				less than 30 days
			<?php elseif($country['id'] == 122):?>
				less than 21 days
			<?php else:?>
				less than 15 days
			<?php endif;?>
		</td>
	</tr>
	<?php endif;?>
	<?php endforeach;?>
	</tbody>
</table>
<div class="related-info">
<h3 style="padding-left: 0"><?=lang('related_visa_information')?></h3>
<?=$top_visa_questions?>
</div>