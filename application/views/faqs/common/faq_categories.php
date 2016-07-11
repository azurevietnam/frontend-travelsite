<div class="panel panel-default bpt-panel">
   <!-- Default panel contents -->
   <div class="panel-heading">
   	<h2>FAQs by Categories</h2>
   </div>
    <!-- List group -->
  	<div class="list-group">
        <?php foreach($categories as $key=>$value): ?>
          <a href="<?=get_page_url(FAQ_CATEGORY_PAGE, $value)?>" class="list-group-item <?= $current_category_id == $value['id'] ? 'active' : ''?>">
              <?=$value['name']?>
              <span class="icon icon-arrow-right-blue"></span>
          </a>
        <?php endforeach;?>
	</div>

</div>