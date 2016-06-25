<div class="bpv-filter-box">
	<h3 class="bpv-color-title">
		<span class="icon icon-circle-info"></span><?=lang('category_news');?>
    </h3>
	<div class="list-group">
        <ul>
        <?php foreach ($categories as $k => $cat):?>
        
        <?php if(isset($selected_category) && $k == $selected_category['id'] ):?>
        <li class="active">
        <a href="#" class="list-group-item item-enable"><?=lang($cat)?><span class="icon icon-arrow-right-gray"></span></a>
        </li>
        <?php else:?>
        <?php
            $obj = array(
                'id' => $k,
                'url_title' => url_title(convert_unicode(lang($cat)), '-', true)
            );
        ?>
        <li>
        <a href="<?=get_url(NEWS_CATEGORY_PAGE, $obj)?>" class="list-group-item item-enable"><?=lang($cat)?><span class="icon icon-arrow-right-gray"></span></a>
        </li>
        <?php endif;?>
        <?php endforeach;?>
        </ul>
    </div>
</div>