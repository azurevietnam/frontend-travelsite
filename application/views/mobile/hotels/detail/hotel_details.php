<?=$hotel_header_tabs?>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane <?=$activeTab == 'tab_check_rates' ? 'active': ''?>" id="tab_check_rates">
        <?=$photo_slider?>
    
        <div class="container margin-top-10">
            <?=$hotel_header?>
        </div>
        
        <?=$hotel_tab?>
        
        <?=$similar_hotels?>
    </div>
</div>



<script>
get_hotel_price_from();

$('.heading').bpvToggle();

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