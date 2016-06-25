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
	
	$('.bpv-update-wrapper').show();
	
	setTimeout(function(){
		$('.bpv-update-wrapper').hide();
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
		
		$('#flight_baggage_fee .col-2').html(bpv_format_currency(total_fee, unit));
	} else {
		$('#flight_baggage_fee').hide();
	}
	
	var total_ticket_price = parseInt($('#flight_total_price').attr('ticket-price'));
	
	$('#flight_total_price').html(bpv_format_currency(total_ticket_price + total_fee, unit));
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
    '<strong>Lỗi kết nối với hãng bay. Xin vui lòng tìm kiếm lại!</strong>' +
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
		
		$('#sort_by_'+value + ' img').hide();
		
		$('#sort_by_'+value + ' span').hide();
	
		if(value == sort_by){			
			$('#sort_by_'+value).addClass('active');
			$('#sort_by_'+value + ' img').show();
			
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
		'<div class="ms1">Đang tải dữ liệu chuyến bay</div>' + 
		'<div class="ms2">'+
			'<img style="margin-right:15px;" alt="" src="/media/icon/loading.gif">'+
			'<span>Xin đợi trong giây lát...</span>'+
		'</div></div>';
	
	var error_html = '<div class="alert alert-warning alert-dismissable">' + 
	      '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>'+
	      '<span class="glyphicon glyphicon-warning-sign"></span>&nbsp;' +
	      '<strong>Lỗi kết nối với hãng bay. Xin vui lòng tìm kiếm lại!</strong>' +
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
		$('#'+txt_id).html('[ - ] Xem điều kiện vé');
	} else {
		$('#'+id).hide();
		$('#'+id).attr('show','hide');
		$('#' + txt_id).html('[ + ] Xem điều kiện vé');
	}
}

function validate_passengers(parent_id){
	
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
	
	var departs = departure_date.split('/');
	
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
				
				$('select[name=infants_day_' + i + ']').addClass('bpv-input-warning');
				
				$('select[name=infants_month_' + i + ']').addClass('bpv-input-warning');
				
				$('select[name=infants_year_' + i + ']').addClass('bpv-input-warning');
				
				is_valid = false;
			}
			
		}
		
	}
	
	return is_valid;
}

function select_destination_flight(ele, id, airline_id, airline_code, fromCode, toCode) {
	$('#flightModal').modal('show');
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

function update_flight_baggage_pas_name(){
	$('.pas-name').each(function(){
		
		var index = $(this).attr('index');
		
		var name = $(this).val();
		
		if($.trim(name) != ''){
			$('.bag-pas-'+index).text(name);
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
