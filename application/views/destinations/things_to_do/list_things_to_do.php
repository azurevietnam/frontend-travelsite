<?php if(!empty($destination)):?>
    <h1 class="highlight"><?=lang('lbl_top_thing_to_do', $destination['name'])?></h1>
    <hr>
<?php endif;?>

<div id="activity">
        <?php foreach($things_to_do as $value):?>
            <div class="activity bpt-newbox margin-10 panel-default">
                <h2 class="panel-heading">
                    <span class="highlight">
                        <a href="<?=get_page_url(DESTINATION_THINGS_TODO_DETAIL_PAGE, $destination, $value)?>">
                            <?=$value['name']?><?php if(!empty($value['title'])) echo '-'.$value['title'];?>
                        </a>
                    </span>
                </h2>
                
                <a href="<?=get_page_url(DESTINATION_THINGS_TODO_DETAIL_PAGE, $destination, $value)?>">
                	<img width="375" height="250px" class="img-rounded" src="<?=get_image_path(PHOTO_FOLDER_ACTIVITY, $value['picture'], '375_250')?>">
                </a>
                <br>

                <div class="bpt-description">
                    <?=character_limiter(strip_tags($value['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
                </div>

                <?php if(!empty($value['tour_contain'])):?>
                    <ul>
                        <?php foreach($value['tour_contain'] as $v):?>
                            <li><a href="<?=get_page_url(TOUR_DETAIL_PAGE, $v)?>"><?=$v['name']?></a></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
            </div>
        <?php endforeach;?>
</div>

<?php if(!empty($destination)):?>

    <button class="btn btn-default margin-bottom-20 margin-top-10 btn_see_more" id="btn_see_more" ONCLICK="load_see_more('activity', <?=$destination['id']?>, this, <?=$count_activity?>, 'load_more_thing_todo','<?=$destination['url_title']?>' )"><i class="glyphicon glyphicon-triangle-bottom"></i>    <t><?=lang('field_more_activity', $destination['name'])?></button>

<?php endif;?>

<div class="clearfix"></div>