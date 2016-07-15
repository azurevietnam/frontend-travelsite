
<?php if(!empty($destination)):?>
    <div class="bpt-left-block">
        <h2 class="text-highlight title"><span class="icon icon-destination-info"></span><?=lang('label_explore').' '.$destination['name']?></h2>
        <ul class="list-unstyled">
            <li><a href="<?=get_page_url(DESTINATION_DETAIL_PAGE, $destination)?>"><span class="icon icon-arrow-right-orange"></span><?=lang('mnu_title_about_us', $destination['name'])?></a></li>

            <?php if($count_things_todo > 0):?>
                <li><a href="<?=get_page_url(DESTINATION_THINGS_TO_DO_PAGE, $destination)?>" ><span class="icon icon-arrow-right-orange"></span><?=lang('field_thing_to_do_in', $destination['name'])?></a></li>
            <?php endif;?>

            <?php if($count_attractions > 0):?>
                <li><a href="<?=get_page_url(DESTINATION_ATTRACTION_PAGE, $destination)?>"><span class="icon icon-arrow-right-orange"></span><?=lang('field_attractions')?></a></li>
            <?php endif;?>

            <?php if($count_articles > 0):?>
                <li><a href="<?=get_page_url(DESTINATION_ARTICLE_PAGE, $destination)?>"><span class="icon icon-arrow-right-orange"></span><?=lang('field_travel_articles')?></a></li>
            <?php endif;?>

            <?php if(!empty($usefull_information)) foreach($usefull_information as $value):?>
                <li><a href="<?=get_page_url(DESTINATION_INFORMATION_PAGE,$destination, $value)?>"><span class="icon icon-arrow-right-orange"></span><?=$value['name']?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>

