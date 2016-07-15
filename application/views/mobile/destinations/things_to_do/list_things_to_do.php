
<?php if(!empty($destination)):?>
    <h1 class="highlight container"><?=lang('lbl_top_thing_to_do', $destination['name'])?></h1>
<?php endif;?>

<?php if(!empty($things_to_do)):?>
    <div id="activity">
        <?php foreach ($things_to_do as $value):?>
            <div class="activity bpt-mb-item clearfix" data-id="<?=$value['id']?>" onclick="go_url('<?=get_page_url(DESTINATION_THINGS_TODO_DETAIL_PAGE, $destination, $value)?>')">
                <img class="bpt-mb-item-image pull-left" alt="<?=$value['name']?>" src="<?=get_image_path(PHOTO_FOLDER_ACTIVITY, $value['picture'], '375_250')?>">

                <div class="bpt-mb-item-name highlight">
                    <?=$value['name']?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
<?php endif;?>

<?php
$end_value = count($things_to_do);

if(!empty($destination) && $end_value < $count_activity):?>

    <div class="text-center container">
        <button class="btn btn-default margin-bottom-20 margin-top-10 col-xs-12" id="btn_see_more" ONCLICK="load_see_more('activity', <?=$destination['id']?>, this, <?=$count_activity?>, 'load_more_thing_todo')"><i class="glyphicon glyphicon-triangle-bottom"></i>    <t><?=lang('field_more_activity', $destination['name'])?></button>
    </div>

<?php endif;?>
<div class="clearfix"></div>

