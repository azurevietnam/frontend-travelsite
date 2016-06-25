var Loader = function () { }
Loader.prototype = {
    require: function (scripts, callback) {
        this.loadCount      = 0;
        this.totalRequired  = scripts.length;
        this.callback       = callback;
             
        for (var i = 0; i < scripts.length; i++) {
            this.writeScript(scripts[i]);
        }
    },
    loaded: function (evt) {
        this.loadCount++;

        if (this.loadCount == this.totalRequired && typeof this.callback == 'function') this.callback.call();
    },
    writeScript: function (src) {
        var self = this;
        var s = document.createElement('script');
        s.type = "text/javascript";
        s.async = true;
        s.src = src;
        
        if (s.addEventListener) { // normal browser
        	
        	s.addEventListener('load', function (e) { self.loaded(e); }, false);
        	
        }else{
        	s.onreadystatechange = function(e) { // old IEs
        		if (s.readyState in {loaded: 1, complete: 1}) {
        			s.onreadystatechange = null;
        			
        			self.loaded(e);
        		}
        	};

        }
        
        var first_js = document.getElementsByTagName('script')[0];
        first_js.parentNode.insertBefore(s, first_js);
    }
}


/**
 * Constant for DATE Format
 */
var FORMAT_DATE = 'dd/mm/yyyy';
var FORMAT_DATE_CALENDAR = 'dd/mm/yy';

/**
 * Common function
 */
var dateFormat = function (now) {
	pad = function (val, len) {
		val = String(val);
		len = len || 2;
		while (val.length < len) val = "0" + val;
		return val;
	};
	
	var d = now.getDate();
	var m = now.getMonth();
	m++;
	var y = now.getFullYear();
	
	return pad(d) + "/" + pad(m) + "/" + y;
}

var get_JS_Date = function(now) {
	var d = now.split('/');
	return new Date(parseInt(d[2], 10), [parseInt(d[1], 10)-1], parseInt(d[0], 10), 0, 0, 0, 0);
}

function check_date(value) {
	
	var validformat = /^\d{2}\/\d{2}\/\d{4}$/ // Basic check for format
	
	// validity
	var returnval = false;
	if (!validformat.test(value))
		return false;
	else { // Detailed check for valid date ranges
		var dayfield = value.split("/")[0];
		var monthfield = value.split("/")[1];
		var yearfield = value.split("/")[2];
		var dayobj = new Date(yearfield, monthfield - 1, dayfield);
		if ((dayobj.getMonth() + 1 != monthfield)
				|| (dayobj.getDate() != dayfield)
				|| (dayobj.getFullYear() != yearfield))
			returnval = false;
		else
			returnval = true;
	}
	if (returnval == false)
		input.select();
	
	return returnval
}

/**
 * Init Flight Search Form
 */
function init_flight_search() {
	
	//get_current_search(2); // module = FLIGHT
	
	
	// Handle event click icon calendar
	$('#btn_flight_departure_date').click(function () {
		$('#flight_departure_date').focus();
	});
	
	// Handle event click icon calendar
	$('#btn_flight_returning_date').click(function () {
		$('#flight_returning_date').focus();
	});
	
}

function set_up_flight_calendar(is_mobile){
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	set_up_calendar('#flight_departure_date', function(dateText, inst){
		
		$('#flight_departure_date').removeClass('bpv-input-warning');
		
		var depart_date = $(this).datepicker("getDate"); 
		
		var return_date = $('#flight_returning_date').datepicker("getDate"); // null if not selected
		
		if (!is_mobile){ // only check on the desktop version
			
			if(return_date != null && return_date <= depart_date){
				
				$("#flight_returning_date").datepicker("setDate", dateText);
				
				setTimeout(function(){
					$("#flight_returning_date").datepicker("show");
		        }, 100); 
				
			}
			
		}
		
		
	}, is_mobile);
	
	set_up_calendar('#flight_returning_date', function(dateText, inst){
		
		$('#flight_returning_date').removeClass('bpv-input-warning');
		
		$('#delete_return').show();
		
		if($('#flight_type').length > 0){ // if the search form has 2 option: round-trip & oneway
			$("input[name=Type][value=roundway]").prop('checked', true);
		}
		
		var depart_date = $('#flight_departure_date').datepicker("getDate"); // null if not selected
		
		var return_date = $(this).datepicker("getDate");
		
		if (!is_mobile){ // only check on the desktop version
		
			if(depart_date != null && return_date <= depart_date){
				
				$("#flight_departure_date").datepicker("setDate", dateText);
				
				setTimeout(function(){
					$("#flight_departure_date").datepicker("show");
		        }, 100);     
	
			}
		
		}
		
	}, is_mobile);
}

function delete_flight_return(){
	$('#flight_returning_date').removeClass('bpv-input-warning');
	$('#flight_returning_date').val('');
	$('#delete_return').hide();
	
	if($('#flight_type').length > 0){ // if the search form has 2 option: round-trip & oneway
		$("input[name=Type][value=oneway]").prop('checked', true);
	}
}

function select_flight_type(){
	var type_val = $('input[name="Type"]:checked').val();
	if(type_val == 'oneway'){
		delete_flight_return();
	}
}

function check_search_type() {
	
	var checked_val = $('input[name="search_type"]:checked').val();
	
	if(checked_val == 0) {
		$('#tab_search_hotel').show();
		$('#tab_search_flight').hide();
		$('#tab_search_tour').hide();
	} else if(checked_val == 1) {
		$('#tab_search_hotel').hide();
		$('#tab_search_flight').show();
		$('#tab_search_tour').hide();
	} else {
		$('#tab_search_hotel').hide();
		$('#tab_search_flight').hide();
		$('#tab_search_tour').show();
	}
	
	$('#search_label').text($('#txt_search_label_'+checked_val).text());
}


function validate_flight_search() {
	
	var from = $('#flight_from');
	var to = $('#flight_to');
	
	if($.trim(from.val()) == '') {
		alert('Xin vui lòng nhập "Điểm Đi"');
		$(from).focus();
		$(from).addClass('bpv-input-warning');
		return false;
	}
	
	if($.trim(to.val()) == '') {
		alert('Xin vui lòng nhập "Điểm Đến"');
		$(to).focus();
		$(to).addClass('bpv-input-warning');
		return false;
	}
	
	// validate departure and returning date
	var departure = $('#flight_departure_date').val();
	var return_date = $('#flight_returning_date').val();
	
	if($.trim(departure) == '') {
		
		alert('Xin vui lòng nhập "Ngày đi"');
		
		$('#flight_departure_date').focus();
		$('#flight_departure_date').addClass('bpv-input-warning');
		
		return false;
	}
	
	if(!check_date(departure)){
		
		alert('"Ngày đi" phải theo định dạng ' + FORMAT_DATE);
		
		$('#flight_departure_date').focus();
		$('#flight_departure_date').addClass('bpv-input-warning');
		
		return false;
	}
	
	var today = new Date();
	today = dateFormat(today);
	if(get_JS_Date(departure) < get_JS_Date(today)){
		
		alert('"Ngày đi" không được phép là ngày trong quá khứ!');
		
		$('#flight_departure_date').focus();
		$('#flight_departure_date').addClass('bpv-input-warning');
		
		return false;
	}
	
	if(return_date != '' && !check_date(return_date)){
		alert('"Ngày về" phải theo định dạng ' + FORMAT_DATE);
		$('#flight_returning_date').focus();
		$('#flight_returning_date').addClass('bpv-input-warning');
		
		return false;
	}
	
	if(return_date != '' && get_JS_Date(departure) > get_JS_Date(return_date)) {
		alert('Vui lòng nhập "Ngày về" lớn hơn hoặc bằng "Ngày đi"');
		$('#flight_returning_date').focus();
		$('#flight_returning_date').addClass('bpv-input-warning');
		return false;
	}
	
	if($('#flight_type').length > 0){ // if the search form has 2 option: round-trip & oneway
		var type_val = $('input[name="Type"]:checked').val();
		
		if(type_val == 'roundway'){
			
			if($.trim(return_date) == '') {
				
				alert('Bạn đang tìm kiếm chuyến bay khứ hồi. Xin vui lòng nhập "Ngày về"');
				$('#flight_returning_date').focus();
				$('#flight_returning_date').addClass('bpv-input-warning');
				return false;
				
			}
			
		}
	}
	
	return true;
	
}

function validate_flight_search_dialog() {
	
	// validate departure and returning date
	var departure = $('#flight_dialog_departure_date').val();
	var return_date = $('#flight_dialog_returning_date').val();
	
	if($.trim(departure) == '') {
		
		alert('Xin vui lòng nhập "Ngày đi"');
		
		$('#flight_dialog_departure_date').focus();
		$('#flight_dialog_departure_date').addClass('bpv-input-warning');
		
		return false;
	}
	
	if(!check_date(departure)){
		
		alert('"Ngày đi" phải theo định dạng ' + FORMAT_DATE);
		
		$('#flight_dialog_departure_date').focus();
		$('#flight_dialog_departure_date').addClass('bpv-input-warning');
		
		return false;
	}
	
	var today = new Date();
	today = dateFormat(today);
	if(get_JS_Date(departure) < get_JS_Date(today)){
		
		alert('"Ngày đi" không được phép là ngày trong quá khứ!');
		
		$('#flight_dialog_departure_date').focus();
		$('#flight_dialog_departure_date').addClass('bpv-input-warning');
		
		return false;
	}
	
	if(return_date != '' && !check_date(return_date)){
		alert('"Ngày về" phải theo định dạng ' + FORMAT_DATE);
		$('#flight_dialog_returning_date').focus();
		$('#flight_dialog_returning_date').addClass('bpv-input-warning');
		
		return false;
	}
	
	if(return_date != '' && get_JS_Date(departure) > get_JS_Date(return_date)) {
		alert('Vui lòng nhập "Ngày về" lớn hơn hoặc bằng "Ngày đi"');
		$('#flight_dialog_returning_date').focus();
		$('#flight_dialog_returning_date').addClass('bpv-input-warning');
		return false;
	}
	
	return true;
	
}

// common function used for search form & check rate from
function init_hotel_date(startdate_id, night_id, enddate_id, enddate_display_id, startdate_value){
	
	var today = new Date();
	today = dateFormat(today);
	
	if(startdate_value != '' && startdate_value != undefined){
		$(startdate_id).val(startdate_value);
	}
	
	get_check_out_date(startdate_id, night_id, enddate_id, enddate_display_id);
	
	$(startdate_id).change(function() {
		get_check_out_date(startdate_id, night_id, enddate_id, enddate_display_id);
	});
	
	$(night_id).change(function() {
		get_check_out_date(startdate_id, night_id, enddate_id, enddate_display_id);
	});
	
	var icon_calender_id = '#btn_' + startdate_id.replace('#','');
	
	// Handle event click icon calendar
	$(icon_calender_id).click(function () {
		$(startdate_id).focus();
	});
	
}

function init_hotel_search(get_search, is_mobile) {
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	if(get_search == undefined){
		get_search = false;
	}
	
	if(get_search){
		get_current_search(1); // module = HOTEL
	}
	
	
	init_hotel_date('#startdate','#night','#enddate','#show_search_end_date', '');

	
	// Clear search value button
	if ($( '#destination' ).parent().find( ".search-choice-close" ).length == 0 && $( '#destination' ).val() != '' && !is_mobile){
		add_clear_search('#destination');
	}

	
	// Add clear button
	$( "#destination" ).blur(function() {
		if( $.trim($( "#destination" ).val()) != '' && !is_mobile) {
			add_clear_search('#destination');
		}
	});
	
	// whenever change value then remove object id
	$( "#destination" ).on('input',function(){
		if( $.trim($( "#destination" ).val()) != $( '#destination' ).data("selected_value") ) {
			$('#hotel_destination_input').val('');
			$('#oid').val('');
			
			$( ".search-choice-close" ).remove();
			//console.log('change value: '+ $( "#destination" ).val() + ' || ' + $.trim($( '#destination' ).data("selected_value")));
			
			// hide popup
			$('#destination').popover('hide');
		}
	})
	
	check_search_type();

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
			$('#hotel_destination_input').val( $(this).attr('data-url-title') );
			$('#oid').val( 'd-' + $(this).attr('data-id') );
			
			// store selected value
			$( '#destination' ).data("selected_value", $( '#destination' ).val());
			
			// add clear button
			add_clear_search('#destination');

			// hide popup
			$('#destination').popover('hide');
			
			// cancel triger typeahead
			$('.typeahead').typeahead('close');
		});
	});
}


function set_up_calendar(input_id, fn_select, is_mobile) {
	
	var num_months = 2;
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
		num_months = 1;
	} else {
		is_mobile = false;
	}
	
	if(fn_select == undefined && typeof fn_select != 'function'){
		fn_select = null;
	}
	
	$(input_id).datepicker({
		numberOfMonths: num_months,
		closeText: 'Đóng',
        currentText: 'Hôm nay',
        showButtonPanel: is_mobile,
		minDate: 0,
		monthNames: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
		dayNames: [ "CN", "T2", "T3", "T4", "T5", "T6", "T7" ],
		dayNamesMin: [ "CN", "T2", "T3", "T4", "T5", "T6", "T7" ],
		dateFormat: FORMAT_DATE_CALENDAR,
		onSelect: fn_select
	});
	
	if(is_mobile) {
		// workaround with read-only bug in Safari iOS 8
		$(input_id).on('focus', function(ev) {
		    $(this).trigger('blur');
		});
	}
}

function set_up_hotel_calendar(is_mobile){
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}

	if($('#startdate').length > 0){

		set_up_calendar('#startdate', null, is_mobile);
		
	}
	
	if($('#checkin_date').length > 0){
	
		set_up_calendar('#checkin_date', null, is_mobile);
	}
	
}

function set_up_hotel_autocomplete(is_mobile){
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	//get_hotel_destinations
	var destinations = new Bloodhound({
		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {url: '/suggest_hotel_destinations/?query=%QUERY',},
	});
	var hotels = new Bloodhound({
		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {url: '/suggest_hotels/?query=%QUERY',},
	});
	destinations.initialize();
	hotels.initialize();

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
		source : hotels.ttAdapter(),
		templates: {
			header: '<span class="lb-header">Khách Sạn</span>'
		}
	}).on("typeahead:selected", function($e, datum){
		// Save object id
		$('#hotel_destination_input').val(datum['url_title']);
		$('#oid').val(datum['type'] + '-' + datum['id']);
		
		// store selected value
		$( '#destination' ).data("selected_value", $( '#destination' ).val());
		
		// add clear button
		if(!is_mobile) {
			add_clear_search('#destination');
		}
		
		// hide popover
		$('#destination').popover('hide');
	});
	
}

function add_clear_search(id) {
	// check if it's exist
	if ($( id ).parent().find('.search-choice-close').length == 0) { 
		var btn_close = $('<span class="icon btn-search-close search-choice-close"></span>');
		$( id ).parent().append(btn_close);
		
		btn_close.click(function() {
			clear_search(id);
		});
	}
}

function clear_search(id) {
	
	$(id).val('');
	$(id).focus();
	
	$( id ).parent().find('.typeahead').typeahead('val', '');
	$( id ).parent().parent().find( '.search-choice-close' ).remove();
	
	if(id == '#destination') {
		$('#oid').val('');
		$('#hotel_destination_input').val('');
	}
	
	if(id == '#tour_destination') {
		$('#des_id').val('');
	}
}

function get_check_out_date(startdate_id, night_id, enddate_id, enddate_display_id) {
	var dmy = $(startdate_id).val();  
	
	if(check_date(dmy)) {
		var check_out_date = get_JS_Date(dmy);
		var number_of_nights = $(night_id).val();
		
		check_out_date.setDate(check_out_date.getDate() + parseInt(number_of_nights, 10));
		
		if(check_date(dateFormat(check_out_date))) {
			$(enddate_display_id).html(dateFormat(check_out_date));
			$(enddate_id).val(dateFormat(check_out_date));
			if($('#enddate_lbl').length > 0){
				$('#enddate_lbl').show();
			}
		}
	}
}


function validate_hotel_search() {
	
	if($.trim($('#destination').val()) == '') {
		alert('Xin vui lòng nhập Tỉnh/Thành Phố/Điểm Du Lịch/Tên Khách Sạn');
		$('#destination').focus();
		$('#destination').addClass('bpv-input-warning');
		
		return false;
	}
	
	var start_date = $('#startdate').val();
	
	if($.trim(start_date) == '') {
		$('#startdate').focus();
		$('#startdate').addClass('bpv-input-warning');
		
		alert('Xin vui lòng nhập thông tin "Ngày nhận phòng"');
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


/*
 * remove recent items
 */
function not_interested(item_id) {
	$.ajax({
		url: '/remove_recent_item/',
		type: "POST",
		cache: true,
		data: {
			'item_id': item_id
		},
		success:function(value){
			// do nothing
		},
	});
	if ($('#ritem-'+item_id).prev().length > 0) {
		$('#ritem-'+item_id).prev().addClass('no-border');
	}
	
	$('#ritem-'+item_id).remove();
	
	var numItems = $('#box_recent_items .bpt-list-sm').length;
	if(numItems < 1) {
		$('#box_recent_items').remove();
	}
	//console.log(numItems);
}

/**
 * General Functions
 */

function bpv_format_currency(rate, unit){
	
	rate = rate.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
	
	if(rate.length > 3){
		
		var rate_1 = rate.substring(0, rate.length - 3);
		
		var rate_2 = rate.substring(rate.length - 3, rate.length);
		
		rate = rate_1 + '<small>' + rate_2 + ' ' + unit + '</small>';
	}
	
	return rate;
	
}

function go_url(url){
	window.location = url;
}

function go_check_rate_position(){
	$("html, body").animate({ scrollTop: $(".bpv-check-rate-form").offset().top}, "fast");
}

function go_position(top){
	$("html, body").animate({ scrollTop: top}, "fast");
}

function get_url_var(key, link){
	var result = new RegExp(key + "=([^&]*)", "i").exec(link);
	return result && unescape(result[1]) || "";
}

function show_more_photos(){
	var show = $('#show_more_photos').attr('show');
	var txt = $('#show_more_photos').text();
	if(show == 'hide'){
		$('.more-photos').show();
		
		$('#show_more_photos').attr('show','show');
		
		txt = txt.replace('[+]','[-]');
	} else {
		$('.more-photos').hide();
		
		$('#show_more_photos').attr('show','hide');
		txt = txt.replace('[+]','[-]');
	}
	$('#show_more_photos').text(txt);
}

function show_more_rooms(){
	var show = $('#show_more_rooms').attr('show');
	var txt = $('#show_more_rooms').text();
	if(show == 'hide'){
		$('.more-rooms').show();
		
		$('#show_more_rooms').attr('show','show');
		
		txt = txt.replace('[+]','[-]');
	} else {
		$('.more-rooms').hide();
		
		$('#show_more_rooms').attr('show','hide');
		txt = txt.replace('[-]','[+]');
	}
	$('#show_more_rooms').text(txt);
}

function show_more(obj){
	
	var show = $(obj).attr('show');
	var txt = $(obj).text();
	if(show == 'hide'){
		$('.hidden-item').show();
		
		$(obj).attr('show','show');
		
		txt = txt.replace('[+]','[-]');
	} else {
		$('.hidden-item').hide();
		
		$(obj).attr('show','hide');
		txt = txt.replace('[+]','[-]');
	}
	$(obj).text(txt);
	
}

function change_search(){
	$('.bpv-search-overview').hide();
	$('.bpv-search-left').show();
}



/*
 * validate email
 */
 function is_valid_email(email)
 {
	 
	 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	  if(!emailReg.test(email)) {
	    return false;
	  } else {
	    return true;
	  }
 }



/**
 *	Validate Contact Form
 *
 */
function validate_contact_form(){
	
	var ret = true;
	$('.bpv-contact .warning-message').hide();
	
	$('.bpv-contact input').removeClass('bpv-input-warning');
	
	$('.bpv-contact select').removeClass('bpv-input-warning');
	
	if($.trim($('#gender').val()) == ''){
		$('#gender').addClass('bpv-input-warning');
		$('#title_required').show();
		ret = false;
	}
	
	if($.trim($('#name').val()) == ''){
		$('#name').addClass('bpv-input-warning');
		$('#name_required').show();
		ret = false;
	}
	
	
	if($.trim($('#email').val()) == ''){
		$('#email').addClass('bpv-input-warning');
		$('#email_required').show();
		ret = false;
	} else {
		
		if(!is_valid_email($('#email').val())){
			$('#email').addClass('bpv-input-warning');
			$('#email_valid').show();
			ret = false;
		}
		
	}
	
	var day = $.trim($('#c_day').val());
	var month = $.trim($('#c_month').val());
	var year = $.trim($('#c_year').val());
	
	var is_input_birthday = day != '' || month != '' || year != '';
	
	if (is_input_birthday){
		
		if (day == ''|| month == '' || year == ''){
			
			$('#birthday_valid').show();
			ret = false;
			
		}
		
		if (day == '') $('#c_day').addClass('bpv-input-warning');
		
		if (month == '') $('#c_month').addClass('bpv-input-warning');
		
		if (year == '') $('#c_year').addClass('bpv-input-warning');
	}
	
	
	
	if($.trim($('#phone').val()) == ''){
		$('#phone').addClass('bpv-input-warning');
		$('#phone_required').show();
		ret = false;
	}
	
	if($.trim($('#phone_cf').val()) == ''){
		$('#phone_cf').addClass('bpv-input-warning');
		$('#phone_cf_required').show();
		ret = false;
	} else {
		
		if($('#phone_cf').val() != $('#phone').val()){
			$('#phone_cf').addClass('bpv-input-warning');
			$('#phone_cf_valid').show();
			ret = false;
		}
		
	}
	
	if(!ret){
		
		go_position($('.bpv-contact').offset().top);
		
	} else {
		
		// validation payment methods if it's avaiable
		if( $('#payment_method').length > 0) {
			var method = $('#payment_method').val();
			if(method == '') {
				alert('Xin vui lòng lựa chọn hình thức thanh toán.');
				ret = false;
				go_position($('.bpv-payment-methods').offset().top);
			}
		}
		
		
		if(ret && $("#submit_data_waiting").length > 0){
			$('#submit_data_waiting').modal()
		}
	}
	
	return ret;
}

/**
 *	Init Payment Detail Form
 *
 */
function init_payment_detail(){
	$('.right-fixed').width($('.bpv-col-left').width());
	
	var code = $('#pro_code').val();
	if($.trim(code) != ''){
		$('#pro_use').show();
	} else {
		$('#pro_use').hide();
	}
	
	$('#pro_code').keyup(function(){
		var code = $('#pro_code').val();
		if($.trim(code) != ''){
			$('#pro_use').show();
			
			$('#pro_use_2').show();
		} else {
			$('#pro_use').hide();
			
			$('#pro_use_2').hide();
		}
		
		// the alternative Promototion Code Area
		$('#pro_code_2').val(code);
	});
	
	$('#pro_code_2').keyup(function(){
		var code = $('#pro_code_2').val();
		if($.trim(code) != ''){
			$('#pro_use').show();
			
			$('#pro_use_2').show();
		} else {
			$('#pro_use').hide();
			
			$('#pro_use_2').hide();
		}
		
		// the alternative Promototion Code Area
		$('#pro_code').val(code);
	});
	
	$('#pro_phone').keyup(function(){
        var phone = $('#pro_phone').val();
        
        // the alternative Promototion Code Area
        $('#pro_phone_2').val(phone);
        $('#phone').val(phone);
        $('#phone_cf').val(phone);
    });
	
	$('#pro_phone_2').keyup(function(){
        var phone = $('#pro_phone_2').val();
        
        // the alternative Promototion Code Area
        $('#pro_phone').val(phone);
        $('#phone').val(phone);
        $('#phone_cf').val(phone);
    });
}

function use_pro_code(service_type){
	
	reset_pro_code_discount(service_type);
	
	
	$('#code_invalid').hide();
	$('#code_ok').hide();
	
	// the alternative Promotion Code Area
	$('#code_invalid_2').hide();
	$('#code_ok_2').hide();
	
	var pro_code = $.trim($('#pro_code').val());
	var hotel_id = $('#pro_hotel').val();
	var cruise_id = $('#pro_cruise').val();
	var tour_id = $('#pro_tour').val();
	var nr_passengers = $('#pro_nr_passengers').val();
	var pro_phone = $.trim($('#pro_phone').val());
	
	if(/^[a-zA-Z0-9- ]*$/.test(pro_code) == false || pro_code == ''){
		$('#code_invalid').show();
		
		// the alternative Promotion Code Area
		$('#code_invalid_2').show();
	} else {
		
		$('#pro_use').button('loading');
		
		$('#pro_use_2').button('loading');
		
		$.ajax({
			url: "/apply-promotion-code/",
			type: "POST",
			cache: false,
			dataType: 'json',
			data: {
				"service_type":service_type,
				"pro_code":pro_code,
				"hotel_id":hotel_id,
				"cruise_id":cruise_id,
				"tour_id":tour_id,
				"nr_passengers":nr_passengers,
				"pro_phone":pro_phone,
			},
			success:function(value){
				
				$('#pro_use').button('reset');
				$('#pro_use_2').button('reset');
				
				if( value.invalid_phone ){
                    $('.pro_phone_block').show();
                    $('.pro_phone_invalid').show();
                    $('.pro_phone_invalid_msg').html(value.invalid_phone);
                    
                    return false;
                } else {
                    $('.pro_phone_invalid').hide();
                }

				if(value == ''){ // no promotion found
					
					$('#code_invalid').show();
					
					$('#code_invalid_2').show();
					
				} else {
				    
					update_booking_payment(value, pro_code, service_type);
				}
				
			},
			error:function(var1, var2, var3){
				$('#code_invalid').show();
				$('#pro_use').button('reset');
				
				$('#code_invalid_2').show();
				$('#pro_use_2').button('reset');
			}
		});
	}
}

function update_booking_payment(discount_info, pro_code, service_type){
	
	var applied_code_discount = 0;
	
	if(discount_info.discount_type == 2){ // amount discount per booking
		applied_code_discount = discount_info.get;
	}
	
	if(discount_info.discount_type == 3){ // discount per ticket
		var get = discount_info.get;
		
		var nr_ticket = $('#nr_ticket').val();
		if(nr_ticket == undefined || nr_ticket == ''){
			nr_ticket = 0;
		} else {
			nr_ticket = parseInt(nr_ticket);
		}
		
		applied_code_discount = get * nr_ticket;
	}
	
	if(discount_info.discount_type == 4){ // discount per pax
		var get = discount_info.get;
		
		var nr_pax = $('#nr_pax').val();
		if(nr_pax == undefined || nr_pax == ''){
			nr_pax = 0;
		} else {
			nr_pax = parseInt(nr_pax);
		}
		
		applied_code_discount = get * nr_pax;
	}	
	
	if(discount_info.discount_type == 1){ // % discount per booking
		var get = discount_info.get;
		var get_max = discount_info.get_max;
		
		var total_booking = 0;
		
		if (service_type == 1){ // HOTEL
			total_booking = update_hotel_total_payment('đ');
		}
		
		if (service_type == 2){ // FLIGHT
			total_booking = update_flight_total_payment('đ');
		}
		
		if (service_type == 3){ // CRUISE
			total_booking = update_cruise_total_payment('đ');
		}

		if (service_type == 4){ // TOUR
			total_booking = update_tour_total_payment('đ');
		}
		
		var applied_code_discount = total_booking * get / 100;
		
		if(applied_code_discount > get_max && get_max > 0) applied_code_discount = get_max;
		
		applied_code_discount = Math.round(applied_code_discount/1000)*1000;
	}
	
	
	$('#applied_code_discount').attr('rate', applied_code_discount);
	
	$('#applied_code_discount').html('- ' + bpv_format_currency(applied_code_discount, 'đ'));
	
	$('#applied_code').text(pro_code);
	
	if(applied_code_discount > 0){
		$('#p_applied_code').show();
	}
	
	
	var ok_html = '<span class="glyphicon glyphicon-ok"></span>';
	
	if(applied_code_discount > 0){
		
		ok_html = ok_html + '&nbsp; Đã giảm giá <b>' +  bpv_format_currency(applied_code_discount, 'đ') + '</b>.';
		
	}
	
	if(discount_info.discount_note != undefined && discount_info.discount_note != ''){
		
		ok_html = ok_html + '&nbsp; ' + discount_info.discount_note;
		
	}
	
	
	$('#code_ok').html(ok_html);
	$('#code_ok').show();
	
	$('#code_ok_2').html(ok_html);
	$('#code_ok_2').show();
	
	$('#promotion_code_used').val(pro_code);
	
	if (service_type == 1){ // HOTEL
		update_hotel_total_payment('đ');
	}
	
	if (service_type == 2){ // FLIGHT
		update_flight_total_payment('đ');
	}
	
	if (service_type == 3){ // CRUISE
		update_cruise_total_payment('đ');
	}

	if (service_type == 4){ // TOUR
		update_tour_total_payment('đ');
	}
	
	return applied_code_discount;
}

function reset_pro_code_discount(service_type){
	$('#applied_code_discount').attr('rate',0);
	$('#p_applied_code').hide();
	$('#promotion_code_used').val('');
	
	if(service_type == 1){ // HOTEL
		update_hotel_total_payment('đ');
	}
	
	if (service_type == 2){ // FLIGHT
		update_flight_total_payment('đ');
	}
	
	if (service_type == 3){ // CRUISE
		update_cruise_total_payment('đ');
	}

	if (service_type == 4){ // TOUR
		update_tour_total_payment('đ');
	}
}

function send_contact_request(ele) {
	
	var id = $(ele).attr('data-id');

	// validate contact form
	var substr = ["groupon_request", "groupon_email", "groupon_phone_number"];

	var is_valid = true;
	$.each(substr , function(i, val) { 
		var txt = $('#'+val).val();
		if(txt == '' 
				|| ( val == "groupon_email" && !IsEmail(txt) )
				|| ( val == "groupon_phone_number" && !IsPhone(txt) ) ) {
			$('#'+val).focus();
			$('#'+val).addClass('bpv-input-warning');
			$('.er_'+val).removeClass('hide');
			is_valid = false;
		} else {
			$('#'+val).removeClass('bpv-input-warning');
			$('.er_'+val).addClass('hide');
		}
	});

	if(is_valid) {
		$('#'+id+'_hd').button('loading');
		$('#'+id+'_form').addClass('hide');
		$('#'+id+'_waiting').removeClass('hide');
		$.ajax({
			url: "/groupon_request/",
			type: "POST",
			data: {
				"groupon_request": $('#groupon_request').val(),
				"groupon_email": $('#groupon_email').val(),
				"groupon_phone_number": $('#groupon_phone_number').val(),
				"groupon_pop_type":$('#popup_type').val(),
			},
			success:function(value){
				$('#'+id+'_hd').button('reset');
				$('#'+id+'_waiting').addClass('hide');
				$('#'+id+'_success').removeClass('hide');
				setTimeout(function(){ $('#'+id).popover('hide') }, 10000);
			},
			error:function(var1, var2, var3){
				$('#'+id+'_hd').button('reset');
				alert('Có lỗi kết nối mạng, yêu cầu của quý khách không thể gửi đi, xin quý khách vui lòng gọi đến số 04 3978 1425 để gặp trực tiếp nhân viên của chúng tôi.');
				$('#'+id).popover('hide');
			}
		});
	}
}

function send_tour_contact_request(ele){
	
	var id = $(ele).attr('id');
	// validate tour_contact_form 
	var email	=	$('#tour_request_email').val();
	var phone   =   $('#tour_request_phone').val();
	
	var t_adults  	= 	$('#adults').val();
	var t_children  	= 	$('#children').val();
	var t_infants   	= 	$('#infants').val();
	
	var t_request	= 	$('#tour_request_content').val();
	
	$('#tour_request_email').removeClass('bpv-input-warning');
	$('#tour_request_phone').removeClass('bpv-input-warning');
	$('.er_tour_request_email').addClass('hide');
	$('.er_tour_request_phone').addClass('hide');
	
	if(IsEmail(email) && IsPhone(phone)){
		return true;
	}else if(!IsEmail(email) && IsPhone(phone)){
		$('#tour_request_email').focus();
		$('#tour_request_email').addClass('bpv-input-warning');
		$('.er_tour_request_email').removeClass('hide');
		$('.er_tour_request_email').html('Bạn cần nhập đúng thông tin <b>[Email]</b> ');
		return false;
	}else if(IsEmail(email) && !IsPhone(phone)){
		$('#tour_request_phone').focus();
		$('#tour_request_phone').addClass('bpv-input-warning');
		$('.er_tour_request_phone').removeClass('hide');
		return false;
	}else{
		$('#tour_request_email').focus();
		$('#tour_request_email').addClass('bpv-input-warning');
		$('.er_tour_request_email').removeClass('hide');
		
		$('#tour_request_phone').focus();
		$('#tour_request_phone').addClass('bpv-input-warning');
		$('.er_tour_request_phone').removeClass('hide');
		return false;
	}
}

function send_news_letter_request(ele){
	var id = $(ele).attr('id');
	
	// validate newsletter_to 
	var email	=	$('#newsletter_to').val();
	if(IsEmail(email)){
		$('#newsletter').button('loading');
		$('#newsletter').html('Đang xử lý');
		$.ajax({
			url: "/news-letter-request/",
			type: "POST",
			data: {
				"news_letter_to": email
			},
			success:function(value){
				if(value ==1 || value==2){
					$('#newsletter').button('reset');
					$('#newsletter_to').attr("readonly","1");
					$('#newsletter_to').removeClass('bpv-input-warning');
					$('#newsletter_to').val('');
					$('#newsletter').css('margin-top','27px');
					$('.bpv-register').css('height','90px');
					
					// hide 'invalid', show 'success'
					$('#newsletter_invalid').addClass('hide');
					$('#newsletter_ok').removeClass('hide');
				
				}else if(value ==3){
					$('#newsletter').button('reset');
					$('#newsletter_to').focus();
					$('#newsletter_to').addClass('bpv-input-warning');
					
					// show invalid, hide 'success'
					$('#newsletter_invalid').removeClass('hide');
					$('#newsletter').css('margin-top','27px');
					$('.bpv-register').css('height','90px');
				}
			},
			error:function(var1, var2, var3){
				$('#newsletter').button('reset');
				alert('Quý khách hãy nhấn lại đăng ký.');
			}
		});
	}else{
		$('#newsletter_to').focus();
		$('#newsletter_to').addClass('bpv-input-warning');
		$('#newsletter_invalid').removeClass('hide');
		$('#newsletter').css('margin-top','27px');
		$('.bpv-register').css('height','90px');
	}
	
	
}

function send_sign_up_request(ele){
	var id = $(ele).attr('data-id');
	$('#'+id+'_success').addClass('hide');
	$('#sign_up_email').removeClass('bpv-input-warning');
	$('#sign_up_phone').removeClass('bpv-input-warning');
	$('.er_sign_up_email').addClass('hide');
	$('.er_sign_up_phone').addClass('hide');
	
	// validate email_to && phone 
	var email	=	$('#sign_up_email').val();
	var phone	=	$('#sign_up_phone').val();
	
	if(IsEmail(email) && IsPhone(phone)){
		
		$('#'+id+'_hd').button('loading');
		$.ajax({
			url: "/sign-up-request/",
			type: "POST",
			data: {
				"email": email,
				"phone": phone,
			},
			success:function(value){
				if(value ==1 || value ==2){
					$('#'+id+'_hd').button('reset');
					$('#'+id+'_waiting').addClass('hide');
					
					$('.er_sign_up_email').addClass('hide');
					$('.er_sign_up_phone').addClass('hide');
					$('#'+id+'_success').removeClass('hide');
					$('#'+id+'_form').addClass('hide');
					setTimeout(function(){ $('#'+id).popover('hide') }, 10000);
				}else if(value ==3){
					$('#'+id+'_hd').button('reset');
					$('#sign_up_email').addClass('bpv-input-warning');
					$('.er_sign_up_email').removeClass('hide');
					$('.er_sign_up_email').html('Email đã được sử dụng , hãy chọn email khác');
				}else if(value ==4){
					$('#'+id+'_hd').button('reset');
					$('#sign_up_email').addClass('bpv-input-warning');
					$('.er_sign_up_email').removeClass('hide');
					$('.er_sign_up_email').html('Bạn cần nhập đúng thông tin <b>[Email]</b> ');
				}else {
					$('#'+id+'_hd').button('reset');
					// alert(value);
					// alert('Quý khách hãy nhấn lại đăng ký tài khoản.');
				}
			},
			error:function(var1, var2, var3){
				$('#'+id+'_hd').button('reset');
				// alert('Quý khách hãy nhấn lại đăng ký tài khoản.');
				;
			}
		});
	}else if(!IsEmail(email) && IsPhone(phone)){
		$('#sign_up_email').focus();
		$('#sign_up_email').addClass('bpv-input-warning');
		$('.er_sign_up_email').removeClass('hide');
		$('.er_sign_up_email').html('Bạn cần nhập đúng thông tin <b>[Email]</b> ');
	}else if(IsEmail(email) && !IsPhone(phone)){
		$('#sign_up_phone').focus();
		$('#sign_up_phone').addClass('bpv-input-warning');
		$('.er_sign_up_phone').removeClass('hide');
	}else{
		$('#sign_up_phone').focus();
		$('#sign_up_phone').addClass('bpv-input-warning');
		$('.er_sign_up_phone').removeClass('hide');
		
		$('#sign_up_email').focus();
		$('#sign_up_email').addClass('bpv-input-warning');
		$('.er_sign_up_email').removeClass('hide');
	}
	
}

function send_sign_in_request(ele){
	var id = $(ele).attr('data-id');
	
	$('#'+id+'_success').addClass('hide');
	
	// validate email_to && phone 
	var email		=	$('#sign_in_email').val();
	var password	=	$('#sign_in_password').val();
	
	if(IsEmail(email) && (password !='')){
		
		$('#'+id+'_hd').button('loading');
		$.ajax({
			url: "/sign-in-request/",
			type: "POST",
			data: {
				"email": email,
				"password": password
			},
			success:function(value){
				if(value ==1){
					$('#'+id).popover('hide');
					$('#btn_sign_in').addClass('hide');
					$('#btn_sign_up').addClass('hide');
					
					$('#sign_in').show();
					$('#sign_out').show();
					
					$('#sign_in').html('Chào : '+email);
					$('#sign_out').html('Thoát');
					window . location = window . location;
				}else{
					$('#'+id+'_hd').button('reset');
					$('#'+id+'_waiting').addClass('hide');
					
					$('.er_sign_in').removeClass('hide');
				}
				
			},
			error:function(var1, var2, var3){
				$('#'+id+'_hd').button('reset');
				//alert('Quý khách hãy nhấn lại đăng ký tài khoản.');
			}
		});
	}else if(!IsEmail(email)){
		$('#sign_in_email').addClass('bpv-input-warning');
		$('.er_sign_in_email').removeClass('hide');
	}else{
		$('.er_sign_in').removeClass('hide');
	}
}

function sign_out_request(){
	
	$.ajax({
		url: "/sign-out-request/",
		type: "POST",
		success:function(value){
			if(value !=''){
				window . location = window . location;
			}else{
				;
			}
		},
		error:function(var1, var2, var3){
			;
		}
	});
}

function IsPhone(a) {
	var filter = /^[0-9-+]+$/;
	if (filter.test(a)) {
		return true;
	}
	else {
		return false;
	}
}

function IsEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
}

function get_current_search(module){
	
	$(function() {
		
	$.ajax({
		url: "/get-current-search/"+module+'/',
		type: "GET",
		dataType: "JSON",
		data: {
		},
		success:function(value){
				
				if(module == 1){ // HOTEL
					var is_update_des = $('#is_update_des').length == 0 || $('#is_update_des').val() == 1;
					
					if(is_update_des){
						
						$('#destination').attr(value.destination);
						
						$('#oid').val(value.oid);
						
					}
					
				
					if(!value.is_default){
						$('#startdate').val(value.startdate);
						$('#enddate').val(value.enddate);
					} else {
						$('#startdate').val('');
						$('#enddate').val('');
					}
					
					$("#night option[value='" + value.night + "']").attr('selected', 'selected');
					
					get_check_out_date('#startdate', '#night', '#enddate', '#show_search_end_date');
					
					//alert($('#startdate').val());
					
				}
				
				if(module == 2){ // FLIGHT
					
					$("#flight_from option[value='" + value.From + "']").attr('selected', 'selected');
					
					
					var is_update_fly_to = $('#is_update_fly_to').length == 0 || $('#is_update_fly_to').val() == 1;
					
					if(is_update_fly_to){
						
						$("#flight_to option[value='" + value.To + "']").attr('selected', 'selected');
					}
					
					//alert('depart = ' + value.Depart);
					
					$('#flight_departure_date').val(value.Depart);
					$('#flight_returning_date').val(value.Return);
					
					if(value.Return != ''){
						$('#delete_return').show();
					} else {
						$('#delete_return').hide();
					}
					
					$('#flight_dialog_departure_date').val(value.Depart);
					$('#flight_dialog_returning_date').val(value.Return);
					
					if(value.adt != ''){
						$("#adt option[value='" + value.adt + "']").attr('selected', 'selected');
						$("#dialog_adt option[value='" + value.adt + "']").attr('selected', 'selected');
					}
					
					if(value.chd != ''){
						
						$("#chd option[value='" + value.chd + "']").attr('selected', 'selected');
						$("#dialog_chd option[value='" + value.chd + "']").attr('selected', 'selected');
					}
					
					if(value.inf != ''){
						$("#inf option[value='" + value.inf + "']").attr('selected', 'selected');
						$("#dialog_inf option[value='" + value.inf + "']").attr('selected', 'selected');
					}
				}
				
				if(module == 3){ // CRUISE
					
					$('#destination').val(value.destination);
					
					$('#oid').val(value.oid);
					
					$("#duration option[value='" + value.duration + "']").attr('selected', 'selected');
					
					if(!value.is_default){
						$('#startdate').val(value.startdate);
						$('#enddate').val(value.enddate);
					} else {
						$('#startdate').val('');
						$('#enddate').val('');
						$("#duration option[value='']").attr('selected', 'selected');
					}
					
					get_end_date('#startdate', '#duration', '#enddate', '#show_search_end_date');
					
				}
			
				
			
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
	
	});
}

function get_hot_line(display_on) {
	$.ajax({
		url: "/get-hot-line/" + display_on + '/',
		type: "GET",
		dataType: "JSON",
		success:function(value) {
			if(value != '') {
				// for desktop
				var number = value.number;
				var name = value.name;
				
				var txt = number + ' <small>(' + name + ')</small>';
				$('#hd_hotline').html(txt);
				$('#ft_hotline').html(txt);
				
				if(value.is_working_time != 1){ 
					
					$('#hd_phone').hide();
					$('#ft_phone').hide();
					$('#sd_hotline_tel_link').hide();
					
					// show the second hotline 
					if(value.sd_number != ''){
						var txt = value.sd_number + ' <small>(' + value.sd_name + ')</small>';
						$('#hd_phone').html(txt);
						$('#ft_phone').html(txt);
						
						$('#sd_hotline_tel_link').attr('href', 'tel:'+value.sd_number_formated);
						
						$('#hd_phone').show();
						$('#ft_phone').show();
						$('#sd_hotline_tel_link').show();
					}
				}
				
				// for mobile
				if($('#hd_hotline_tel_link').length > 0){
					$('#hd_hotline_tel_link').attr('href', 'tel:'+value.number_formated);
				}
				if($('#hd_hotline_header').length > 0){
					$('#hd_hotline_header').attr('href', 'tel:'+value.number_formated);
				}
				
				// show number for the office address  
				if(value.h_hotline_nr != ''){
					$('.h-hotline-nr').attr('href', 'tel:'+value.h_hotline_nr_formated);
					$('.h-hotline-nr').text(value.h_hotline_nr + ' (' + value.h_hotline_name + ')');
				}
				
				// show number for the office address  
				if(value.f_hotline_nr != ''){
					$('.f-hotline-nr').attr('href', 'tel:'+value.f_hotline_nr_formated);
					$('.f-hotline-nr').text(value.f_hotline_nr + ' (' + value.f_hotline_name + ')');
				}
				
				// show to-mobile-link on the footer
				if(value.is_mobile == 1){
					$('#link_to_mobile').show();
				}
			}
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
}

function get_hotline_support_popup(area_id) {
	$.ajax({
		url: "/get-hotline-popup/",
		type: "GET",
		success:function(value) {
			if(value != '') {
				$(area_id).html(value);
			}
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
}

function get_quick_contact_popup(area_id){
	
	$.ajax({
		url: "/get-contact-popup/",
		type: "GET",
		success:function(value) {
			if(value != '') {
				$(area_id).html(value);
			}
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
}

function get_sign_up_popup(area_id){
	
	$.ajax({
		url: "/get-sign-up-popup/",
		type: "GET",
		success:function(value) {
			if(value != '') {
				$(area_id).html(value);
			}
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
}

function get_sign_in_popup(area_id){
	
	$.ajax({
		url: "/get-sign-in-popup/",
		type: "GET",
		success:function(value) {
			if(value != '') {
				$(area_id).html(value);
			}
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
}

/**
 * Center screen plugin
 * 
 * Ex: $(element).center();
 */
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
}

function load_reviews(container, url) {
	var waiting = '<div class="bpv-update-wrapper">';
	waiting +='<div class="bpv-search-updating center-block" ><div class="ms1">Đang tải dữ liệu</div>';
	waiting +='<div class="ms2"><img style="margin-right:15px;" src="/media/icon/loading.gif"><span>Xin đợi trong giây lát...</span></div></div>';

	var div = $(waiting).appendTo('body');
	$(div).center();
	
	$.ajax({
		url: url,
		type: "GET",
		success:function(value) {
			$(div).remove();
			$(container).html(value);
		},
		error:function(var1, var2, var3){
			// do nothing
			$(div).remove();
		}
	});
}

function init_review_tab(container, is_mobile) {
	
	if(is_mobile == true && $(container).length) {
		
		var url = $(container).attr("data-url");
	  	
	  	$.ajax({
			url: url,
			type: "GET",
			success:function(value) {
				$(container).html(value);
			},
			error:function(var1, var2, var3){
				// do nothing
				$(div).remove();
			}
		});

	} else {
		$( container + ' a' ).click(function (e) {
			e.preventDefault();
		  
			var url = $(this).attr("data-url");
		  	var href = this.hash;
		  	var panel = $(this);
			
			// ajax load from data-url
			if(href == '#tab_reviews') {
				load_reviews(href, url);
			}
		});

		// store the currently selected tab in the hash value
	    /*$("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
	       var id = $(e.target).attr("href").substr(1);
	       window.location.hash = id;
	    });

	    // on load of the page: switch to the currently selected tab
	    var hash = window.location.hash;
		*/
		var hash = $('#tab').val();
	    if(hash == 'tab_reviews') {
	    	hash = '#'+hash;
	    	$(document).scrollTop( $(container).offset().top );
	    	
	    	$( container + ' a[href="'+hash+'"]' ).tab('show');
	    	
	    	var url = $('a[href="'+hash+'"]').attr("data-url");
	    	load_reviews(hash, url);
	    }
	}
}

function open_review(container) {
	$(document).scrollTop( $(container).offset().top );
	
	var hash = "#tab_reviews";
	
	$( container + ' a[href="' + hash + '"]' ).tab('show');
    if(hash == '#tab_reviews') {
    	var url = $('a[href="#tab_reviews"]').attr("data-url");
    	load_reviews(hash, url);
    }
}

/**
 * Toggle plugin
 * 
 * Ex: $(element).bpvToggle();
 */
jQuery.fn.bpvToggle = function (callback) {
	
	//$('.head').each(function(){
		
	//}
	$( this ).click(function(e) {
		// prevent the default action of the click event
	    // ie. prevent the browser from redirecting to the link's href
	    e.preventDefault();
	    
	    // 'target' is the execution context of the event handler
	    // it refers to the clicked target element
		var target = $(this).attr('data-target');

		// check exists
		if( $(target).length == 0 ) {
			return false;
		}
		
		if (typeof callback == 'function') { // make sure the callback is a function
	        callback.call(this, {id: target}); // brings the scope to the callback
	    }
		
		// Replace icons
		var icon = $( '.bpv-toggle-icon', $( this ));
		
		// Trigger the sliding animation on .content
		// The Animation Queues Up: .not(':animated')
		$(target).not(':animated').slideToggle("slow","swing", function(){

			if( $(icon).hasClass ('icon-arrow-right-white') ) {
				$(icon).toggleClass ('icon-arrow-right-white-up');
			}
			
			if( $(icon).hasClass ('icon-chevron-down') ) {
				$(icon).toggleClass ('icon-chevron-up');
			}
			
			if( $(icon).hasClass ('icon-arrow-right-sm') ) {
				$(icon).toggleClass ('icon-arrow-right-sm-down');
			}
		});
	});
}

/**
 * Show marketing popup
 * 
 * author: toanlk
 * update: 31 July 2014
 */
function get_marketing_popup() {
	
	$.ajax({
		url: "/get-marketing-popup/",
		type: "POST",
		cache: false,
		success:function(value) {
			if(value != '') {
				$('body').append(value);
				
				$(".popup-wrap").click(function(){
					$(".popup-bg").remove();
					$(".popup-wrap").remove();
				});
				
				$(".popup-close").click(function(){
					$(".popup-bg").remove();
					$(".popup-wrap").remove();
				});
			}
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
}

function get_marketing_box() {
	$.ajax({
		url: "/get-marketing-popup/",
		type: "POST",
		cache: false,
		data: {
			'cfg': 'marketing-more-people-more-save'
		},
		success:function(value) {
			if(value != '') {
				$('body').append(value);
				
				$(".mk-box-close").click(function(){
					$(".marketing-box").remove();
				});
			}
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
}

/**
 * Show destination/cruise/tour/ overview
 * Khuyenpv 
 * @param id
 * @param data_type
 */
function show_link_data_overview(id, data_type){
	
	if($('#data_overview').length > 0){
		
		$('#data_overview').modal();
		
		$('#data_overview_loading').show();
		
		$('#data_overview_content').hide();
		
		$.ajax({
			url: "/show-data-overview/",
			type: "POST",
			cache: false,
			data: {
				id: id,
				data_type: data_type
			},
			success:function(value) {
				$('#data_overview_loading').hide();
				$('#data_overview_content').html(value);
				$('#data_overview_content').show();
			},
			error:function(var1, var2, var3){
				$('#data_overview_content').html('<center>Lỗi kết nối dữ liệu!</center>');
				$('#data_overview_content').show();
			}
		});
		
	}
	
}

/**
 *	Tour 
 */
function set_up_tour_calendar(is_mobile){
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	var today = new Date();
	today = dateFormat(today);
	
	if($('#tour_departure_date').length > 0){
		
		set_up_calendar('#tour_departure_date', null, is_mobile);
		
	}
	
	var checkin_id = '#checkin_date';
	
	if($('#departure_id').length > 0) {
			
		$("#departure_id > option").each(function() {
			checkin_id = '#checkin_date_' + $(this).val();
			if($(checkin_id).length > 0) {
				set_up_calendar(checkin_id, null, is_mobile);
				
				$(checkin_id).change(function() {
					checkin_id = '#'+$(this).attr('id');
					get_check_out_date(checkin_id, '#stay_night', '#checkout_date', '#checkout_date_display');
				});
				
				get_check_out_date(checkin_id, '#stay_night', '#checkout_date', '#checkout_date_display');
			}
		});
	} else {
		if($(checkin_id).length > 0) {
			
			set_up_calendar(checkin_id, null, is_mobile);
			
			$(checkin_id).change(function() {
				get_check_out_date(checkin_id, '#stay_night', '#checkout_date', '#checkout_date_display');
			});
			
			get_check_out_date(checkin_id, '#stay_night', '#checkout_date', '#checkout_date_display');
		}
	}
	
	
	
	if($('#tour_start_date').length > 0){
		
		set_up_calendar('#tour_start_date', null, is_mobile);
		
	}
}

function set_up_tour_autocomplete(is_mobile){
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	// get destinations
	var destinations = new Bloodhound({
		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {url: '/suggest_tour_destinations/?query=%QUERY',},
	});

	destinations.initialize();
	
	var id = '#tour_destination';

	// instantiate the typeahead UI
	$( id ).typeahead({
		minLength: 2,
		highlight : true,
		hint : false 
	}, {
		displayKey: 'name',
		source : destinations.ttAdapter(),
		templates: {
			header: '<span class="lb-header">Quốc Gia/Thành Phố/Điểm Du Lịch</span>'
		}
	}).on("typeahead:selected", function($e, datum){
		// Save object id
		$('#tour_destination_input').val(datum['url_title']);
		$('#des_id').val(datum['id']);
		
		// store selected value
		$( id ).data("selected_value", $( id ).val());
		
		// add clear button
		if(!is_mobile) {
			add_clear_search(id);
		}
		
		// hide popover
		$(id).popover('hide');
	});
}

function validate_tour_search() {
	
	var id = '#tour_destination';
	
	if($.trim($(id).val()) == '') {
		alert('Xin vui lòng nhập Quốc Gia/Thành Phố/Điểm Du Lịch');
		$(id).focus();
		$(id).addClass('bpv-input-warning');
		
		return false;
	}
	
	return true;
}

function init_tour_search(get_search, is_mobile) {
	
	if (typeof is_mobile !== "undefined" && is_mobile) {
		is_mobile = true;
	} else {
		is_mobile = false;
	}
	
	if(get_search == undefined) {
		get_search = false;
	}
	
	if(get_search) {
		get_current_search(4); // MODULE = TOUR
	}
	
	var id = '#tour_destination';
	
	init_tour_date('#tour_departure_date', '', is_mobile);

	// Clear search value button
	if ($( id ).parent().find( ".search-choice-close" ).length == 0 && $( id ).val() != '' && !is_mobile){
		add_clear_search(id);
	}
	
	// Add clear button
	$( id ).blur(function() {
		if( $.trim($( id ).val()) != '' && !is_mobile) {
			add_clear_search(id);
		}
	});
	
	// select departing from
	$( "#dep_id" ).change(function() {
		if($( "#dep_id" ).val() != '') {
			$( "#departure" ).val($( "#dep_id option:selected" ).text());
		} else {
			$( "#departure" ).val('');
		}
	});
	
	// whenever change value then remove object id  and hide suggestion box
	$( id ).on('input',function(){
		if( $.trim($( id ).val()) != $( id ).data("selected_value") ) {
			$('#tour_destination_input').val('');
			$('#des_id').val('');
			
			$( ".search-choice-close" ).remove();
		}
		
		// hide popup
		$(id).popover('hide');
	})

	$( id ).popover({
		html: true,
		trigger: 'click',
		template: '<div class="popover suggestion-des tour-des-suggestion"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p></p></div></div></div>',
		content: $('#tour_des_suggestion').html(),
		placement: 'right'
	}).on('shown.bs.popover', function(e){
		
		$('.sg-des').click(function() {
			
			$( id ).val( $(this).attr('data-name') );
			$('.typeahead').typeahead('val', $(this).attr('data-name'));
			
			// Save object id
			$('#tour_destination_input').val($(this).attr('data-url-title'));
			$('#des_id').val($(this).attr('data-id'));
			
			// store selected value
			$( id ).data("selected_value", $( id ).val());
			
			// add clear button
			add_clear_search(id);

			// hide popup
			$(id).popover('hide');
			
			// cancel triger typeahead
			$('.typeahead').typeahead('close');
		});
		
		$('.group-name').bpvToggle();
	});
}

function init_tour_date(startdate_id, startdate_value, is_mobile){
	
	var today = new Date();
	
	if(startdate_value != ''){
		$(startdate_id).val(startdate_value);
	}
	
	var icon_calender_id = '#btn_' + startdate_id.replace('#','');
	
	// Handle event click icon calendar
	$(icon_calender_id).click(function () {
		$(startdate_id).focus();
	});
}

function get_hotline_box(display_on, on_sidebar) {
	$.ajax({
		url: "/get-hotline-box/",
		type: "POST",
		cache: false,
		data: {
			'display_on': display_on,
			'on_sidebar': on_sidebar,
		},
		success:function(value) {
			if(value != '') {
				$('#hotline_support_box').html(value);
			}
		},
		error:function(var1, var2, var3){
			// remove loading
			$('#hotline_support_box').html('');
		}
	});
}