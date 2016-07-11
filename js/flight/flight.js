
/**
 * Change the trip type
 *
 * @author Huutd
 * @since 15.07.2015
 */
function show_return_date(type){

	$('input:radio[name=Type]').each(function(){
		if(type == $(this).val()){
			$(this).prop('checked', true);
		} else {
			$(this).prop('checked', false);
		}
	});

	if(type == 'oneway'){
		$('.return-container').hide();
	}else{
		$('.return-container').show();
	}
}


/**
 * Change the departure-date & returnin-date on the search form
 *
 * @huutd
 * @since 15.07.2015
 */
function change_flight_depart_return_date(departure, returning){

	var departure_date_flight = '#'+departure+ '_date_flight';
	var departure_day_flight = '#'+departure+ '_day_flight';
	var departure_month_flight = '#'+departure+ '_month_flight';

	var returning_date_flight = '#'+returning+ '_date_flight';
	var returning_day_flight = '#'+returning+ '_day_flight';
	var returning_month_flight = '#'+returning+ '_month_flight';


	$(departure_date_flight).change(function() {
		var date_today = new Date();
		var today = date_to_str(date_today)
		var day_depart = $(departure_date_flight).val();
		var day_return = $(returning_date_flight).val();

			if(str_to_date(today) > str_to_date(day_depart)){
				set_current_selected_date(departure_day_flight, departure_month_flight, departure_date_flight, '', today);
			}

			if(str_to_date(day_depart) > str_to_date(day_return)){
				set_current_selected_date(returning_day_flight, returning_month_flight, returning_date_flight, '', day_depart);
			}
		});

	 $(returning_date_flight).change(function() {
		var day_depart = $(departure_date_flight).val();
		var day_return = $(returning_date_flight).val();
			if(str_to_date(day_return) < str_to_date(day_depart)){
				set_current_selected_date(returning_day_flight, returning_month_flight, returning_date_flight, '', day_depart);
			}
		});
}

/**
 * Validate flight search form
 * 
 * @author huutd
 * @since  Jun 20, 2015
 */

function validate_flight_search() {

	var from = $('#flight_from');
	var to = $('#flight_to');

	if($.trim(from.val()) == '') {
		alert("Please select 'Flying From' field");
		$(from).focus();
		$(from).addClass('bpv-input-warning');
		return false;
	}

	if($.trim(to.val()) == '') {
		alert("Please select 'Flying To' field");
		$(to).focus();
		$(to).addClass('bpv-input-warning');
		return false;
	}
	return true;
}

/**
 * Change search label
 *
 * @author huutd
 * @since  Jul 09, 2015
 */

function chang_search_type(type_search){
	if(type_search == 'search_tour_form'){
		$('#text_tour_search_help').show();
		$('#icon_tour_special').show();
		$('#icon_hotel_white').show();
		$('#icon_flight_white').show();

		$('#text_hotel_search_help').hide();
		$('#text_flight_search_help').hide();
		$('#icon_tour_white').hide();
		$('#icon_hotel_special').hide();
		$('#icon_flight_special').hide();
	}else if(type_search == 'search_hotel_form'){
		$('#text_hotel_search_help').show();
		$('#icon_tour_white').show();
		$('#icon_hotel_special').show();
		$('#icon_flight_white').show();

		$('#text_tour_search_help').hide();
		$('#text_flight_search_help').hide();
		$('#icon_tour_special').hide();
		$('#icon_hotel_white').hide();
		$('#icon_flight_special').hide();

	}else if(type_search == 'search_flight_form'){
		$('#text_flight_search_help').show();
		$('#icon_tour_white').show();
		$('#icon_hotel_white').show();
		$('#icon_flight_special').show();

		$('#text_hotel_search_help').hide();
		$('#text_tour_search_help').hide();
		$('#icon_tour_special').hide();
		$('#icon_hotel_special').hide();
		$('#icon_flight_white').hide();
	}
}


function init_autocomplete() {
	$.widget("custom.combobox", {
		_create : function() {
			this.wrapper = $("<span>").addClass("custom-combobox").insertAfter(this.element);

			this.element.hide();
			this._createAutocomplete();
			this._createShowAllButton();
		},

		_createAutocomplete : function() {
			var selected = this.element.children(":selected"), value = selected.val() ? selected.text() : "";

			this.input = $("<input>").appendTo(this.wrapper).val(value).attr("title", "").addClass(
					"custom-combobox-input ui-widget bpt-ui-widget-content ui-widget-content").autocomplete({
				delay : 0,
				minLength : 0,
				source : $.proxy(this, "_source"),
			}).tooltip({
				tooltipClass : "ui-state-highlight"
			});

			this._on(this.input, {
				autocompleteselect : function(event, ui) {
					ui.item.option.selected = true;
					this._trigger("select", event, {
						item : ui.item.option
					});

					// re-select flight to destination
					match_Select_City(this.element);
				},

				autocompletechange : "_removeIfInvalid"
			});

			var select = this.element;

			// render appropriate flight to destinations
			this.input.data( "ui-autocomplete" )._renderItemData = function( ul, item ) {
				respawn_city_list(this, select, ul, item);
			};

			this.input.attr("placeholder", this.element.attr('title'));
		},

		_createShowAllButton : function() {
			var input = this.input, wasOpen = false;

			$("<a>").attr("tabIndex", -1)
			// .attr( "title", "Show All Items" )
			.tooltip().appendTo(this.wrapper).button({
				icons : {
					primary : "ui-icon-triangle-1-s"
				},
				text : false
			}).removeClass("ui-corner-all").addClass("custom-combobox-toggle ui-corner-right").mousedown(function() {
				wasOpen = input.autocomplete("widget").is(":visible");
			}).click(function() {
				input.focus();

				// Close if already visible
				if (wasOpen) {
					return;
				}

				// Pass empty string as value to search for, displaying all
				// results
				input.autocomplete("search", "");
			});
		},

		_source : function(request, response) {
			// / alert(111);
			var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
			response(this.element.children("option").map(function() {
				var text = $(this).text();
				if (request.term != '' && this.value == -1) {
					// when search term not empty then ignore all regions have
					// value -1 (vietnam, europe, ...etc)
					return null;
				}
				if (this.value && (!request.term || matcher.test(text)))
					return {
						label : text,
						value : text,
						option : this
					};
			}));

		},

		_removeIfInvalid : function(event, ui) {

			// Selected an item, nothing to do
			if (ui.item) {
				return;
			}

			// Search for a match (case-insensitive)
			var value = this.input.val(), valueLowerCase = value.toLowerCase(), valid = false;
			this.element.children("option").each(function() {
				if ($(this).text().toLowerCase() === valueLowerCase) {
					this.selected = valid = true;
					return false;
				}
			});

			// Found a match, nothing to do
			if (valid) {
				return;
			}

			// Remove invalid value
			this.input.val("").attr("title", value + " didn't match any item").tooltip("open");
			this.element.val("");
			this._delay(function() {
				this.input.tooltip("close").attr("title", "");
			}, 2500);
			this.input.autocomplete("instance").term = "";
		},

		_destroy : function() {
			this.wrapper.remove();
			this.element.show();
		}
	});
}


function match_Select_City(select) {
	
	var to = get_format_des_code($('#flight_to').val());
	
	if($(select).attr("id") == "flight_from") {
		
		var cityList = '';
		var from = get_format_des_code($('#flight_from').val());

		//console.log('--> from: ' +from);

		$.each(mapping_city, function(index) {
			if(typeof mapping_city[index][from] != "undefined") {
				cityList = mapping_city[index][from];
			}
	    });
		
		if(typeof cityList != "undefined") {
			
			var n = cityList.indexOf(to);
			
			if(n == -1 || to == '') $("#to_des :input").val('');
		}
	}
}

/**
 * Get formated destination code
 *
 * toanlk - 14/07/2015
 */
function get_format_des_code(value) {

	if(value.length) {
		value = value.replace(')', '').replace(' ', '');
		
		str_start = value.indexOf('(');
		
		if(str_start != -1) {
			str_start = str_start + 1;
			
			value = value.substr(str_start, str_start + 2);
		}
	}
	
	return value;
}

function respawn_city_list(that, select, ul, item) {

	var from = get_format_des_code($('#flight_from').val());

	if ($(select).attr("id") == "flight_to" && from != '') {
		var cityList = '';

		$.each(mapping_city, function(index) {
			if (typeof mapping_city[index][from] != "undefined") {
				cityList = mapping_city[index][from];
			}
		});

		if (cityList == '')
			return null;

		var code = get_format_des_code(item.value);

		$.each(cityList, function(index) {
			if (cityList[index] == code) {
				return that._renderItem( ul, item ).data( "ui-autocomplete-item", item );
			}
		});
	} else {
		if (is_area(item.value)) {
			item.value = null;
			var item_area = $( "<li>" ).append( item.label ).appendTo( ul ).data( "ui-autocomplete-item", item );
			return item_area.on('click mouseover mousedown menufocus menuselect focus keydown', function(e) {
				return false;
			}).addClass('lbl-area');
		} else {
			return that._renderItem( ul, item ).data( "ui-autocomplete-item", item );
		}
	}
}

function is_area(code) {

	var status = false;

	$('#flight_from option').each(function() {
		if ($(this).val() == '-1' && code == $(this).text()) {
			status = true;
		}
	});

	return status;
}

function show_hide_contact(obj){
	var show = $(obj).attr('show');
	var txt = $(obj).text();
	if(show == 'hide'){
		
		$(obj).attr('show','show');
		
		$('.bpv-contact-container').show();
		
		txt = txt.replace('[+]','[-]');
		
	} else {
		$(obj).attr('show','hide');
		$('.bpv-contact-container').hide();
		
		txt = txt.replace('[-]','[+]');
	
	}
	$(obj).text(txt);
}

function show_updating(){
	// go top page
	$("html, body").animate({ scrollTop: 0}, "fast");
	show_loading_data();
	
	setTimeout(function(){		
		show_loading_data(false);
	}, 500);
}

function change_baggage(unit){
	
	var total_kg = 0;
	
	var total_fee = 0;
	
	$('.baggage-fees').each(function(){
		
		var kg = $(this).val();
		
		if(kg == '') kg = 0;
		kg = parseInt(kg);
		
		var fee = $(this).find('option:selected').attr('fee');
		
		fee = parseInt(fee);
		
		total_kg = total_kg + kg;
		
		total_fee = total_fee + fee;
		
	});
	
	if(total_fee > 0){
		$('#flight_baggage_fee').show();
		
		$('#total_kg').text(total_kg);
		
		$('#flight_baggage_fee .row-content').html('$'+total_fee);
	} else {
		$('#flight_baggage_fee').hide();
	}
	
	var total_ticket_price = parseInt($('#flight_total_price').attr('ticket-price'));
	var total_bag = total_ticket_price + total_fee;
	$('#flight_total_price').html('$'+total_bag);
}


/**
 * Search Flight Data
 * type: depart or return
 * sid: sid of the current search session
 * day_index: for the change of the flight date 
 * departure_flight: for updating flight-id of the selected departure flight when the user change the date of return flights
 */

function get_flight_data(type, sid, day_index, departure_flight){
	
	var error_html = '<div class="alert alert-warning alert-dismissable">' + 
    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>'+
    '<span class="glyphicon glyphicon-warning-sign"></span>&nbsp;' +
    '<strong>Error connecting to airline. Please search again!</strong>' +
  '</div>';
	
	if(day_index == undefined){
		day_index = 0;
	}
	
	if (departure_flight == undefined){
		departure_flight = '';
	}
	
	$("#flight_loading_depart").hide();
	$("#flight_loading_return").hide();
	$('#flight_loading_change_day').hide();
	
	if(day_index == 0){
		$('#flight_data_content').html('');
		
		if(type == 'depart'){
			$("#flight_loading_depart").show();	
		} else {
			$("#flight_loading_return").show();
		}
		
	} else {
		$('#flight_search_result_area').html('');
		$('#flight_loading_change_day').show();
	}
	

	disable_filters();
	
	// if the user change the flight date, hide the selected depature flight detail while loading return flights
	if(type == 'return' && day_index != 0){
		
		var flight_departure_id = $('#flight_departure_id').val();
		
		var detail_loaded = $('#flight_detail_' + flight_departure_id).attr('loaded');
		
		if (detail_loaded == '0'){
			
			$('#show_' + flight_departure_id).hide();
		}
	}
	
	// hide the 'change departure flighs' link while loading return flights
	if (type == 'return'){
		$('#change_departure_flights').hide();
	}
	
	$.ajax({
		url: "/get-flight-data/",
		type: "POST",
		cache: false,
		data: {
			"flight_type":type,
			"sid":sid,
			"day_index":day_index,
			"departure_flight": departure_flight
		},
		success:function(value){
			
			$("#flight_loading_depart").hide();
			$("#flight_loading_return").hide();
			$('#flight_loading_change_day').hide();
			
			$("#flight_data_content").html(value);

			enable_filters();
			
			// show the 'change departure flighs' link after loading return flights
			if (type == 'return'){
				$('#change_departure_flights').show();
			}
		},
		error:function(var1, var2, var3){
			$("#flight_data_content").html(error_html);
			
			// show the 'change departure flighs' link after loading return flights
			if (type == 'return'){
				$('#change_departure_flights').show();
			}
		}
	});	
}

function disable_filters(){
	
	$('.filter-airlines').attr('disabled','disabled');
	
	$('.filter-times').attr('disabled','disabled');
	
}

function enable_filters(){
	
	var time_arr = new Array();
	
	$('#rows_content .bpv-list-item').each(function(){
		var time = $(this).attr('time');
		time_arr.push(time);
	});
	
	if (time_arr.length > 0){
		
		$('.filter-times').removeAttr('disabled');
		
		$('.filter-times').attr('checked', false);
		
		$('.filter-times').each(function(){
			var time = $(this).val();
			
			if (time_arr.indexOf(time) == -1){
				$(this).parent().parent().hide();
			}
		});

	}
}

function create_airline_filters(airlines, selected_airline){
	$('#filter_airlines').html('');
	
	var html = '';
	
	for(var i = 0; i < airlines.length; i++){
		
		html =  html + '<div class="checkbox margin-bottom-20">';
		html =  html + '<label>';
			html =  html + '<input onclick="filter_flights()" class="filter-airlines" type="checkbox"';
			
			if(selected_airline != '' && selected_airline == airlines[i].code){
				html =  html + ' checked="checked" ';
			}
			
			html =  html + ' value="' + airlines[i].code + '">'
			html =  html + '<img src="http://flightbooking.bestpricevn.com/Images/Airlines/' + airlines[i].code + '.gif">&nbsp;'
			html =  html + airlines[i].name;
		html =  html + '</label>';
		html =  html + '</div>';
	}
	
	$('#filter_airlines').html(html);
	
	if(selected_airline != ''){
		filter_flights();
	}
}

function filter_flights(){
	
	// hide sort & filter on mobile view
	$('.bpv-s-content').hide();
	
	show_updating();
	
	var airline_arr = new Array();
	
	var time_arr = new Array();
	
	$('.filter-airlines').each(function(){
		if($(this).is(':checked')){
			var airline = $(this).val();
			airline_arr.push(airline)
		}
		
	});
	
	$('.filter-times').each(function(){
		if($(this).is(':checked')){
			var time = $(this).val();
			time_arr.push(time);
		}
		
	});
	
	show_hide_flight_rows(airline_arr,time_arr);
}

function show_hide_flight_rows(airline_arr,time_arr){
	
	$('#rows_content .bpv-list-item').each(function(){
		var airline = $(this).attr('airline');
		var time = $(this).attr('time');
		
		if(is_shown(airline,airline_arr) && is_shown(time, time_arr)){
			$(this).show('slow');
		} else {
			$(this).hide('slow');
		}
		
		
	});
}

function is_shown(airline, airline_arr){
	if(airline_arr.length == 0) return true;
	
	if(airline_arr.indexOf(airline) != -1) return true;
	
	var airline_codes = airline.split(',');
	
	for(var i = 0; i < airline_codes.length; i++){
		if(airline_arr.indexOf(airline_codes[i]) != -1) return true;
	}
	
	return false;
}

function sort_flight_by(sort_by){
	
	// hide sort & filter on mobile view
	$('.bpv-s-content').hide();
	
	show_updating();
	
	var rows = new Array();
	
	$('#rows_content .bpv-list-item').each(function(){
		var row_obj = $(this);
		
		rows.push(row_obj);
	});
	
	
	$.each(['price','airline','departure'],function(index, value){
		
		$('#sort_by_'+value).removeClass('active');
		
		$('#sort_by_'+value + ' p').hide();
		
		$('#sort_by_'+value + ' span').hide();
	
		if(value == sort_by){	
			
			$('#sort_by_'+value).addClass('active');
			
			$('#sort_by_'+value + ' p').show();
			
			$('#sort_by_'+value + ' span').show();
		} else {
			
		}
	});
	
	for(var i = rows.length - 1; i >= 0; i--){
		
		for(var j = 1; j <= i; j++){
			
			var v1 = 0; 
			var v2 = 0;
			
			if(sort_by == 'price'){
				v1 = $(rows[j-1]).attr('price');
				v2 = $(rows[j]).attr('price');
				
				v1 = parseInt(v1);
				v2 = parseInt(v2);
				
			} else if(sort_by == 'airline'){
				v1 = $(rows[j-1]).attr('code');
				v2 = $(rows[j]).attr('code');
			} else if(sort_by == 'departure'){
				v1 = $(rows[j-1]).attr('timefrom');
				v2 = $(rows[j]).attr('timefrom');
			}
			
			if (v1 > v2){
				var tmp = rows[j-1];
				rows[j-1] = rows[j];
				rows[j] = tmp;
			}else if(v1 == v2){
				v1 = $(rows[j-1]).attr('code');
				v2 = $(rows[j]).attr('code');
				
				if (v1 > v2){
					var tmp = rows[j-1];
					rows[j-1] = rows[j];
					rows[j] = tmp;
				}
			}
			
		}
	}
	
	var sort_html = '';
	
	for(var i = 0; i < rows.length; i++){
		
		var row_obj = $(rows[i]).clone();
		
		$(row_obj).wrap('<div>');
		
		sort_html = sort_html + $(row_obj).parent().html();
		
	}
	
	$('#rows_content').html(sort_html);
	
}

function show_flight_detail(sid, flight_id, flight_class, flight_stop, flight_type){
	
	var show_status =  $('#flight_detail_' + flight_id).attr('show');
	
	var txt = $('#show_'+flight_id).text();
	
	if(show_status == 'hide'){
		$('#flight_detail_' + flight_id).attr('show','show');
		
		txt = txt.replace('[ + ]','[ - ]');
		
		$('#show_'+flight_id).text(txt);
		
		$('#flight_detail_' + flight_id).show();
		
		var loaded = $('#flight_detail_' + flight_id).attr('loaded');
		
		if(loaded == '0'){
			
			if(flight_class != undefined && flight_stop != undefined && flight_type != undefined){
				
				// get domistic flight detail 
				get_flight_detail(sid, flight_id,flight_class, flight_stop, flight_type);
				
			} else {
				
				// get international flight detail
				get_flight_detail(sid, flight_id);
				
			}

		}
		
		$('#flight_row_' + flight_id).addClass('bpv-item-selected');
	} else {
		$('#flight_detail_' + flight_id).attr('show','hide');
		
		txt = txt.replace('[ - ]','[ + ]');
		
		$('#show_'+flight_id).text(txt);
		
		$('#flight_detail_' + flight_id).hide();
		$('#flight_row_' + flight_id).removeClass('bpv-item-selected');
	}
	
}

function get_flight_detail(sid, flight_id, flight_class, flight_stop, flight_type){
	
	var waiting_html = '<div class="bpv-search-waiting">' + 
						'<div class="ms1 text-highlight">Loading flight data ...</div>'+
							'<div class="ms2 text-highlight">'+
							'<img style="margin-right:15px;" alt="" src="/media/icon/loading.gif">'+
							'<span>Please wait ... </span>'+
						'</div>	'+
						'</div>	';

	var error_html = '<div class="alert alert-warning alert-dismissable">' + 
	      '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>'+
	      '<span class="glyphicon glyphicon-warning-sign"></span>&nbsp;' +
	      '<strong> Error connecting to Airlines. Please search again!</strong>' +
	    '</div>';
	
	$('#flight_detail_' + flight_id).html(waiting_html);
	
	if(flight_class != undefined && flight_stop != undefined && flight_type != undefined){
		$.ajax({
			url: "/get-flight-detail/",
			type: "POST",
			cache: false,
			data: {
				"sid":sid,
				"flight_id":flight_id,
				"flight_class":flight_class,
				"flight_stop":flight_stop,
				"flight_type":flight_type
			},
			success:function(value){
				if (value != ''){
					$('#flight_detail_' + flight_id).html(value);
					$('#flight_detail_' + flight_id).attr('loaded','1');
				} else {
					$('#flight_detail_' + flight_id).html(error_html);
				}
			},
			error:function(var1, var2, var3){
				$('#flight_detail_' + flight_id).html(error_html);			
			}
		});	
		
	} else {
		$.ajax({
			url: "/get-flight-detail-inter/", // international flight detail
			type: "POST",
			cache: false,
			data: {
				"sid":sid,
				"flight_id":flight_id
			},
			success:function(value){
				if (value != ''){
					$('#flight_detail_' + flight_id).html(value);
					$('#flight_detail_' + flight_id).attr('loaded','1');
				} else {
					$('#flight_detail_' + flight_id).html(error_html);
				}
			},
			error:function(var1, var2, var3){
				$('#flight_detail_' + flight_id).html(error_html);			
			}
		});	
		
	}
	
}

function get_selected_flight_info(flight_id){
	var ret = flight_id;
	
	var airline = $('#flight_row_' + flight_id).attr('airline');	
	var code = $('#flight_row_' + flight_id).attr('code');
	var timefrom = $('#flight_row_' + flight_id).attr('timefrom');
	var timeto = $('#flight_row_' + flight_id).attr('timeto');
	var flight_class = $('#flight_row_' + flight_id).attr('flightclass');
	var flight_stop = $('#flight_row_' + flight_id).attr('flightstop');
	var flight_r_class = $('#flight_row_' + flight_id).attr('flightrclass');
	
	ret = ret + ';' + airline + ';'+ code + ';' + flight_stop + ';' + timefrom + ';' + timeto + ';' + flight_class + ';' + flight_r_class;
	
	//alert(ret);
	
	return ret;
}

function show_fare_rules(id){
	txt_id = 'txt_'+id;
	id = 'fare_rules_' + id;
	
	var status = $('#' + id).attr('show');
	
	if(status == 'hide'){
		
		$('#'+id).show();
		$('#'+id).attr('show','show');
		$('#'+txt_id).html('[ - ] Show Fare Rules');
	} else {
		$('#'+id).hide();
		$('#'+id).attr('show','hide');
		$('#' + txt_id).html('[ + ] Show Fare Rules');
	}
}

function validate_passengers(parent_id){
	//alert(parent_id);
	var is_valid = true;
	
	var req_class = '.required';
	
	var non_req_class = '.non-required';
	
	var pas_name_class = '.pas-name';
	
	$(req_class).removeClass('bpv-input-warning');
	
	$(non_req_class).removeClass('bpv-input-warning');
	
	if(parent_id != undefined){
		req_class = '#' + parent_id + ' ' + req_class;		
		non_req_class = '#' + parent_id + ' ' +  req_class;
	}
	
	$(req_class).each(function(){
		
		var txt_val = $(this).val();
	//	alert(txt_val);
		if($.trim(txt_val) == '' || /^[a-zA-Z0-9- ]*$/.test(txt_val) == false){
			
			is_valid = false;
			
			$(this).addClass('bpv-input-warning');
		}
	});
	
	$(non_req_class).each(function(){
		
		var txt_val = $(this).val();
		
		if(/^[a-zA-Z0-9- ]*$/.test(txt_val) == false){
			
			is_valid = false;
			
			$(this).addClass('bpv-input-warning');
		}
	});
	
	$(pas_name_class).each(function(){
		
		var txt_val = $(this).val();
		
		if(txt_val.indexOf(' ') < 0){
			
			is_valid = false;
			
			$(this).addClass('bpv-input-warning');
		}
	});
	
	$(req_class).change(function(){
		$(this).removeClass('bpv-input-warning');
	});
	
	$(non_req_class).change(function(){
		$(this).removeClass('bpv-input-warning');
	});
	
	if(!is_valid){
		$('#passenger_note').addClass('bpv-color-warning');
	}
	
	return is_valid;
}

function validate_chd_inf_birthday(chd, inf, departure_date){
	
	$('.age-warning').hide();
	
	var is_valid = true;
	
	var departs = departure_date.split('-');
	
	var fly_date = parseInt(departs['0']);
	
	var fly_month = parseInt(departs['1']);
	
	var fly_year = parseInt(departs['2']);
	
	var date_infant = new Date((fly_year - 2), fly_month, fly_date, 0, 0, 0, 0);
	
	var date_children = new Date((fly_year - 12), fly_month, fly_date, 0, 0, 0, 0);
	
	var date_fly = new Date(fly_year, fly_month, fly_date, 0, 0, 0, 0);
	
	if(chd > 0){
		
		for(var i = 1; i <= chd; i++){
			
			var chd_day = $('select[name=children_day_' + i + ']').val();
			
			var chd_month = $('select[name=children_month_' + i + ']').val();
			
			var chd_year = $('select[name=children_year_' + i + ']').val();
			
			chd_day = parseInt(chd_day);
			
			chd_month = parseInt(chd_month);
			
			chd_year = parseInt(chd_year);
			
			var chd_date = new Date(chd_year, chd_month, chd_day, 0, 0 , 0, 0);
			
			if(chd_date < date_children || chd_date > date_infant){
				
				$('#chd_age_warning_'+i).show();
				
				$('select[name=children_day_' + i + ']').addClass('bpv-input-warning');
				
				$('select[name=children_month_' + i + ']').addClass('bpv-input-warning');
				
				$('select[name=children_year_' + i + ']').addClass('bpv-input-warning');
				
				is_valid = false;
			}
			
		}
		
	}
	
	if(inf > 0){
		
		for(var i = 1; i <= inf; i++){
			
			var inf_day = $('select[name=infants_day_' + i + ']').val();
			
			var inf_month = $('select[name=infants_month_' + i + ']').val();
			
			var inf_year = $('select[name=infants_year_' + i + ']').val();
			
			inf_day = parseInt(inf_day);
			
			inf_month = parseInt(inf_month);
			
			inf_year = parseInt(inf_year);
			
			var inf_date = new Date(inf_year, inf_month, inf_day, 0, 0 , 0, 0);
			
			if(inf_date <= date_infant || inf_date >= date_fly){
				
				$('#inf_age_warning_'+i).show();
				
				$('select[name	=infants_day_' + i + ']').addClass('bpv-input-warning');
				
				$('select[name=infants_month_' + i + ']').addClass('bpv-input-warning');
				
				$('select[name=infants_year_' + i + ']').addClass('bpv-input-warning');
				
				is_valid = false;
			}
			
		}
		
	}
	
	return is_valid;
}

function select_destination_flight(ele, id, airline_id, airline_code, fromCode, toCode) {
	//$('#flightModal').modal('show');
	alert(1);
	$('.search-dialog').show();
	$('#flightPopover').popover('show'); 
	var img_src = $('#sl_airline_img_'+id+'_'+airline_id).attr('src');
	$('#dg_airline_img').attr('src', img_src);
	$('#dg_airline_name').html($('#sl_airline_name_'+airline_id).html());
	$('#dg_airline_code').val(airline_code);
	
	$('#dg_txt_from').html($('#sl_from_des_'+id).html());
	$('#dg_txt_to').html($('#sl_to_des_'+id).html());
	
	var from = $(ele).attr('data-from');
	var to = $(ele).attr('data-to');
	
	from = from + ' (' + fromCode + ')';
	to = to + ' (' + toCode + ')';
	$('#dg_from').val(from);
	$('#dg_to').val(to);
}

function set_up_flight_dialog_calendar(){
	
	
	set_up_calendar('#flight_dialog_departure_date', function(dateText, inst){
		
		$('#flight_dialog_departure_date').removeClass('bpv-input-warning');
		
		var depart_date = $(this).datepicker("getDate"); 
		
		var return_date = $('#flight_dialog_returning_date').datepicker("getDate"); // null if not selected
		
		if(return_date != null && return_date <= depart_date){
			
			$("#flight_dialog_returning_date").datepicker("setDate", dateText);
			
			setTimeout(function(){
				$("#flight_dialog_returning_date").datepicker("show");
	        }, 100); 
			
		}
		
	});
	
	set_up_calendar('#flight_dialog_returning_date', function(dateText, inst){
		
		$('#flight_dialog_returning_date').removeClass('bpv-input-warning');
		
		
		var depart_date = $('#flight_dialog_departure_date').datepicker("getDate"); // null if not selected
		
		var return_date = $(this).datepicker("getDate");
		
		if(depart_date != null && return_date <= depart_date){
			
			$("#flight_dialog_departure_date").datepicker("setDate", dateText);
			
			setTimeout(function(){
				$("#flight_dialog_departure_date").datepicker("show");
	        }, 100);     

		}
		
	});
	
}

function init_flight_search_dialog() {
	
	// Handle event click icon calendar
	$('#btn_flight_dialog_departure_date').click(function () {
		$('#flight_dialog_departure_date').focus();
	});
	
	// Handle event click icon calendar
	$('#btn_flight_dialog_returning_date').click(function () {
		$('#flight_dialog_returning_date').focus();
	});
}

function update_flight_total_payment(unit){

	var total_ticket_price = $('#flight_total_price').attr('total-price');
	
	if(total_ticket_price == undefined || total_ticket_price == ''){
		total_ticket_price = 0;
	} else {
		total_ticket_price = parseInt(total_ticket_price);
	}
	
	// calculate the BPV promotion code discount
	var pro_code_discount = $('#applied_code_discount').attr('rate');
	
	if(pro_code_discount == undefined || pro_code_discount == ''){
		pro_code_discount = 0;
	} else {
		pro_code_discount = parseInt(pro_code_discount);
	}
	
	var total_payment = total_ticket_price - pro_code_discount;
	
	$('#flight_total_price').html(bpv_format_currency(total_payment, unit));
	
	return total_payment;
}

function update_flight_baggage_pas_first_name(){
	$('.pas-name').each(function(){
		
		var index = $(this).attr('index');
		
		var name = $(this).val();
		
		var last_name = $('#last-'+index).val();
		
		if($.trim(name) != ''){
			$('.bag-pas-'+index).text(name+ ' '+last_name);
		} else {
			var txtval = $('.bag-pas-'+index).attr('txtval');
			$('.bag-pas-'+index).text(txtval);
		}
		
	});
}

function update_flight_baggage_pas_last_name(){

	$('.pas-name-last').each(function(){
		
		var index = $(this).attr('index');
		
		var name = $(this).val();
		
		var first_name = $('#first-'+index).val();
		
		if($.trim(name) != ''){
			$('.bag-pas-'+index).text(first_name+ ' '+name);
		} else {
			var txtval = $('.bag-pas-'+index).attr('txtval');
			$('.bag-pas-'+index).text(txtval);
		}
		
	});
}

/**
 *
 * User click on the Calendar Date to change the flight date
 *
 */
function change_flight_date(flight_type, sid, day_index, wd, str_date){
	// update the Date information on GUI
	
	if(flight_type == 'depart'){
		$('.selected-departure-date').text(wd + ', ' + str_date);
		
		$('#flight_departure_date').val(str_date);
	} else {
		$('.selected-return-date').text(wd + ', ' + str_date);
		
		$('#flight_returning_date').val(str_date);
	}
	
	
	// update calendar status
	$('.cal-selected').removeClass('cal-selected');
	$('.cal-arrow-down').remove();
	
	$('.cal-item').each(function(){
		var index = $(this).attr('dayindex');
		if(index == day_index){
			$(this).addClass('cal-selected');
			$(this).parent().append('<div class="cal-arrow-down center-block"></div>')
		}
		
		$(this).removeClass('cal-active');
		
		$(this).prop("onclick", null);
	});
	
	//$('#cal_item_' + day_index).addClass('cal-active');
	
	// get the selected departure flight
	
	var departure_flight = '';
	
	if (flight_type == 'return'){
		
		departure_flight = $('#flight_departure').val();
		
		departure_flight = departure_flight.split(';');
		
		departure_flight = departure_flight[2];
	}
	// get flight data
	get_flight_data(flight_type, sid, day_index, departure_flight);
}

/**
 * 
 * Update the selected departure flight after changing return flight date
 * 
 */
function update_selected_depature_flight(selected_departure, sid){
	
	var selected_departure_data = selected_departure.split(';');
	
	// update the Flight-Id to the Selected Departure Area
	var flight_departure_id = $('#flight_departure_id').val();
	
	$('#show_' + flight_departure_id).show();
	
	$('#flight_detail_' + flight_departure_id).attr('id', 'flight_detail_' + selected_departure_data[0]);
	
	$('#show_' + flight_departure_id).attr('id', 'show_' + selected_departure_data[0]);
	
	var href_val = "javascript:show_flight_detail('" + sid + "'," + selected_departure_data[0] + ",'" + selected_departure_data[6] + "','"
	+ selected_departure_data[3] + "','depart')";
	
	$('#show_' + selected_departure_data[0]).attr('href', href_val);
	
	$('#show_' + selected_departure_data[0]).show();
	
	$('#flight_departure').val(selected_departure);
	
}



/**
 * Get the current flight search in the Search History
 * 
 * @author Huutd
 * @since 15.07.2015
 */
function get_current_flight_search(){
	
	 $.getJSON( "flight/flight_search/get_lasted_flight_search/", function( data ) {

		 	if(data.Type = 'roundway'){
		 		
                $('.roundway input[value="roundway"]').prop('selected', true);
                
            }else{
            	$('.oneway input[value="oneway"]').prop('selected', true);
            }
		 	
	        if(data.From != undefined) $('#flight_from').val(data.From);

	        if(data.To != undefined) $('#flight_to').val(data.To);

	        if(data.Depart != undefined){
	            set_current_selected_date('#departure_day_flight', '#departure_month_flight', '#departure_date_flight', [], data.Depart);
	        }
	        
	        if(data.Return != undefined){
	            set_current_selected_date('#returning_day_flight', '#returning_month_flight', '#returning_date_flight', [], data.Return);
	        }
	        
	        if(data.To != undefined) $('#flight_adults').val(data.ADT);
	        
	        if(data.To != undefined) $('#flight_children').val(data.CHD);
	        
	        if(data.To != undefined) $('#flight_infants').val(data.INF);

	    });
	
}




