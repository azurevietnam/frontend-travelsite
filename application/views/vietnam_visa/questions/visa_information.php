<h1 class="highlight"><?=lang('vietnam_visa_pricing_service')?></h1>
<p><?=lang('vietnam_visa_pricing_service_desc')?></p>
<table class="table table-hover">
	<thead>
		<tr>
			<td width="50%"><b><?=lang('lb_countries')?></b></td>
			<td align="center"><b><?=lang('visa_on_arrival')?></b></td>
			<td align="center"><b><?=lang('lb_service_fee')?></b> <br><?=lang('lb_cost_per_person')?></td>
			<td align="center"><b><?=lang('lb_stamp_fee')?></b> <br><?=lang('lb_cost_per_person')?></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($countries as $country):?>
		<tr>
			<td><?=$country['name']?></td>
			<td align="center">
				<?php
					if($country['voa_accepted'] == 1) {
						echo lang('lb_avaiable');
					} elseif($country['voa_accepted'] == 2) {
						echo lang('lb_exemption');
					} else {
						echo "";
					}
				?>
			</td>
			<td align="right" class="price">
				<?php if($country['voa_accepted'] == 1):?>
				USD <?=$country['from_price']?>
				<?php endif;?>
			</td>
			<td align="right" class="price">
				<?php if($country['voa_accepted'] == 1):?>
				USD 45
				<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<div class="related-info">
<h3 style="padding-left: 0"><?=lang('related_visa_information')?></h3>
<?=$top_visa_questions?>
</div>