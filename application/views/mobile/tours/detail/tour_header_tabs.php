<ul class="nav nav-tabs" role="tablist" id="tour_tabs">

    <?php if(!empty($tour['cruise_id'])):?>
    
    <li role="presentation" <?=$activeTab == 'tab_check_rates' ? 'class="active"': ''?>>
	   <a href="#tab_check_rates" role="tab" data-toggle="tab" onclick="init_slider()"><?=lang('check_rates')?></a>
	</li>
	<li role="presentation" <?=$activeTab == 'tab_itinerary' ? 'class="active"': ''?>>
	   <a href="#tab_itinerary" role="tab" data-toggle="tab"><?=lang('itinerary')?></a>
	</li>
	
    <?php else:?>
    
    <li role="presentation" <?=$activeTab == 'tab_itinerary' ? 'class="active"': ''?>>
	   <a href="#tab_itinerary" role="tab" data-toggle="tab" onclick="init_slider()"><?=lang('itinerary')?></a>
	</li>
    <li role="presentation" <?=$activeTab == 'tab_check_rates' ? 'class="active"': ''?>>
	   <a href="#tab_check_rates" role="tab" data-toggle="tab"><?=lang('lbl_tour_price')?></a>
	</li>
	
    <?php endif;?>
    
	<li role="presentation" <?=$activeTab == 'tab_reviews' ? 'class="active"': ''?>>
	   <a href="#tab_reviews" role="tab" data-toggle="tab">
	   <?=ucfirst(lang('reviews'))?><?=!empty($tour['review_number']) ? ' ('.$tour['review_number'].')' : ''?>
	   </a>
    </li>
</ul>

<script>
init_mobile_tab('#tour_tabs');
</script>