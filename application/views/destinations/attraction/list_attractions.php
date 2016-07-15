
<?php if(!empty($destination)):?>
    <?php if($destination['type'] == DESTINATION_TYPE_COUNTRY):?>
        <h1 class="highlight"><?=lang('field_city_in', $destination['name'])?></h1>
    <?php else:?>
        <h1 class="highlight"><?=lang('lbl_attraction', $destination['name'])?></h1>
    <?php endif;?>
    <hr>
<?php endif;?>
<div id="attraction">
    <?php foreach($attractions as $value):?>
        <div class="attraction bpt-newbox margin-10 panel-default">
            <h2 class="panel-heading">
                <a href="<?=get_page_url(DESTINATION_DETAIL_PAGE, $value)?>" class="highlight">
                    <?=$value['name']?> <?php if(!empty($value['title'])) echo ' - '.$value['title']?>
                </a>
            </h2>
            <a href="<?=get_page_url(DESTINATION_DETAIL_PAGE, $value)?>">
                <img width="375px" height="250px" class="img-rounded" src="<?=get_image_path(PHOTO_FOLDER_DESTINATION, $value['picture'], '375_250')?>">
            </a>
            <br>
            <div class="bpt-description">
                <?=character_limiter(strip_tags($value['short_description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
            </div>
        </div>
    <?php endforeach;?>
</div>

<?php
    $end_value = count($attractions);

    if(!empty($destination)):
?>

    <button class="btn btn-default margin-bottom-20 margin-top-10 btn_see_more" id="btn_see_more" ONCLICK="load_see_more('attraction', <?=$destination['id']?>, this, <?=$count_attractions?>, 'load_more_attraction')"><i class="glyphicon glyphicon-triangle-bottom"></i>    <t><?=($destination['type'] == DESTINATION_TYPE_COUNTRY) ? lang('field_more_city', $destination['name']) : lang('field_more_attraction', $destination['name'])?></button>

<?php endif;?>
<div class="clearfix"></div>