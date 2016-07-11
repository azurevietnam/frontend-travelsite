<div class="panel panel-default bpt-panel">
   <!-- Default panel contents -->
   <div class="panel-heading">
   	<h2><?=lang('field_faqs_by_destination')?></h2>
   </div>
  	
    <!-- List group -->
  	<div class="list-group">
        <?php foreach($destinations as $key=>$value):?>
            <div class="panel-heading">
                <h3><?=$key?></h3>
            </div>
            <?php foreach($destinations[$key] as $destination):?>
                  <a href="<?=get_page_url(FAQ_DESTINATION_PAGE, $destination)?>" class="list-group-item <?php if($destination['id'] == $current_destination_id) echo 'active'?>">
                    <?=$destination['name']?>
                      <span class="icon icon-arrow-right-blue"></span>
                  </a>
	        <?php endforeach;?>
        <?php endforeach;?>
	</div>

</div>