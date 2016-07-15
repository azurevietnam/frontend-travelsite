<div class="bpt-col-left pull-left">
	<?=$tour_search_form?>

	<?=$why_use?>

	<?=$tripadvisor?>

	<?=$how_to_book_trip?>

	<?=$cruise_tours_side?>

	<?=$similar_cruises_side?>

	<?=$faq_by_page?>

	<?=$top_tour_destinations?>
</div>
<div class="bpt-col-right pull-right">
	<?=$cruise_header?>

	<div class="photo-box cruise-slider-photo">
        <div class="pop-free-visa"><span class="icon icon-free-visa"></span><?=load_free_visa_popup($is_mobile)?></div>
        <?=$photo_slider?>
	</div>

	<?php if(!empty($cruise['description'])):?>
        <?php $descriptions = str_replace("\n", "<br>", strip_tags($cruise['description']))?>
        <div class="margin-bottom-20 col-desc clearfix pull-left">
            <span id="short_desc">
                <?=content_shorten($descriptions, CRUISE_SHORT_DESCRIPTION_LENGTH)?>
                <?php if(fit_content_shortening($descriptions, CRUISE_SHORT_DESCRIPTION_LENGTH)):?>
                <a href="javascript:void(0)" class="btn-more"><?=strtolower(lang('lb_more'))?> &raquo;</a>
                <?php endif;?>
            </span>
            <?php if(fit_content_shortening($descriptions, CRUISE_SHORT_DESCRIPTION_LENGTH)):?>
    			<span id="full_desc">
    			<?=$descriptions?>
    			<a href="javascript:void(0)" class="btn-more"><?=strtolower(lang('lb_less'))?> &laquo;</a>
    			</span>
    		<?php endif;?>
        </div>
	<?php endif;?>

	<?=$cruise_tab?>
	
	<?php if(!empty($recommend_sevices)):?>
		<?=$recommend_sevices?>
	<?php endif;?>
	
	<?=$cruise_tours?>
</div>



<input type="hidden" value="<?=$cruise['id']?>" id="cruise_id">
<input type="hidden" value="<?=$cruise['name']?>" id="cruise_name">

<script>
get_cruise_price_from();

get_tour_price_from();

var id = $('#cruise_id').val();
var name = $('#cruise_name').val();

// get deckplans
get_cruise_properties_deckplans(id, name);

get_videos(id, name);

// toggle description
$('.btn-more').click(function() {
	if( $('#short_desc').is(":visible")) {
        $('#short_desc').hide();
        $('#full_desc').show();
    } else {
    	$('#short_desc').show();
        $('#full_desc').hide();
    }
});
</script>