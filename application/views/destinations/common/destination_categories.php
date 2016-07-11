<div class="panel panel-default bpt-panel">
   <!-- Default panel contents -->
   <div class="panel-heading">
   	<h2 class="highlight"><b><?=lang('field_travel_guide', $destination['name'])?></b></h2>
   </div>

    <!-- List group -->
  	<div class="list-group">
	  <a href="<?=get_page_url(DESTINATION_DETAIL_PAGE, $destination)?>" class="list-group-item <?php if($page == DESTINATION_DETAIL_PAGE) echo 'active';?>">
	    <?=lang('field_overview', $destination['name'])?>
          <span class="icon icon-arrow-right-blue"></span>
	  </a>
	  <a href="<?=get_page_url(DESTINATION_THINGS_TO_DO_PAGE, $destination)?>" class="list-group-item <?php if($count_things_todo == 0) echo 'hidden '; if($page == DESTINATION_THINGS_TO_DO_PAGE) echo 'active';?>">
          <?=lang('field_thing_to_do')?>
          <span class="icon icon-arrow-right-blue"></span>
      </a>
          <?php if($destination['type'] == DESTINATION_TYPE_COUNTRY):?>
                <a href="<?=get_page_url(DESTINATION_CITY_IN_COUNTRY, $destination)?>" class="list-group-item <?php if($count_attractions == 0) echo 'hidden '; if($page == DESTINATION_ATTRACTION_PAGE) echo 'active';?>">
                    <?=lang('field_city_in', $destination['name'])?>
                    <span class="icon icon-arrow-right-blue"></span>
                </a>
          <?php else:?>
                <a href="<?=get_page_url(DESTINATION_ATTRACTION_PAGE, $destination)?>" class="list-group-item <?php if($count_attractions == 0) echo 'hidden '; if($page == DESTINATION_ATTRACTION_PAGE) echo 'active';?>">
                    <?=lang('field_attractions')?>
                    <span class="icon icon-arrow-right-blue"></span>
                </a>
          <?php endif;?>

	  <a href="<?=get_page_url(DESTINATION_ARTICLE_PAGE, $destination)?>" class="list-group-item <?php if($count_articles == 0) echo 'hidden '; if($page == DESTINATION_ARTICLE_PAGE || $page == DESTINATION_ARTICLE_DETAIL_PAGE) echo 'active';?>">
          <?=lang('field_travel_articles')?>
          <span class="icon icon-arrow-right-blue"></span>
      </a>

    <?php if(!empty($usefull_information)):?>
        <?php foreach($usefull_information as $value):?>
            <a href="<?=get_page_url(DESTINATION_INFORMATION_PAGE,$destination, $value)?>" class="list-group-item <?php if($page == DESTINATION_INFORMATION_PAGE && $usefull_select['id'] == $value['id']) echo 'active';?>">
                <?=$value['name']?>
                <span class="icon icon-arrow-right-blue"></span>
            </a>
        <?php endforeach;?>
    <?php endif;?>

    </div>

</div>