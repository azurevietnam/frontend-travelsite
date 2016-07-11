<div>
	<p class="item_text_desc"><span><?=lang('cruise_properties_description')?><b><?=$cruise_name?></b>:</span></p>
	
	<table width="700" class="tour_accom" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th align="center" width="20%"><?=lang('cruise_specifications')?></th>
				<?php foreach ($members as $member):?>
					<th align="center"><?=$member['name']?></th>
				<?php endforeach;?>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach ($properties as $property):?>
				<tr>
					<td align="center"><?=$property['name']?></td>
					
					<?php foreach ($members as $member):?>
						<?php if (isset($member_properties[$property['id']]) && isset($member_properties[$property['id']][$member['id']])):?>
							<td align="center"><?=$member_properties[$property['id']][$member['id']]['value']?></td>
						<?php else:?>
							<td align="center">
						<?php endif;?>
					<?php endforeach;?>
				</tr>
				
			<?php endforeach;?>
		</tbody>
	</table>
</div>

<?php 
	$has_deck_plan = false;
	
	foreach ($members as $member){
		if (count($member['photos']) > 0){
			$has_deck_plan = true;
			break;
		}
	}

?>
<?php if ($has_deck_plan):?>
	<div class="margin_top_10">
		
		<h2 class="highlight" style="padding: 0"><?=lang('cruise_deck_plan')?>:</h2>
		
		<div class="margin_top_10">	
		<?php foreach ($members as $member):?>
						 
			<?php if (count($member['photos']) > 0):?>
				<?php foreach ($member['photos'] as $key =>$value) :?>
				<div style="width: 100%" id="deck_plan_<?=$value['id']?>">
					
					<img width="100%" src="<?=$this->config->item('cruise_medium_path').$value['name']?>">
										
					<center><b><?=$value['description']?></b></center>
					<br/>
				</div>			
				<?php endforeach;?>
			<?php endif;?>	
		<?php endforeach;?>
		
		</div>
	
	</div>
<?php endif;?>