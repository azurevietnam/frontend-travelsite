<?php
    $page_url = $page == HOTEL_DETAIL_PAGE ? '' : get_page_url(HOTEL_DETAIL_PAGE, $hotel);
    $link_attr = $page == HOTEL_DETAIL_PAGE ? 'role="tab" data-toggle="tab"' : '';
?>
<ul class="nav nav-tabs" role="tablist" id="hotel_tabs">
	
	
    <?php if($page == HOTEL_DETAIL_PAGE):?>
    <li role="presentation" <?=$activeTab == 'tab_check_rates' ? 'class="active"': ''?>>
	   <a href="<?=$page_url?>#tab_check_rates" <?=$link_attr?>><?=lang('check_rates')?></a>
	</li>
	
    <li role="presentation">
        <a href="<?=get_page_url(HOTEL_REVIEW_PAGE, $hotel)?>">
        <?=ucfirst(lang('reviews'))?><?=!empty($hotel['review_number']) ? ' ('.$hotel['review_number'].')' : ''?>
        </a>
    </li>
    <?php else:?>
    	<li role="presentation">
    	   <a href="<?=$page_url?>?activeTab=tab_check_rates"><?=lang('check_rates')?></a>
    	</li>
    
        <li role="presentation" class="active">
	        <a href="javascript:void(0)" role="tab" data-toggle="tab">
	        <?=ucfirst(lang('reviews'))?><?=!empty($hotel['review_number']) ? ' ('.$hotel['review_number'].')' : ''?>
	        </a>
        </li>
    <?php endif;?>
</ul>

<script>
init_mobile_tab('#hotel_tabs');
</script>