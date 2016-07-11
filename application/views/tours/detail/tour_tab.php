<div class="bpt-tab bpt-tab-tours" id="tab_tours">
    <ul class="nav nav-tabs" role="tablist">
        <?php if(!empty($tour['cruise_id'])):?>
        <li role="presentation" class="active">
            <a href="#tour_rate" aria-controls="tour_rate" role="tab" data-toggle="tab">
            <span class="icon icon-tab-rate"></span>
            <?=lang('check_rates')?>
            </a>
        </li>
        <li role="presentation">
            <a href="#tour_itinerary" aria-controls="tour_itinerary" role="tab" data-toggle="tab">
            <span class="icon icon-tab-itinerary"></span>
            <?=lang('cruise_program_itinerary')?>
            </a>
        </li>
        <?php else:?>
        <li role="presentation" class="active">
            <a href="#tour_itinerary" aria-controls="tour_itinerary" role="tab" data-toggle="tab">
            <span class="icon icon-tab-itinerary"></span>
            <?=lang('cruise_program_itinerary')?>
            </a>
        </li>
        <li role="presentation">
            <a href="#tour_rate" aria-controls="tour_rate" role="tab" data-toggle="tab">
            <span class="icon icon-tab-rate"></span>
            <?=!empty($tour['cruise_id']) ? lang('check_rates') : lang('lbl_tour_price')?>
            </a>
        </li>
        <?php endif;?>
        <li role="presentation">
            <a href="#tab_reviews" aria-controls="tab_reviews" role="tab" data-toggle="tab">
            <span class="icon icon-tab-review"></span>
            <?=lang('cruise_review')?>
            </a>
        </li>
    </ul>
</div>

<div class="tab-content bpt-tab-tours-content">
    <?php if(!empty($tour['cruise_id'])):?>
    <div role="tabpanel" class="tab-pane active" id="tour_rate">
    	<?=$check_rate_form?>
    	<?=$tour_rate_table?>
    	<?=$tour_booking_conditions?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tour_itinerary">
    	<?=$tour_itinerary?>
    </div>
    <?php else:?>
    <div role="tabpanel" class="tab-pane active" id="tour_itinerary">
    	<?=$tour_itinerary?>

    	<?php if(1!=1):?>
    	<!-- 
        <div class="clearfix text-center margin-top-10 margin-bottom-10">
            <button type="button" class="btn btn-green" onclick="go_url('ajax/download/download_tour_itinerary/'+'<?=$tour['url_title']?>')">
                <span class="glyphicon glyphicon-download-alt"></span>
                <?=lang('btn_down_tour_itinerary')?>
            </button>
        </div>
         -->
        <?php endif;?>
        		
    	<div class="clearfix text-center margin-top-10 margin-bottom-10">
    	   <button type="button" class="btn btn-lg btn-yellow btn_book_tour">               
               <?=lang('btn_book_this_tour')?>
               <span class="glyphicon glyphicon-circle-arrow-right"></span>
           </button>
    	</div>

    	<?php if($tour['partner_id'] == BESTPRICE_VIETNAM_ID):?>
	    	<div class="clearfix text-center margin-top-10">
				<div class="btn btn-lg btn-green" onclick="go_url('/customize-tours/<?=$tour['url_title']?>/')">
				<?=lang('label_customize_this_tour')?> <span class="glyphicon glyphicon-circle-arrow-right"></span>
				</div>
			</div>
		<?php endif;?>
    	
    </div>
    <div role="tabpanel" class="tab-pane" id="tour_rate">
    	<?=$check_rate_form?>
    	<?=$tour_rate_table?>
    	
    	<?php if(!empty($extra_saving_recommend) && !empty($tour_booking_conditions)):?>
    		<?=$extra_saving_recommend?>
    	<?php endif;?>
    	
    	<?=$tour_booking_conditions?>
    </div>
    <?php endif;?>
    <div role="tabpanel" class="tab-pane" id="tab_reviews">
        <?=$customer_reviews?>

        <div class="clearfix text-center margin-top-10 margin-bottom-10">
            <button type="button" class="btn btn-yellow btn_book_tour">
                <span class="glyphicon glyphicon-circle-arrow-right"></span>
                <?=lang('btn_book_this_tour')?>
            </button>
        </div>
    </div>
</div>
