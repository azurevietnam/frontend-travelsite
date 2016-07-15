<?=$tour_header_tabs?>

<div class="tab-content">

    <?php if(!empty($tour['cruise_id'])):?>
    <div role="tabpanel" class="tab-pane <?=$activeTab == 'tab_check_rates' ? 'active': ''?>" id="tab_check_rates">
        <?=$photo_slider?>
    
        <div class="container margin-top-10">
            <?=$tour_header?>
        </div>
        
         <?php if(!empty($tour['special_offers'])):?>
			<div  class="container margin-top-10">
				<?=$tour['special_offers']?>
			</div>
        <?php endif;?>
        
        <?php if(!empty($popup_free_visa)):?>
        	<div  class="container">
				<?=$popup_free_visa?>
			</div>
        <?php endif;?>
        
        <?=$tour_tab?>
        
    </div>
    <div role="tabpanel" class="tab-pane <?=$activeTab == 'tab_itinerary' ? 'active': ''?>" id="tab_itinerary">
        <?=$trip_highlights?>
        
        <?=$tour_itinerary?>
        
        <div class="container margin-top-10">
        <button class="btn btn-blue btn-block btn_book_tour"><?=lang('label_book_this_tour')?></button>
        </div>
    </div>
    <?php else:?>
    <div role="tabpanel" class="tab-pane <?=$activeTab == 'tab_itinerary' ? 'active': ''?>" id="tab_itinerary">
        <?=$photo_slider?>
    
        <div class="container margin-top-10">
            <?=$tour_header?>
        </div>
        
        <?=$trip_highlights?>
        
        <?=$tour_itinerary?>
        
        <div class="container margin-top-10">
            <button class="btn btn-lg btn-yellow btn-block btn_book_tour">
            <b><?=lang('label_book_this_tour')?></b>
            <span class="glyphicon glyphicon-circle-arrow-right"></span>
            </button>
            
            <?php if($tour['partner_id'] == BESTPRICE_VIETNAM_ID):?>
        	<div class="btn btn-lg btn-green btn-block" style="margin-top: 15px" onclick="go_url('/customize-tours/<?=$tour['url_title']?>/')">
			<?=lang('label_customize_this_tour')?> <span class="glyphicon glyphicon-circle-arrow-right"></span>
			</div>
    		<?php endif;?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane <?=$activeTab == 'tab_check_rates' ? 'active': ''?>" id="tab_check_rates">
        <?=$tour_tab?>
    </div>
    <?php endif;?>
    
    <div role="tabpanel" class="tab-pane <?=$activeTab == 'tab_reviews' ? 'active': ''?>" id="tab_reviews">
        <div class="container">
        <?=$customer_reviews?>
        
        <button class="btn btn-lg btn-yellow btn-block btn_book_tour margin-top-10">
        <b><?=lang('label_book_this_tour')?></b>
        <span class="glyphicon glyphicon-circle-arrow-right"></span>
        </button>
        
        <?php if($tour['partner_id'] == BESTPRICE_VIETNAM_ID):?>
    	<div class="btn btn-lg btn-green btn-block" style="margin-top: 15px" onclick="go_url('/customize-tours/<?=$tour['url_title']?>/')">
		<?=lang('label_customize_this_tour')?> <span class="glyphicon glyphicon-circle-arrow-right"></span>
		</div>
		<?php endif;?>
        </div>
    </div>
</div>

<?php if(!empty($tour['cruise_id'])):?>
<?php $cruise = array('url_title' => $tour['cruise_url_title'])?>
<div class="container margin-top-20 margin-bottom-10">
    <a href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>" class="btn btn-default btn-block">
    <?=lang('lbl_view_cruise_ship')?>
    <span class="icon icon-chevron-right margin-left-5"></span>
    </a>
</div>
<?php endif;?>

<?=$similar_tours?>

<script>
<?php if($is_review_on):?>
show_review_tab();
<?php endif;?>

get_tour_price_from();

init_tour_detail(true);

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
