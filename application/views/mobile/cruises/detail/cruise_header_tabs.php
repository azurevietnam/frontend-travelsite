<?php
    $page_url = get_page_url(CRUISE_DETAIL_PAGE, $cruise);
?>
<ul class="nav nav-tabs" role="tablist" id="cruise_tabs">
    <?php if($page == CRUISE_DETAIL_PAGE):?>
    <li role="presentation" <?=$activeTab == 'tab_check_rates' ? 'class="active"': ''?>>
	   <a href="#tab_check_rates" role="tab" data-toggle="tab"><?=lang('check_rates')?></a>
	</li>
	<li role="presentation" <?=$activeTab == 'tab_itinerary' ? 'class="active"': ''?>>
	   <a href="#tab_itinerary" role="tab" data-toggle="tab"><?=lang('itinerary')?></a>
	</li>
    <li role="presentation">
        <a href="<?=get_page_url(CRUISE_REVIEW_PAGE, $cruise)?>">
        <?=ucfirst(lang('reviews'))?><?=!empty($cruise['review_number']) ? ' ('.$cruise['review_number'].')' : ''?>
        </a>
    </li>
    <?php else:?>
        <li role="presentation">
    	   <a href="<?=$page_url?>?activeTab=tab_check_rates"><?=lang('check_rates')?></a>
    	</li>
    	<li role="presentation">
    	   <a href="<?=$page_url?>?activeTab=tab_itinerary"><?=lang('itinerary')?></a>
    	</li>
        <li role="presentation" class="active">
            <a href="javascript:void(0)" role="tab" data-toggle="tab">
            <?=ucfirst(lang('reviews'))?><?=!empty($cruise['review_number']) ? ' ('.$cruise['review_number'].')' : ''?>
            </a>
        </li>
    <?php endif;?>
</ul>

<script>
init_mobile_tab('#cruise_tabs');
</script>