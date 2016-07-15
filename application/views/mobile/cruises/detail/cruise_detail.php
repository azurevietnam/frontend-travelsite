<?=$cruise_header_tabs?>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane <?=$activeTab == 'tab_check_rates' ? 'active': ''?>" id="tab_check_rates">
        <?=$photo_slider?>
    
        <div class="container margin-top-10">
            <?=$cruise_header?>
        </div>
        <?php if(!empty($cruise['special_offers'])):?>
			<div  class="container margin-top-10">
				<?=$cruise['special_offers']?>
			</div>
        <?php endif;?>
        
        <?php if(!empty($popup_free_visa)):?>
        	<div  class="container">
				<?=$popup_free_visa?>
			</div>
        <?php endif;?>
        
        <?=$cruise_tab?>
        
        <?=$similar_cruises?>
    </div>
    <div role="tabpanel" class="tab-pane <?=$activeTab == 'tab_itinerary' ? 'active': ''?>" id="tab_itinerary">
        <?=$cruise_itineraries?>
    </div>
</div>

<script>
get_cruise_price_from();

$('.heading').bpvToggle(function(){
	var icon = $( '.bpv-toggle-icon', $( this ));
	if( $(icon).hasClass ('icon-arrow-right-white') ) {
		$(icon).toggleClass ('icon-arrow-right-white-up');
	}
});

function remake_css() {
	$( ".heading" ).each(function( index ) {
		if(index > 0) {	
			$(this).addClass('heading-'+index);
		}
	});
}

$( document ).ready(function() {
	remake_css();
});
</script>