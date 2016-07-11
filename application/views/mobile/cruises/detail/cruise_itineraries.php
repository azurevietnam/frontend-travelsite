<?php if(!empty($tours)):?>
<div class="cruise-itinerary clearfix margin-bottom-10 margin-top-10"> 
    <div class="col-xs-12">
        <label class="label-select-itinerary" for="cruise_itineraries"><?=lang('lbl_select_your_cruise_tour')?>:</label>
        <select id="cruise_itineraries" class="form-control" onchange="get_tour_itinerary()">
            <?php foreach ($tours as $key => $tour):?>
        	<?php 
        		$str_nights = ' / '.($tour['duration'] - 1). ($tour['duration'] - 1 > 1 ? ' '.lang('nights') : ' '.lang('night'));
        	?>
        	<option value="<?=$tour['url_title']?>" <?php if(!empty($selected_tour) && $tour['id'] == $selected_tour['id']):?>selected="selected"<?php endif;?>>
        	<?=$tour['name'].$str_nights?></option>
        	<?php endforeach;?>
        </select>
    </div>
</div>
<?php endif;?>

<div id="detail_tour_itinerary">
<?php if(!empty($tour_itinerary)):?>
    <?=$tour_itinerary?>
<?php endif;?>
</div>