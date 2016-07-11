<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<form id="frmHotelSearchForm" name="frmHotelSearchForm" method="POST" onsubmit="return search_hotel()">
		<?php if(!isset($flag_home_page)):?>
    	<h2 class="highlight"><?=lang('search_hotel').' '?><span id="search_help" class="icon" style="cursor: help;"></span></h2>
    	<?php endif;?>
       	 	<div class="row row_des">
	        	<div class="column_label">
	        		<?=lang('hotel_destination')?>:
	        	</div>
	        	<div class="column_input">
		        	<input class="hotel_destination" name="destination" id="destination" title="<?=lang('hotel_search_title')?>" onfocus="searchfield_focus(this);" onblur="searchfield_blur(this)" maxlength="100" value="<?=set_value('destination', $search_criteria['destination'])?>" alt="<?=trim(lang('hotel_search_title'))?>"/>
		        	<input type="hidden" name="destination_id" id="destination_id" value="<?=set_value('destination_id', $search_criteria['destination_id'])?>"></input>
		        	<input type="hidden" name="sort_by" id="sort_by" value="<?=set_value('sort_by', $search_criteria['sort_by'])?>"></input>
		        	<input type="hidden" name="submit_action" value="" id="submit_action">
	        	</div>
       	 	</div>

        	<div class="row">
        		<div class="column_label">
        			<?=lang('hotel_star')?>:
        		</div>

				<div class="column_input">
					<div class="star">
						<?php foreach ($hotel_stars as $value) :?>
							<div style="width: 20%; float: left;">
							<input type="checkbox" id="hotel_star_<?=$value?>" name="hotel_stars[]" value="<?=$value?>" <?=set_checkbox('hotel_stars', $value, $search_criteria['hotel_stars'] != '' && in_array($value, $search_criteria['hotel_stars'])?TRUE:FALSE)?>>
							<span><?=$value?>*</span></div>
						<?php endforeach ;?>
					</div>
				</div>
        	</div>

        	<div class="row_inline">
        		<div class="column_label">
        			<?=lang('hotel_arrive')?>:
        		</div>
        		<div class="column_arrive">
        			<div id="date_picker">
		                <select name="arrival_day" id="arrival_day" onchange="changeDay('#arrival_day','#arrival_month','#arrival_date', '#hotel_night', '#departure_date_display')">
		                	<option value=""><?=date('D, Y')?></option>
		                </select>
		                &nbsp;<select name="arrival_month" id="arrival_month" onchange="changeMonth('#arrival_day','#arrival_month','#arrival_date', '#hotel_night', '#departure_date_display')">
		                	<option value=""><?=date('M, Y')?></option>
		                </select>
		                &nbsp;<input type="hidden" id="arrival_date" name="arrival_date"/>
	            	</div>
        		</div>
        	</div>

        	<div class="nights">
        		<div class="label"><?=lang('hotel_nights')?>:</div>
        		<div class="input">
		        	<select name="hotel_night" id="hotel_night" onchange="changeNight('#hotel_night','#arrival_date', '#departure_date_display')">
						<?php foreach ($hotel_nights as $value) :?>

							<option value="<?=$value?>" <?=set_select('hotel_night',$value, $value == $search_criteria['hotel_night']? true: false)?>><?=$value?></option>

						<?php endforeach ;?>
					</select>
				</div>
        	</div>


        	<div class="row_inline">
        		<div class="column_label">
        			<?=lang('hotel_depart')?>:
        		</div>
        		<div class="column_input">
        			<span id="departure_date_display"><?=lang('hotel_brithday_company') ?></span>

	        		<input type="hidden" id="departure_date" name="departure_date"/>
        		</div>
        	</div>


	        <div class="row" style="padding-top: 0;">
	        	<div id="search_hotel_button" class="btn_general btn-search highlight floatR" onclick="search_hotel()"><?=lang('hotel_search')?></div>
	        </div>
</form>


<script>
	var search_help = '<?=lang('hotel_search_help')?>';
	search_placeholder = "<?=trim(lang('hotel_search_title'))?>";
	function sort_by(item){
		<?php if(isset($compare_url)):?>
			document.frmHotelSearchForm.action =  "<?=htmlentities($compare_url, ENT_QUOTES);?>" + "&sort_by=" + item;
		<?php else :?>
			document.frmHotelSearchForm.action =  getSearchUrl(false) + "&sort_by=" + item;
		<?php endif;?>
		document.frmHotelSearchForm.sort_by.value = item;

		document.frmHotelSearchForm.submit();
	}

	function getSearchUrl(isSortby){
		var star='';
		$('input[id^=hotel_star_]').each(function(index) {

			if ($(this).attr('checked')){
				star = star + $(this).val() + ":";
			}
		});

		//if (star == '') star = "All";

		var url = 'hotels/search' + "/destination=" + ($("#destination").val() == '<?=lang('hotel_search_title')?>' ? '' : $("#destination").val());

		if (star != ''){
			star = star.substring(0, star.length - 1);
			url = url + "&star=" + star;
		}

		url = url + "&arrival_date=" + ($("#arrival_date").val());

		url = url + "&night=" + ($("#hotel_night option:selected").text());

		if (isSortby){
			url = url + "&sort_by=<?=$search_criteria['sort_by']?>";
		}

		return url;
	}
	function initHotelSearchBox() {
		if ($("#destination").val() == search_placeholder) {
			$("#destination").css("color", "#808080");
			$("#destination").css("font-style", "italic");
		}
	}
	function setSelectSearchObject(objectName){

		$('#destination_id').val('');

		for(var i = 0; i < destinations.length; i++){
			if(destinations[i].name == objectName){
				//$("#destination").val(hotels[i].destination);
				$("#destination").css("color", "");
				$("#destination").css("font-style", "");

				if (destinations[i].object_type == -1){

					$('#destination_id').val(destinations[i].id);

				} else {

					$('#destination_id').val('');

					$.each($("input[name='hotel_stars[]']"), function() {

						$(this).attr('checked', false);

						if ($(this).val() == destinations[i].star){
							$(this).attr('checked', true);
						}

					});

				}



				break;
			}
		}
	}

	function isSelectDestinaion(name){
		if (name == '' || name == "<?=lang('hotel_search_title')?>")
		{
			return false;

		}

		return true;
	}

	var destinations = <?=$search_data?>;
	<?php if(isset($regionData)):?>
	var regionData = <?=$regionData?>;
	<?php endif;?>

	function setHotelAutocomplete(){

		var destination_data = new Array();

		for (var i = 0; i < destinations.length; i++){
			destination_data[i] = destinations[i].name;

		}

		$("#destination").bind( "keydown", function( event ) {
         		if ( event.keyCode === $.ui.keyCode.TAB &&
         			$( this ).data( "autocomplete" ).menu.active ) {
         			event.preventDefault();
         		}
          }).autocomplete({
       		minLength: 1,
       		autoFocus: true,
    		source: function(req, responseFn) {
		        var re = $.ui.autocomplete.escapeRegex(req.term);
		        var matcher = new RegExp( "^" + re, "i" );
		        var a = $.grep( destinations, function(item,index){
		            return matcher.test(item.name);
		        });
		        responseFn( a );
		    },
     		focus: function() {
     			// prevent value inserted on focus
     			return false;
     		},
     		select: function( event, ui ) {
				$("#destination" ).val( ui.item.name);

				return false;
            }
          })
  		.data("autocomplete")._renderItem = (function (ul, item) {
      		t = "<span style='*float:left;*width:60%'>" + item.name + "</span>";
      		t = t + "<span style='float:right;*float:left; *width:32%; *display:inline;*text-align: right;'>" + getRegion(item.region, item.parent) + "</span>";
  			return $( "<li></li>" )
          	.data( "item.autocomplete", item )
          	.append( "<a>" + t + "</a>" )
          	.appendTo( ul );

  		});

		// remove round corner
		$( "#destination" ).autocomplete('widget').removeClass('ui-corner-all');

	}

	function getSelectedHotelIds(){
		if ($('#destination').val() == '' || $('#destination').val() == "<?=lang('hotel_search_title')?>")
		{
			return null;
		}

		var selected_dess = null;
		for(var i = 0; i < destinations.length; i++){
			if (destinations[i].name == $('#destination').val()){
				selected_dess = $("#destination_id").val();
				break;
			}
		}

		return selected_dess;
	}

	function search_hotel(){
		var check = false;
		if (getSelectedHotelIds() != null){
			$('#destination_id').val('');

			for(var i = 0; i < destinations.length; i++){

				if (destinations[i].name == $('#destination').val() && destinations[i].object_type == -1){

					$('#destination_id').val(destinations[i].id);

					break;
				}
			}

			check = true;
		} else {
			alert("<?=lang('select_destination')?>");
			return false;
		}

		if(check) {
			var alert_message='<?=lang("search_alert_message")?>';
			check_travel_date($("#arrival_date").val(), alert_message);

			$('#submit_action').val('yes');

			document.frmHotelSearchForm.action = getSearchUrl(true);

			document.frmHotelSearchForm.submit();
		}
	}

$(document).ready(function(){

	var this_date = '<?=getDefaultDate()?>';

	var current_date = getCookie('arrival_date');

	if (current_date == null || current_date ==''){
		current_date = '<?=date('d-m-Y', strtotime($search_criteria['arrival_date']))?>';
	}

	initHotelSearchBox();

	setHotelAutocomplete();

	$("#hotel_night option[value='<?=$search_criteria["hotel_night"]?>']").attr('selected', 'selected');

	initDate(this_date, current_date, '#arrival_day','#arrival_month','#arrival_date', '#hotel_night', '#departure_date_display');

	<?php $resource_path = $this->config->item('resource_path');?>

	$('#search_help').tipsy({fallback: search_help, gravity: 's', width: 'auto', title: "<?=lang('help') ?>"});
});
</script>

