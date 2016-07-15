<?php
	$nr_rooms = count($room_types);
?>

<table class="table bpt-table-check-rate table-bordered">
      <thead>
        <tr>
          <th><?=lang('lbl_room_types')?></th>
          <th class="text-center"><?=lang('lbl_room_size')?></th>
	      <th class="text-center"><?=lang('lbl_bed_size')?></th>
          <th class="text-center"><?=lang('lbl_book_reservation')?></th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach ($room_types as $key => $value):?>
      		 <tr>
      		 	<td>
      		 		<!--
      		 		<?php if(!empty($value['picture'])):?>
      		 			<img  width="100" height="75"  src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $value['picture'], '120_90')?>">
      		 		<?php endif;?>
      		 		 -->
      		 		<a class="vertical-align-top" href="javascript:void()" data-toggle="modal" data-target="#room_info_<?=$value['id']?>">
      		 			<span class="glyphicon glyphicon-triangle-right text-special vertical-align-top"></span> <?=$value['name']?>
      		 		</a>
      		 	</td>
	           <td width="15%" valign="middle" align="center">
		          	<?=lang('lbl_m2', $value['room_size'])?>
		          </td>
		          <td width="20%" valign="middle" align="center">
		          	<?=$value['bed_size']?>
		          </td>
	          <?php if($key == 0):?>
	          	<td width="25%" rowspan="<?=$nr_rooms?>" valign="middle" align="center">
	          		<div>
		          		<span class="icon icon-circle-arrow-up-organe"></span>
		          		<br>
		          		<label><?=lang('lbl_please_enter_check_in_date')?></label>
	          		</div>
	          	</td>
	          <?php endif;?>
	        </tr>
      	<?php endforeach;?>
      </tbody>
</table>

<?php foreach ($room_types as $key => $value):?>
	<?=$value['room_info']?>
<?php endforeach;?>