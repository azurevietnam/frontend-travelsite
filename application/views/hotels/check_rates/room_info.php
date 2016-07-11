<div class="modal fade" id="room_info_<?=$room['id']?>" tabindex="-1" role="dialog" aria-labelledby="<?=$room['name']?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span></button>
        <h2 class="modal-title text-highlight" id=room_label_<?=$room['id']?>>
        	<?=$room['name']?>
        </h2>
      </div>
      <div class="modal-body">
      	
      	<div class="row">
      		<div class="col-xs-6">
      			<?php if(!empty($room['picture'])):?>
      				<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $room['picture'], '468_351')?>">
      			<?php endif;?>
      			<div class="margin-top-10">
      				<?=$room['description']?>
      			</div>
      		</div>
      		
      		<div class="col-xs-6">
      			<div>
      				<label class="text-unhighlight"><?=lang('lbl_room_size')?>:</label> <?=lang('lbl_m2', $room['room_size'])?>
      			</div>
      			<div>
      				<label class="text-unhighlight"><?=lang('lbl_bed_size')?>:</label> <?=$room['bed_size']?>
      			</div>
      			<?php if(!empty($room['facilities'])):?>
      			
      				<h4 class="text-highlight"><b><?=lang('lbl_room_facilities')?></b></h4>
      				
      				<ul class="bpt-list-checked list-unstyled">
      					<?php foreach ($room['facilities'] as $value):?>
      						<li class="col-xs-6">
      						<?php if($value['important'] == STATUS_ACTIVE):?>
      							<b><?=$value['name']?></b>
      						<?php else:?>
      							<?=$value['name']?>
      						<?php endif;?>
      						</li>
      					<?php endforeach;?>
      				</ul>
      			<?php endif;?>
      			
      		</div>
      		
      	</div>
      
      </div>
      <div class="modal-footer modal-background-footer">
        <button type="button" class="btn btn-blue" data-dismiss="modal"><?=lang('lbl_close')?></button>
      </div>
    </div>
  </div>
</div>