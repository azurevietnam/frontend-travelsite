<?php if(!empty($highlights) || !empty($tour['tour_highlight'])):?>
<div class="trip-highlight margin-bottom-20">
    <h3><?=lang('trip_highlights')?><span class="arrow-right"></span></h3>
    
    <!-- 
    <?php if(!empty($map_photos)):?>
    <div class="col-xs-12 padding-left-20 padding-right-20 map-area" id="tour_map_area" style="display: none;">
        <div id="tour_route_map" data-id="<?=$tour['id']?>">
        </div>
        <div class="full-width map-footer text-center">
            <div class="btn btn-green btn-xs" onclick="hide_route_map('#tour_map_area')"><?=lang('btn_close_map')?></div>
        </div>
    </div>
    
    <div class="row" style="clear: both; width: 100%">
        <div class="col-xs-8" id="itinerary_highlight_content">
            <?=$itinerary_highlight?>
        </div>
        <div class="col-xs-4" id="tour_map_small">
            <?=$map_photos?>
        </div>
    </div>
    <?php else:?>
        <?=$itinerary_highlight?>
    <?php endif;?>
     -->
    
    <?=$itinerary_highlight?>
</div>
<?php endif;?>

<?php if(!empty($map_photos)):?>
<script>
var bpv_map;
var bpv_map_data;

function map_callback() {
	if ( $( "#tour_route_map" ).length ) {
    	var map_load = new Loader();
    	map_load.require(<?=get_libary_asyn('map')?>, 
    	function() {
    		bpv_map = init_route_map('#tour_route_map');
    	});
	}
}

$(function(){
	var cal_load = new Loader();
	cal_load.require(<?=get_libary_asyn('google-map', true, 'map_callback')?>, function() {});
});
</script>
<?php endif;?>