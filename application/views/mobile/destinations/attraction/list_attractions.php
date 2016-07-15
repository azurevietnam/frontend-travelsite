<?php if(!empty($destination)):?>
    <?php if($destination['type'] == DESTINATION_TYPE_COUNTRY):?>
        <h1 class="highlight container"><?=lang('field_city_in', $destination['name'])?></h1>
    <?php else:?>
        <h1 class="highlight container"><?=lang('lbl_attraction', $destination['name'])?></h1>
    <?php endif;?>
<?php endif;?>

<?php if(!empty($attractions)):?>
    <div id="attraction">
        <?php foreach ($attractions as $value):?>
            <div class="attraction bpt-mb-item clearfix" data-id="<?=$value['id']?>" onclick="go_url('<?=get_page_url(DESTINATION_DETAIL_PAGE, $value)?>')">
                <img class="img-responsive bpt-mb-item-image pull-left" src="<?=get_image_path(PHOTO_FOLDER_DESTINATION, $value['picture'], '375_250')?>">

                <a class="bpt-mb-item-name">
                    <?=$value['name']?> <?php if(!empty($value['title'])) echo ' - '.$value['title']?>
                </a>
            </div>
        <?php endforeach;?>
    </div>
<?php endif;?>

<?php
$end_value = count($attractions);

if(!empty($destination) && $count_attractions >= DESTINATION_ATTRACTION_MAX_LIST):
    ?>

    <div class="text-center container">
        <button class="btn btn-default margin-bottom-20 margin-top-10 col-xs-12" id="btn_see_more" ONCLICK="load_see_more('attraction', <?=$destination['id']?>, this, <?=$count_attractions?>, 'load_more_attraction')"><i class="glyphicon glyphicon-triangle-bottom"></i>    <t><?=lang('field_more_attraction', $destination['name'])?></button>
    </div>

<?php endif;?>

<div class="clearfix"></div>

