/**
 *  Functions for hotels search page
 *  
 */

function search_hotels_in_waiting_page(search_url){
	
	var hash = window.location.hash;

	if(hash != '' && hash != undefined){

		hash = hash.substring(1);
	}
	
	//_gaq.push(['_trackPageview', search_url + hash]);

	$.ajax({
		url: search_url + '?isAjax=1&' + hash,
		type: "GET",
		cache: true,
		data: {
		},
		success:function(value){
			if(value.indexOf('[hotel-detail-page]') != -1){
				value = value.replace('[hotel-detail-page]',''); 
				window.location = value;
			} else {
				if(value.indexOf('[search-suggestion]') != -1){
					value = value.replace('[search-suggestion]',''); 
					window.location = value;
				} else {					
					$('.bpv-content').html(value);
				}	
			}
		},
		error:function(var1, var2, var3){
			
		}
	});	
	
}


function search_sort_hotels(search_url, page){
	
	var valid_form = validate_hotel_search();
	
	if(valid_form){
	
		var search_sort_params = get_search_sort_params(page);
		
		window.location = search_url + '#' + search_sort_params;
		
		go_position(0); // go top page
	
		$('.bpv-update-wrapper').show();
		
		//_gaq.push(['_trackPageview', search_url + hash]);
		
		$.ajax({
			url: search_url + '?isAjax=1&' + search_sort_params,
			type: "GET",
			cache: true,
			data: {
			},
			success:function(value){
				if(value.indexOf('[hotel-detail-page]') != -1){
					value = value.replace('[hotel-detail-page]',''); 
					window.location = value;
				} else {
					if(value.indexOf('[search-suggestion]') != -1){
						value = value.replace('[search-suggestion]',''); 
						window.location = value;
					} else {					
						$('.bpv-content').html(value);
					}	
				}
			},
			error:function(var1, var2, var3){
				
			}
		});
	
	}

	return false;	
}


function redirect_to_search_page(search_url, search_params){
	
	window.location = search_url + '#' + search_params;
	
}

function get_search_sort_params(page){
	
	var destination = $('#destination').val();
	
	destination = encodeURIComponent(destination);
	
	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	var night = $('#night').val();
	var oid = $('#oid').val();
	
	var price = $("input[name='filter_price\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var star = $("input[name='filter_star\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var area = $("input[name='filter_area']:checked").map(function(){return $(this).val();}).get();
	var facility = $("input[name='filter_facility\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var sort = $('#sort_by_value').val();

	var params = 'destination=' + destination;
	params = params + '&startdate=' + startdate;
	params = params + '&night=' + night;
	params = params + '&enddate=' + enddate;
	
	if(oid != ''){
		params = params + '&oid=' + oid;
	}
	
	if(price != ''){
		params = params + '&price=' + price;
	}
	
	if(star != ''){
		params = params + '&star=' + star;
	}
	
	if(area != ''){
		params = params + '&area=' + area;
	}
	
	if(facility != ''){
		params = params + '&facility=' + facility;
	}
	
	if(sort != ''){
		params = params + '&sort=' + sort;
	}
	
	if(page != undefined){
		params = params + '&page=' + page;
	}
	
	return params;
}

function sort_by(value, search_url){
	$('#sort_by_value').val(value);
	search_sort_hotels(search_url);
}

function remove_filter(filter_name, filter_value, search_url){
	
	$('#' + filter_name + '_' + filter_value).prop('checked', false);
	
	search_sort_hotels(search_url);
}



function init_hotel_paging(search_url){
	$(".pagination a").click(function() {
		var link = $(this).attr('href');
		
		page = get_url_var('page',link);
		
		if(page == '' || page == undefined){
			page = 0;
		}
		
		page = parseInt(page);
		
		search_sort_hotels(search_url, page);
		
		return false;
	});
}


/**
 * Check Rate & Booking Functions
 */

function book_hotel_now(message){
	
	var is_selected = false;
	
	$('.num_room').each(function(){
		
		var num_room = $(this).val();
		
		if(num_room > 0){
			
			is_selected = true;
		}
	});
	
	if(!is_selected){
		alert(message);
	}
	
	return is_selected;
	
}

function select_rooms(unit){
	
	var total_rate_origin = 0;
	var total_rate_sell = 0;
	
	var stay_night = $('#stay_night').val();
	
	$('.num_room').each(function(){
		var num_room = $(this).val();
		
		var room_rate_id = $(this).attr('room-rate-id');
		
		if(num_room > 0){
			
			var rate_origin = $(this).attr('rate-origin');
			
			var rate_sell = $(this).attr('rate-sell');
			
			total_rate_origin = total_rate_origin + num_room * parseInt(rate_origin);
			
			total_rate_sell = total_rate_sell + num_room * parseInt(rate_sell);
			
			if(room_rate_id != undefined && room_rate_id != ''){ // mobile version
				
				$('#total_room_label_' + room_rate_id).text('Tổng giá ' + num_room + ' phòng x ' + stay_night + ' đêm: ');
				
				var total_room_price_html = '<span class="bpv-price-origin">' + bpv_format_currency(num_room * parseInt(rate_origin), unit) + '</span>';
				
				total_room_price_html = total_room_price_html + ' <span class="bpv-price-total">' + bpv_format_currency(num_room * parseInt(rate_sell), unit) + '</span>'
				
				$('#total_room_price_' + room_rate_id).html(total_room_price_html);
				
				$('#select_room_to_book_'+room_rate_id).hide();
				$('#total_room_info_'+room_rate_id).show();
			}
		} else if(room_rate_id != undefined && room_rate_id != ''){ // mobile version
			$('#select_room_to_book_'+room_rate_id).show();
			$('#total_room_info_'+room_rate_id).hide();
		}
	});
	
	if(total_rate_sell > 0){
		$('#total_rate_label').show();
		if(total_rate_origin != total_rate_sell){
			$('#total_rate_origin').html(bpv_format_currency(total_rate_origin, unit));
			$('#total_rate_origin').show();
		}
		$('#total_rate_sell').html(bpv_format_currency(total_rate_sell, unit));
		$('#total_rate_sell').show();
	} else {
		$('#total_rate_label').hide();
		$('#total_rate_origin').hide();
		$('#total_rate_sell').hide();
	}
	
}

/**
 * Functions in Hotel Booking Page
 * 
 */
function select_extra_bed(unit){
	
	var total_extrabed_rate = 0;
	var nr_extrabed = 0;
	
	$('.extrabed').each(function(){
		
		var nr = parseInt($(this).val());
		
		var extrabed_rate = $(this).attr('extrabed-rate');
		
		extrabed_rate = parseInt(extrabed_rate) * nr;
		
		var room_index = $(this).attr('room-index');
		
		update_room_rate_with_extrabed(extrabed_rate, room_index, unit);
		
		nr_extrabed = nr_extrabed + nr;
		total_extrabed_rate = total_extrabed_rate + extrabed_rate;
	
	});
	
	var total_payment = show_extrabed_on_payment_detail(nr_extrabed, total_extrabed_rate, unit);
	
	return total_payment;
}

function update_room_rate_with_extrabed(extrabed_rate, room_index, unit){
	var origin_rate = $('#rate_origin_'+room_index).attr('rate');
	if(origin_rate != undefined && origin_rate != ''){
		origin_rate = parseInt(origin_rate);
		origin_rate = origin_rate + extrabed_rate;
		origin_rate = bpv_format_currency(origin_rate, unit);
		$('#rate_origin_'+room_index).html(origin_rate)
	}
	
	var sell_rate = $('#rate_sell_'+room_index).attr('rate');
	if(sell_rate != undefined && sell_rate != ''){
		sell_rate = parseInt(sell_rate);
		sell_rate = sell_rate + extrabed_rate;
		sell_rate = bpv_format_currency(sell_rate, unit);
		$('#rate_sell_'+room_index).html(sell_rate)
	}
}

function show_extrabed_on_payment_detail(nr_extrabed, total_extrabed_rate, unit){
	if(nr_extrabed > 0){
		$('#nr_extrabed').text(nr_extrabed);
		
		$('#total_extrabed').html(bpv_format_currency(total_extrabed_rate, unit));
		
		$('#p_extrabed_detail').show();
	} else {
		
		$('#p_extrabed_detail').hide();
	}
	
	var total_room_rate_payment = 0;
	
	$('.room-rate-payment').each(function(){
		total_room_rate_payment = total_room_rate_payment + parseInt($(this).attr('rate'));
	});
	
	$('.surcharge-payment').each(function(){
		total_room_rate_payment = total_room_rate_payment + parseInt($(this).attr('rate'));
	});
	
	// calculate the hotel promotion discount
	var total_discount = $('#total_discount').attr('rate');
	if(total_discount == undefined || total_discount == ''){
		total_discount = 0;
	} else {
		total_discount = parseInt(total_discount);
	}
	
	// calculate the BPV promotion code discount
	var pro_code_discount = $('#applied_code_discount').attr('rate');
	
	if(pro_code_discount == undefined || pro_code_discount == ''){
		pro_code_discount = 0;
	} else {
		pro_code_discount = parseInt(pro_code_discount);
	}
	
	var total_payment = total_room_rate_payment + total_extrabed_rate - total_discount - pro_code_discount;
	
	$('#total_payment').html(bpv_format_currency(total_payment, unit));
	
	return total_payment;
}

function update_travel_guests_for_surcharge(unit){
	var adults = $('#adults').val();
	var children = $('#children').val();
	
	$('.sur_adults').text(adults);
	$('.sur_children').text(children);
	
	var sur_guests = parseInt(adults) + parseInt(children);
	
	$('.sur-info').each(function(){
		
		var charge_type = $(this).attr('c-type');
		charge_type = parseInt(charge_type);
		
		
		if(charge_type == 1) // per adult per booking
		{
			var charge_amount = $(this).attr('charge');
			charge_amount = parseInt(charge_amount);
			
			var total_charge = charge_amount * sur_guests;
			
			$(this).html(bpv_format_currency(total_charge, unit))
			
			$(this).attr('rate', total_charge);
		}
		
	});
	
	$('.surcharge-payment').each(function(){
		
		var charge_type = $(this).attr('c-type');
		charge_type = parseInt(charge_type);
		
		
		if(charge_type == 1) // per adult per booking
		{
			var charge_amount = $(this).attr('charge');
			charge_amount = parseInt(charge_amount);
			
			var total_charge = charge_amount * sur_guests;
			
			$(this).html(bpv_format_currency(total_charge, unit))
			
			$(this).attr('rate', total_charge);
		}
		
	});
	
	select_extra_bed(unit);
}

function update_hotel_total_payment(unit){
	var total_payment = select_extra_bed(unit);
	return total_payment;
}

function validate_hotel_check_rate_form() {
	
	var start_date = $('#checkin_date').val();
	
	if($.trim(start_date) == '') {
		$('#checkin_date').focus();
		$('#checkin_date').addClass('bpv-input-warning');
		
		alert('Xin vui lòng nhập thông tin "Ngày nhận phòng"');
		return false;
	}

	if(!check_date(start_date)) {
		$('#checkin_date').focus();
		$('#checkin_date').addClass('bpv-input-warning');
		
		alert('"Ngày nhận phòng" phải theo định dạng ' + FORMAT_DATE);
		return false;
	}
	
	return true;
}
