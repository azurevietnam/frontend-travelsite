function init_cruise_search(get_search, is_mobile) {
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	if(get_search == undefined){
		get_search = false;
	}
	
	if(get_search){
		get_current_search(3);// MODULE = CRUISE
	}

	
	init_cruise_date('#startdate','#duration','#enddate','#show_search_end_date', '', is_mobile);
	

	// Clear search value button
	if ($( ".search-choice-close" ).length == 0 && $( '#destination' ).val() != '' && !is_mobile){
		add_clear_search();
	}
	
	// Add clear button
	$( "#destination" ).blur(function() {
		if( $.trim($( "#destination" ).val()) != '' && !is_mobile) {
			add_clear_search();
		}
	});
	
	// whenever change value then remove object id
	$( "#destination" ).on('input',function(){
		if( $.trim($( "#destination" ).val()) != $( '#destination' ).data("selected_value") ) {
			$('#cruise_destination_input').val('');
			$('#oid').val('');
			
			$( ".search-choice-close" ).remove();
			//console.log('change value: '+ $( "#destination" ).val() + ' || ' + $.trim($( '#destination' ).data("selected_value")));
			
			// hide popup
			$('#destination').popover('hide');
		}
	})

	$('#destination').popover({
		html: true,
		trigger: 'click',
		template: '<div class="popover suggestion-des"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p></p></div></div></div>',
		content: $('#suggestion-des').html(),
		placement: 'right'
	}).on('shown.bs.popover', function(e){
		$('.suggestion-des a').click(function() {
			$( '#destination' ).val( $(this).attr('data-name') );
			$('.typeahead').typeahead('val', $(this).attr('data-name'));
			
			// Save object id
			$('#cruise_destination_input').val($(this).attr('data-url-title'));
			$('#oid').val($(this).attr('data-type') + '-' + $(this).attr('data-id'));
			
			// store selected value
			$( '#destination' ).data("selected_value", $( '#destination' ).val());
			
			// add clear button
			add_clear_search();

			// hide popup
			$('#destination').popover('hide');
			
			// cancel triger typeahead
			$('.typeahead').typeahead('close');
		});
	});
}

function init_cruise_date(startdate_id, duration_id, enddate_id, enddate_display_id, startdate_value, is_mobile){
	
	var today = new Date();
	
	if(startdate_value != ''){
		$(startdate_id).val(startdate_value);
	}
	
	get_end_date(startdate_id, duration_id, enddate_id, enddate_display_id, is_mobile);
	
	$(startdate_id).change(function() {
		get_end_date(startdate_id, duration_id, enddate_id, enddate_display_id, is_mobile);
	});
	
	$(duration_id).change(function() {
		get_end_date(startdate_id, duration_id, enddate_id, enddate_display_id, is_mobile);
	});
	
	var icon_calender_id = '#btn_' + startdate_id.replace('#','');
	
	// Handle event click icon calendar
	$(icon_calender_id).click(function () {
		$(startdate_id).focus();
	});
}

function set_up_cruise_calendar(is_mobile){
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	var today = new Date();
	today = dateFormat(today);
	
	if($('#startdate').length > 0){
		
		set_up_calendar('#startdate', null, is_mobile);
		
	}
	
	if($('#checkin_date').length > 0){
		

		set_up_calendar('#checkin_date', null, is_mobile);
		
	}
	
}

function set_up_cruise_autocomplete(is_mobile){
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	// get destinations
	var destinations = new Bloodhound({
		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {url: '/suggest_cruise_destinations/?query=%QUERY',},
	});
	var cruises = new Bloodhound({
		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {url: '/suggest_cruises/?query=%QUERY',},
	});
	destinations.initialize();
	cruises.initialize();

	// instantiate the typeahead UI
	$( '#destination' ).typeahead({
		minLength: 2,
		highlight : true,
		hint : false 
	}, {
		displayKey: 'name',
		source : destinations.ttAdapter(),
		templates: {
			header: '<span class="lb-header">Tỉnh/Thành Phố/Địa danh</span>'
		}
	}, {
		displayKey: 'name',
		source : cruises.ttAdapter(),
		templates: {
			header: '<span class="lb-header">Du thuyền</span>'
		}
	}).on("typeahead:selected", function($e, datum){
		// Save object id
		$('#cruise_destination_input').val(datum['url_title']);
		$('#oid').val(datum['type'] + '-' + datum['id']);
		
		// store selected value
		$( '#destination' ).data("selected_value", $( '#destination' ).val());
		
		// add clear button
		if(!is_mobile) {
			add_clear_search();
		}
		
		// hide popover
		$('#destination').popover('hide');
	});
	
}


function get_end_date(startdate_id, duration_id, enddate_id, enddate_display_id, is_mobile) {
	var dmy = $(startdate_id).val();
	
	if(check_date(dmy)) {
		var check_out_date = get_JS_Date(dmy);
		var number_of_nights = $(duration_id).val();
		
		if (number_of_nights != '' && number_of_nights > 0) {
			check_out_date.setDate(check_out_date.getDate() + parseInt(number_of_nights, 10));
			
			if(check_date(dateFormat(check_out_date))) {
				$(enddate_display_id).html(dateFormat(check_out_date));
				$(enddate_id).val(dateFormat(check_out_date));
			}
		} else {
			$(enddate_display_id).html('');
			$(enddate_id).val('');
		}
		
		if(is_mobile) {
			if($(enddate_id).val() != '') {
				$('#block_end_date').show();
			} else {
				$('#block_end_date').hide();
			}
		}
	}
}

function validate_cruise_search() {
	
	if($.trim($('#destination').val()) == '') {
		alert('Xin vui lòng nhập Tỉnh/Thành Phố/Điểm Du Lịch/Tên Du Thuyền ');
		$('#destination').focus();
		$('#destination').addClass('bpv-input-warning');
		
		return false;
	}
	
	var start_date = $('#startdate').val();
	
	if($.trim(start_date) == '') {
		$('#startdate').focus();
		$('#startdate').addClass('bpv-input-warning');
		
		alert('Xin vui lòng nhập thông tin "Ngày khởi hành"');
		return false;
	}

	if(!check_date(start_date)) {
		$('#startdate').focus();
		$('#startdate').addClass('bpv-input-warning');
		
		alert('"Ngày nhận phòng" phải theo định dạng ' + FORMAT_DATE);
		return false;
	}
	
	return true;
}

function search_cruises_in_waiting_page(search_url){
	
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
			if(value.indexOf('[cruise-detail-page]') != -1){
				value = value.replace('[cruise-detail-page]',''); 
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

function init_cruise_paging(search_url){
	$(".pagination a").click(function() {
		var link = $(this).attr('href');
		
		page = get_url_var('page',link);
		
		if(page == '' || page == undefined){
			page = 0;
		}
		
		page = parseInt(page);
		
		search_sort_cruises(search_url, page);
		
		return false;
	});
}

function search_sort_cruises(search_url, page){
	
	var valid_form = validate_cruise_search();
	
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

function get_search_sort_params(page){
	
	var destination = $('#destination').val();
	
	destination = encodeURIComponent(destination);
	
	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	var duration = $('#duration').val();
	var oid = $('#oid').val();
	
	var price = $("input[name='filter_price\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var star = $("input[name='filter_star\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var area = $("input[name='filter_area']:checked").map(function(){return $(this).val();}).get();
	var facility = $("input[name='filter_facility\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var sort = $('#sort_by_value').val();

	var params = 'destination=' + destination;
	params = params + '&startdate=' + startdate;
	params = params + '&duration=' + duration;
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
	search_sort_cruises(search_url);
}

function remove_filter(filter_name, filter_value, search_url){
	
	filter_value = filter_value.replace('.', '_');
	$('#' + filter_name + '_' + filter_value).prop('checked', false);
	
	search_sort_cruises(search_url);
}

function validate_tour_check_rate_form() {
	
	var start_date = $('#checkin_date').val();
	
	if($.trim(start_date) == '') {
		$('#checkin_date').focus();
		$('#checkin_date').addClass('bpv-input-warning');
		
		alert('Xin vui lòng nhập thông tin "Ngày đi"');
		return false;
	}

	if(!check_date(start_date)) {
		$('#checkin_date').focus();
		$('#checkin_date').addClass('bpv-input-warning');
		
		alert('"Ngày đi" phải theo định dạng ' + FORMAT_DATE);
		return false;
	}
	
	return true;
}

function update_cruise_total_payment(unit){
	
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
	
	var total_payment = total_room_rate_payment - total_discount - pro_code_discount;
	
	$('#total_payment').html(bpv_format_currency(total_payment, unit));
	
	return total_payment;
}