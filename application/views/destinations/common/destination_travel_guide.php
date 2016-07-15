<div class="bpt-left-block bpt-travel-guide">
    <h2 class="title"><span class="icon icon-travel-guide margin-right-10 margin-left-5"></span><?=lang('field_travel_guide', $destination['name'])?></h2>
    <ul class="list-unstyled">
        <li>
            <a href="<?=get_page_url(DESTINATION_DETAIL_PAGE, $destination)?>">
                <div class="col-xs-4" style="width: 40%">
                    <img width="80px" height="60px" class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_DESTINATION, $destination['picture'], '80_60')?>">
                </div>
                <div class="col-xs-7 content"><?=lang('mnu_title_about_us', $destination['name'])?></div>
                <div class="text-right" style="padding-top: 20px">
                    <span class="icon icon-arrow-right-orange"></span>
                </div>
            </a>
            <div class="clearfix"></div>
        </li>
        <?php if(!empty($articles)) foreach($articles as $value):?>
            <li>
                <a href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $value)?>">
                    <div class="col-xs-4" style="width: 40%">
                        <img width="80px" height="60px" class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_ARTICLE, $value['picture'], '80_60')?>">
                    </div>
                    <div class="col-xs-7 content"><?=$value['name']?></div>
                    <div class="text-right" style="padding-top: 20px">
                        <span class="icon icon-arrow-right-orange"></span>
                    </div>
                </a>
                <div class="clearfix"></div>
            </li>
        <?php endforeach;?>
    </ul>
    <div class="text-right clearfix">
        <a href="<?=get_page_url(DESTINATION_ARTICLE_PAGE, $destination)?>"><?=lang('field_view_all_articles')?><span class="icon icon-double-arrow margin-bottom-5"></span></a>
    </div>
</div>