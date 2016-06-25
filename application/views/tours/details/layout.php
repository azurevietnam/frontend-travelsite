<div class="container">

    <ol class="breadcrumb">
		<li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
		<li><a href="<?=site_url(TOUR_HOME_PAGE)?>"><?=lang('mnu_tours')?></a></li>
		
		<?php if($tour['is_outbound'] == TOUR_DOMESTIC):?>
		<li><a href="<?=site_url(TOUR_DOMESTIC_PAGE)?>"><?=lang('label_domestic_tours')?></a></li>
		<?php else:?>
		<li><a href="<?=site_url(TOUR_OUTBOUND_PAGE)?>"><?=lang('label_outbound_tours')?></a></li>
		<?php endif;?>
		
		<?php if(!empty($tour['destinations'])):?>
		<?php foreach ($tour['destinations'] as $des):?>
		<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
		<?php endforeach;?>
		<?php endif;?>
		
		<li class="active"><?=$tour['name']?></li>
	</ol>

	<div class="bpv-col-left">
		
		<?php if(isset($search_overview)) echo $search_overview ?>
			
		<?=$search_form?>
			
		<div class="margin-top-20 margin-bottom-20">
			<?=load_bpv_call_us(TOUR)?>
		</div>
		
		<div class="itinerary-summary margin-top-20">
			<h3><?=lang('itinerary_summary')?></h3>
			
            <?php foreach ($tour_departures as $k => $val):?>
            
            <ul id="itinerary_summary_<?=$val['id']?>" class="itinerary-box<?php if($k > 0) echo' hide'?>">
            
            <?php foreach ($tour['departure_itinerary'][$val['id']] as $key => $value):?>
                <li class="nav-itinerary-pr">
                    <a name="itinerary_details_<?=$val['id'].'_'.$value['id']?>" class="nav-itinerary">
                    <?=get_tour_transportation($value['transportations'], true)?>
                    <?=character_limiter($value['title'], 38)?><span class="arrow-it"></span>
                    </a>
				</li>
		    <?php endforeach;?>
		    
		    </ul>
		    
		    <?php endforeach;?>
		</div>

	</div>

	<div class="bpv-col-right">
		
        <?=$basic_info?>
        
        <?=$photos?>

		<div class="clearfix margin-top-10 margin-bottom-10">
			<div class="last-review"
				<?php if( empty($last_review) ) echo 'style="width:100%"';?>>
				<span class="content">
					<?=insert_data_link(character_limiter($tour['description'], 660));?>
				</span>
			</div>
			<?php if( !empty($last_review) ):?>
			<div class="last-review-score">
				<span class="review-text"><?=get_review_text($tour['review_score'])?></span>
				<span class="review-score"><?=$tour['review_score']?></span> <span
					style="clear: both; display: block;">
					<?=lang('rev_out_of').' '?>
					<a href="javascript:void(0)" onclick="open_review('#tour_tabs')"><?=$tour['review_number'].' '.lang('rev_txt')?></a>
				</span>
			</div>
			<?php endif;?>
		</div>

		<input type="hidden" id="tab" value="<?=isset($tab) ? $tab : ''?>">
		<div class="bpv-tab bpv-tab-tours">

			<ul class="nav nav-tabs pull-left" id="tour_tabs">
				<li <?=($tab == 0) ? 'class="active"' : '';?>>
				    <a href="#tab_itinerary" data-toggle="tab"><span class="icon icon-tab-itinerary"></span><?=lang('tab_itinerary')?></a>
				</li>
				<li <?=($tab == 1) ? 'class="active"' : '';?>>
				    <a href="#tab_price_table" data-toggle="tab"><span class="icon icon-tab-price"></span><?=lang('tab_price_table')?></a>
				</li>
				<li <?=($tab == 2) ? 'class="active"' : '';?>>
				    <a href="#tab_information" data-toggle="tab"><span class="icon icon-tab-info"></span><?=lang('tab_information')?></a>
				</li>
				<li <?=($tab == 3) ? 'class="active"' : '';?>>
				    <a href="#tab_reviews" data-toggle="tab" data-url="/reviews/?tour_id=<?=$tour['id']?>">
				    <span class="icon icon-tab-review"></span><?=lang('tab_reviews')?>
				    </a>
				</li>
				<li <?=($tab == 4) ? 'class="active"' : '';?>>
				    <a href="#tab_booking" data-toggle="tab"><span class="icon icon-tab-book"></span><?=lang('tab_booking')?></a></li>
			</ul>
		</div>
		<div class="tab-content bpv-tab-tours-content">
			<div class="tab-pane <?=($tab == 0) ? 'active' : '';?>"
				id="tab_itinerary">
				<?=insert_data_link($itinerary)?>
			</div>

			<div class="tab-pane" id="tab_price_table">
			    <?=$price_table?>
			</div>
			<div class="tab-pane" id="tab_information">
			    <?=$important_info?>
			</div>
			<div class="tab-pane" id="tab_reviews"></div>
			<div class="tab-pane <?=($tab == 4) ? 'active' : '';?>"
				id="tab_booking">
			    <?=$check_rate_form?>
			    <div id="rate_content">
			    <?=$accommodations?>
			    </div>
			</div>
		</div>

		<div id="book-bottom-box" class="text-center">
			<button type="button" class="btn btn-book-tour">
				<span class="icon icon-btn-arrow-orange"></span><?=lang('book_tour')?>
            </button>
		</div>

		<div id = "btn-tour-support" class="box-support margin-top-20 margin-bottom-20">
			<div class="support-content">
			    <img class="live-support" src="<?=get_static_resources('/media/tour/tour-support.20102014.png')?>">
				<div class="bpv-color-title"><?=lang('txt_support_1')?></div>
				<i><?=lang('txt_support_2')?></i>
				<div class="text-center">
					<button type="button" class="btn btn-tour-support"><?=lang('btn_tour_support')?></button>
				</div>
			</div>
		</div>
		<div id="tour_contact" style="display:none;clear:both;">
			<?=$tour_contact;?>
		</div>
		
	</div>
</div>


<?=load_data_overview_modal()?>


<?=$similar_tours?>

<?=$bpv_register?>

<script>
$( document ).ready(function() {
	init_tour_details();
});


<?php if(isset($action) && $action == ACTION_CHECK_RATE):?>
go_check_rate_position();
check_accommodation_rates();
$('#book-bottom-box').addClass('hide');
<?php endif;?>

</script>