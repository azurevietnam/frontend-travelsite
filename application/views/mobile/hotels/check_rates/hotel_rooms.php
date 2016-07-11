	<?php
		$nr_rooms = count($room_types);
	?>

    <?php foreach ($room_types as $key => $value):?>

        <div class="bpv-panel">
            <div class="panel-heading">
                <div class="panel-title bpv-toggle" data-target="#room_<?=$value['id']?>">
                    <div class="row">
                        <div class="col-xs-10">
                            <h3 class="bpv-color-title"><?=$value['name']?></h3>
                            <?=lang('lbl_m2', $value['room_size'])?>, <?=$value['bed_size']?>
                        </div>
                        <div class="col-xs-2 padding-left-0 text-right">
                            <span class="bpv-toggle-icon icon icon-chevron-down"></span>
                        </div>
                    </div>
                </div>
                <div id="room_<?=$value['id']?>" class="bpv-toggle-content margin-top-10">
                    <?php if(!empty($value['picture'])):?>
                        <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $value['picture'], '468_351')?>">
                    <?php endif;?>
                    <div class="margin-top-10">
                        <?=$value['description']?>
                    </div>

                    <button type="button" class="btn btn-default center-block margin-top-5" data-toggle="modal" data-target="#room_info_<?=$value['id']?>">
                        <?=lang('field_room_info')?> <span class="icon icon-chevron-right"></span>
                    </button>
                    <?=$value['room_info']?>
                </div>
            </div>
            <div class="panel-body">
                <div class="text-center text-special">
                    <?=ucfirst(lang('lbl_please_enter_check_in_date'))?>
                    <i class="glyphicon glyphicon-arrow-up"></i>
                </div>
            </div>
        </div>
    <?php endforeach;?>

<script>
   // $('.bpv-toggle').bpvToggle();
	$('.bpv-toggle').bpvToggle(function(){
		var icon = $( '.bpv-toggle-icon', $( this ));
		if( $(icon).hasClass ('icon-chevron-down') ) {
			$(icon).toggleClass ('icon-chevron-up');
		}
	});
</script>
