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
          <div class="clearfix">
              <div>
                  <label class="text-unhighlight"><?=lang('lbl_room_size')?>:</label> <?=lang('lbl_m2', $room['room_size'])?>
              </div>
              <div>
                  <label class="text-unhighlight"><?=lang('lbl_bed_size')?>:</label> <?=$room['bed_size']?>
              </div>

              <?php if(!empty($room['facilities'])):?>

                  <h4 class="text-highlight margin-top-5"><b><?=lang('lbl_room_facilities')?></b></h4>

                  <ul class="bpt-list-checked list-unstyled">
                      <?php foreach ($room['facilities'] as $value):?>
                          <li class="col-xs-6 padding-left-0 margin-bottom-5">
                              <?php if($value['important'] == STATUS_ACTIVE):?>
                                  <b><span class="glyphicon glyphicon-ok text-choice margin-right-5"></span><?=$value['name']?></b>
                              <?php else:?>
                                  <span class="glyphicon glyphicon-ok text-choice margin-right-5"></span><?=$value['name']?>
                              <?php endif;?>
                          </li>
                      <?php endforeach;?>
                  </ul>
              <?php endif;?>
          </div>
      </div>
        <div class="modal-footer modal-background-footer text-center">
            <div class="col-xs-8 col-xs-offset-2">
                <button type="button" class="btn btn-blue btn-block" data-dismiss="modal"><?=lang('lbl_close')?></button>
            </div>
        </div>
    </div>
  </div>
</div>