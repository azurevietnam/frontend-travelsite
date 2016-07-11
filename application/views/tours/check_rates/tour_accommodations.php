<?php 
	$is_price_per_cabin = is_price_per_cabin($tour);
	$nr_acc = count($accommodations);
?>

<table class="table bpt-table-check-rate table-bordered">
      <thead>
        <tr>
          <th><?=$is_price_per_cabin ? lang('lbl_cruise_cabins') : lang('accommodations')?></th>
          <?php if($is_price_per_cabin):?>
	          <th class="text-center"><?=lang('lbl_cabin_size')?></th>
	          <th class="text-center"><?=lang('lbl_bed_size')?></th>
          <?php endif;?>
          <th class="text-center"><?=$is_price_per_cabin ? lang('lbl_cabin_rates') : lang('lbl_tour_price')?></th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach ($accommodations as $key => $value):?>
      		 <tr>
      		 	<td>
      		 		<!-- 
      		 		<?php if(!empty($value['picture'])):?>
      		 			<img width="100" height="75" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $value['picture'], '120_90')?>">
      		 		<?php endif;?>
					 -->
					 
					<a class="vertical-align-top" href="javascript:void()" data-toggle="modal" data-target="#acc_info_<?=$value['id']?>">
      		 			<span class="glyphicon glyphicon-triangle-right text-special vertical-align-top"></span> <?=$value['name']?>
      		 		</a>  		 		
      		 	</td>
	          <?php if($is_price_per_cabin):?>
		          <td width="15%" valign="middle" align="center">
		          	<?=lang('lbl_m2', $value['cabin_size'])?>
		          </td>
		          <td width="20%" valign="middle" align="center">
		          	<?=$value['bed_size']?>
		          </td>
	          <?php endif;?>
	          <?php if($key == 0):?>
	          	<td width="25%" rowspan="<?=$nr_acc?>"  align="center">
	          		<div>
		          		<span class="icon icon-circle-arrow-up-organe"></span>
		          		<br>
		          		<label><?=lang('label_enter_your_departure_date')?></label>
	          		</div>
	          	</td>
	          <?php endif;?>
	        </tr>
      	<?php endforeach;?>
      </tbody>
</table>

<?php foreach ($accommodations as $key => $value):?>
	<?=$value['acc_info']?>
<?php endforeach;?>