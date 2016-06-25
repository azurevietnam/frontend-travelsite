function search_tours_in_waiting_page(search_url){
	
	var hash = window.location.hash;

	if(hash != '' && hash != undefined){

		hash = hash.substring(1);
	}

	$.ajax({
		url: search_url + '?isAjax=1&' + hash,
		type: "GET",
		cache: true,
		data: {
		},
		success:function(value){
			if(value.indexOf('[tour-detail-page]') != -1){
				value = value.replace('[tour-detail-page]',''); 
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

function sort_by(value, search_url){
	$('#sort_by_value').val(value);
	search_sort_tours(search_url);
}

function search_sort_tours(search_url, page){
	
	var valid_form = true;
	
	var is_outbound = $('#is_outbound').val();
	var dep_id = $('#dep_id').val();
	var des_id = $('#des_id').val();
	var duration = $('#duration').val();

	if(!is_outbound && !dep_id && !des_id && !duration)
	{
		valid_form = validate_tour_search();
	}
	
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
				if(value.indexOf('[tour-detail-page]') != -1){
					value = value.replace('[tour-detail-page]',''); 
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
	
	var destination = $('#tour_destination').val();
	
	destination = encodeURIComponent(destination);
	
	var departure = $('#departure').val();
	
	departure = encodeURIComponent(departure);
	
	var startdate = $('#tour_departure_date').val();
	var dep_id = $('#dep_id').val();
	var des_id = $('#des_id').val();
	var duration = $('#duration').val();
	
	var price = $("input[name='filter_price\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var f_departing = $("input[name='filter_departing']:checked").map(function(){return $(this).val();}).get();
	var category = $("input[name='filter_categories\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var f_duration = $("input[name='filter_duration\\[\\]']:checked").map(function(){return $(this).val();}).get();
	var sort = $('#sort_by_value').val();
	
	var is_outbound = $('#is_outbound').val();

	var params = 'departure=' + departure;
	params = params + '&destination=' + destination;
	params = params + '&startdate=' + startdate;
	params = params + '&duration=' + duration;
	
	if(dep_id != ''){
		params = params + '&dep_id=' + dep_id;
	}
	
	if(des_id != ''){
		params = params + '&des_id=' + des_id;
	}
	
	if(price != ''){
		params = params + '&price=' + price;
	}
	
	if(duration != ''){
		params = params + '&duration=' + duration;
	}
	
	if(f_departing != ''){
		params = params + '&f_departing=' + f_departing;
	}
	
	if(f_duration != ''){
		params = params + '&f_duration=' + f_duration;
	}
	
	if(category != ''){
		params = params + '&category=' + category;
	}
	
	if(sort != ''){
		params = params + '&sort=' + sort;
	}
	
	if(page != undefined){
		params = params + '&page=' + page;
	}
	
	if(is_outbound != undefined){
		params = params + '&is_outbound=' + is_outbound;
	}
	
	return params;
}

function remove_filter(filter_name, filter_value, search_url){
	
	filter_value = filter_value.replace('.', '_');
	$('#' + filter_name + '_' + filter_value).prop('checked', false);
	
	search_sort_tours(search_url);
}

function init_tour_paging(search_url){
	$(".pagination a").click(function() {
		var link = $(this).attr('href');
		
		page = get_url_var('page',link);
		
		is_outbound = get_url_var('is_outbound', link);
		
		if(page == '' || page == undefined){
			page = 0;
		}
		
		page = parseInt(page);
		
		search_sort_tours(search_url, page, is_outbound);
		
		return false;
	});
}

function validate_tour_check_rate_form() {
	
	var checkin_id = '#checkin_date';
	
	if($('#departure_id').length > 0) {
		var id = $('#departure_id').val();
		checkin_id = '#checkin_date_' + id;
	}
	
	var start_date = $(checkin_id).val();
	
	if($.trim(start_date) == '') {
		$(checkin_id).focus();
		$(checkin_id).addClass('bpv-input-warning');
		
		alert('Xin vui lòng nhập thông tin "Ngày đi"');
		return false;
	}

	if(!check_date(start_date)) {
		$(checkin_id).focus();
		$(checkin_id).addClass('bpv-input-warning');
		
		alert('"Ngày đi" phải theo định dạng ' + FORMAT_DATE);
		return false;
	}
	
	return true;
}

function check_accommodation_rates(){
	$('.bpv-rate-loading').show();
	$('#rate_content').hide();

	$.ajax({
		url: "/tour_details/check_rates/?" + $('#check_rate_form').serialize(),
		type: "GET",
		cache: true,
		data: {
		},
		success:function(value){
			$('.bpv-rate-loading').hide();

			$('#rate_content').html(value);

			$('#rate_content').show();
		},
		error:function(var1, var2, var3){
			
		}
	});	
}

function init_tour_details()
{
	// load review data
	init_review_tab('#tour_tabs');
	
	// change tab add class book button
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	    $('#book-bottom-box').removeClass('hide');
		
	    if($(this).attr('href') == '#tab_price_table') {
	        $('#book-bottom-box').addClass('book-bottom-box');
	    } else if($(this).attr('href') == '#tab_booking') {
	        $('#book-bottom-box').addClass('hide');
	    } else {
	        $('#book-bottom-box').removeClass('book-bottom-box');
	    }
	})

	// set book button event
	$('.btn-book-tour').click(function(){
		open_book_tab();
	});
	
	$('.btn_book_t').click(function(){
		open_book_tab();
	});
	
	$('.btn-tour-support').click(function(){
		$("#btn-tour-support").hide();
		$("#tour_contact").show();
	});
	
	// fixed navigation
	var nav = $('.bpv-tab-tours');
	var nav_itinerary = $('.itinerary-summary');
	var nav_width = nav.width();
	var nav_iti_width = nav_itinerary.width();
	
	// browser window scroll (in pixels) after which the "menu" link is shown
	var offset = 900;
	var offset_iti = Math.round(nav_itinerary.offset().top);

	$(window).scroll(function () {
		
		// For tour tab
		var menu_height = $('.itinerary-summary').height();
		var s_bottom = $('#btn-tour-support').offset().top - menu_height;
		
	    if ($(this).scrollTop() > offset && $(this).scrollTop() < s_bottom) {
	        nav.addClass("f-nav");
	        nav.css('width', nav_width);
	    } else {
	        nav.removeClass("f-nav");
	        nav.css('width', '100%');
	    }
	    
	    // For itinerary summary
	    if($('.bpv-call-us').is(':visible')) {
    		offset_iti = $('.bpv-call-us').offset().top + $('.bpv-call-us').height();
    	}
    	else if ($('.bpv-search-left').is(':visible')) {
	    	offset_iti = $('.bpv-search-left').offset().top + $('.bpv-search-left').height();
	    }
	    
	    if ($(this).scrollTop() > offset_iti && $(this).scrollTop() < s_bottom) {
	        nav_itinerary.addClass("f-nav-side");
	        nav_itinerary.css('width', nav_iti_width);
	    } else {
	        nav_itinerary.removeClass("f-nav-side");
	        nav_itinerary.css('width', 'auto');
	    }
	});
	
	// click on tab
	$('#tour_tabs a').click(function (e) {
		if ($(window).scrollTop() > offset) {
			$("html, body").animate({ scrollTop: offset}, "fast");
		}
	})
}

function open_book_tab()
{
	$('#tour_tabs a[href="#tab_booking"]').tab('show');

	$("html, body").animate({ scrollTop: 808}, "fast");
}

function update_tour_total_payment(unit){
	
	var total_room_rate_payment = 0;
	
	$('.room-rate-payment').each(function(){
		total_room_rate_payment = total_room_rate_payment + parseInt($(this).attr('rate'));
	});
	
	$('.surcharge-payment').each(function(){
		total_room_rate_payment = total_room_rate_payment + parseInt($(this).attr('rate'));
	});
	
	// calculate the tour promotion discount
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