/**
 * -------------------------------------------------------------------------------------
 * Begin of Booking Functions
 * -------------------------------------------------------------------------------------
 */

var CURRENCY_SYMBOL = '$';
var lang_na = 'N/A';

/**
 * Get Price From $price text
 * 
 * @author Khuyenpv
 * @since 02.04.2015
 */
function getPriceNumber(price_text){
	price_text = price_text.replace("$","");
	price_text = $.trim(price_text);
	return getFormatNumber(price_text);
}

/**
 * Format String to Number
 * 
 * @author Khuyenpv
 * @since 02.04.2015
 */
function getFormatNumber(text) {
	text = text.replace(",","");
	return Number(text);
}

/**
 * Show-hide the tour-boooking-items
 * 
 * @author Khuyenpv
 * @since 01.04.2015
 */
function show_booking(rowid){
	
	var img_id = '#' + rowid + "_img_booking";

	var booking_content_id = '#' + rowid + "_booking_content";

	var booking_total_id = '#' + rowid + "_booking_total";

	var src = $(img_id).attr("src"); 

	if (src == "/media/btn_mini.gif"){

		src = "/media/btn_mini_hover.gif";

		$(img_id).attr("src", src);

		$(booking_content_id).show();

		$(booking_total_id).hide();
		
	} else {

		src = "/media/btn_mini.gif";

		$(img_id).attr("src", src);

		$(booking_content_id).hide();

		$(booking_total_id).show();
	}
}

/**
 * Count total accommodation of the booking
 * 
 * @author Khuyenpv
 * @since 02.04.2015
 */
function count_total_booking(parent_rowid){

	//alert('gohere 1');
	var total_accomodation = $('#' + parent_rowid + '_total_accommodation').val();

	total_accomodation = getFormatNumber(total_accomodation);
	//alert('gohere 2');
	$('input[name="' + parent_rowid + '_optional_services[]"]').each(function() {
		
		var price = $(this).val();
		
		if($(this).is(':checked')){
			
			total_accomodation = total_accomodation + getFormatNumber(price);
		} 
	});
	//alert('gohere 3');

	return total_accomodation;
}

/**
 * Select an Optional Service
 * 
 * @author Khuyenpv
 * @since 02.04.2015
 */
function select_optional_service(obj, parent_rowid, service_id, amount){

	var select_optional_service_id = '#'+ parent_rowid + '_' + service_id + '_selected';
	
	var selected = $(obj).is(':checked') ? '1' : '0';

	$(select_optional_service_id).val(selected);

	temporary_select_optional_service(obj, parent_rowid, service_id);
	
	update_optional_total(parent_rowid, service_id, amount, selected);

	update_booking_total();
	
}

/**
 * Temporary select Optional Service on Tour-Booking page
 * 
 * @author Khuyenpv
 * @since 02.04.2015
 */
function temporary_select_optional_service(obj, parent_rowid, service_id){
	
	var selected = $(obj).is(':checked') ? '1' : '0';

	var optional_unit_id = '#' + parent_rowid + '_' + service_id + '_unit';
	
	var unit = $(optional_unit_id + ' option:selected').val();

	if (unit == '' || unit == undefined){
		unit = 0;
	} else {		
		unit = getPriceNumber(unit);	
	}
	
	$.ajax({
		url: '/addoptionalservice/',
		type: "POST",
		data: {parent_rowid: parent_rowid, service_id: service_id,  unit: unit, selected: selected},
		success:function(value){
			//alert(value);
		}
	});
	
}

/**
 * Select the unit of Extra Services
 * 
 * @author Khuyepv
 * @since 02.04.2015
 */
function select_unit_extra_service(parent_rowid, service_id, rate){

	var optional_total_id = '#' + parent_rowid + '_' + service_id + '_total';

	var optional_unit_id = '#' + parent_rowid + '_' + service_id + '_unit';

	var checkbox_id = parent_rowid + '_' + service_id + '_checkbox';

	
	var unit = $(optional_unit_id + ' option:selected').val();

	unit = getPriceNumber(unit);

	var rate_number = getPriceNumber(rate);

	var new_amount = unit * rate_number;

	$('#'+checkbox_id).val(Math.round(new_amount));

	if (new_amount == 0){
		$(optional_total_id).text(i18n.free);
	} else {	
		$(optional_total_id).text(CURRENCY_SYMBOL + new_amount);
	}

	
	var obj = document.getElementById(checkbox_id);

	select_optional_service(obj, parent_rowid, service_id, new_amount);
	
}

/**
 * Update the total price of the optional service
 * 
 * @author Khuyenpv
 * @since 02.04.2015
 */
function update_optional_total(parent_rowid, service_id, amount, selected){
	
	var optional_total_id = '#' + parent_rowid + '_' + service_id + '_total';

	var booking_total_display_id = '#' + parent_rowid + '_total_display';

	var booking_total_hide_id = '#' + parent_rowid + '_booking_total';  

	var optional_unit_id = '#' + parent_rowid + '_' + service_id + '_unit';
	
	if (selected == '1'){
		
		$(optional_total_id).addClass('text-price');

		$(optional_unit_id).removeAttr('disabled');

	} else {

		$(optional_total_id).removeClass('text-price');

		$(optional_unit_id).attr('disabled', 'disabled');
	}

	var booking_total = count_total_booking(parent_rowid);

	$(booking_total_display_id).text(CURRENCY_SYMBOL + booking_total);

	$(booking_total_hide_id).text(CURRENCY_SYMBOL + booking_total);  
}

/**
 * Update the total booking price
 * 
 * @author Khuyenpv
 * @since 02.04.2015
 */
function update_booking_total(){

	var total = 0;
	
	$('.booking-items').each(function(){
		
		var parent_rowid = $(this).attr('rowid');

		var booking_total_display_id = '#' + parent_rowid + '_total_display'; 

		var booking_total_hide_id = '#' + parent_rowid + '_booking_total';
		
		var booking_total = count_total_booking(parent_rowid);

		if (booking_total > 0){
		
			$(booking_total_display_id).text(CURRENCY_SYMBOL + booking_total); 
	
			$(booking_total_hide_id).text(CURRENCY_SYMBOL + booking_total);

		} else {  

			$(booking_total_display_id).text(lang_na); 
			
			$(booking_total_hide_id).text(lang_na);
		}
		
		total = total + booking_total;
		
	});

	var discount = $('#discount_booking_together').val();

	if (discount == '' || discount == undefined) {discount = 0;} else{discount = getFormatNumber(discount);}

	var final_total = total - discount;

	if (total > 0){
		$('#total_book_seperate').text(CURRENCY_SYMBOL + total); 
	} else {
		$('#total_book_seperate').text(lang_na);
	}

	if (final_total > 0){
		
		$('#final_total').text(CURRENCY_SYMBOL + final_total);
	} else {
		$('#final_total').text(lang_na);
	}
}

/*** ----------- BOOK TOGETHER FUNCTIONS ---------------------***/

/**
 * User click on a date hotel selection date
 * @author Khuyenpv
 * @since 17.04.2015
 */
function set_date_selected(){
	$('.hotel-date-table input').each(function(){
		if($(this).is(':checked')){
			$(this).parent().addClass('selected');
		} else {
			$(this).parent().removeClass('selected');
		}
	});
}

/**
 * Check if hotel dates are selected
 * 
 * @author Khuyenpv
 * @since 27.06.2015
 */
function is_valid_hotel_date_selected(){
	
	var is_date_seleted = false;
	
	$('.hotel-date-table input').each(function(){
		if($(this).is(':checked')){
			is_date_seleted = true;
			return;
		} 
	});

	if(!is_date_seleted){
		$('#hotel_error').show();
	} else {
		$('#hotel_error').hide();
	}
	
	return is_date_seleted;
}


/**
 * User change to tour-date
 * @author Khuyenpv
 * @since 17.04.2015
 */
function change_hotel_selection_date(date_id, night_nr){
	var today = new Date();
	today = date_to_str(today);
	today = str_to_date(today);

	var tour_start_date = str_to_date($(date_id).val());
	var tour_end_date = str_to_date($(date_id).val());

	if(night_nr  <= 1){
		tour_end_date.setDate(tour_end_date.getDate());
		$('#h_label_' + 0).text(tour_start_date.getDate());
	}
	else{
		tour_end_date.setDate(tour_end_date.getDate() + night_nr - 1);
		$('#h_label_' + 0).text(tour_start_date.getDate() + ' - ' +  tour_end_date.getDate());
	}
	
	var start_date = str_to_date($(date_id).val());	
	for(var i = -1; i >= -19; i--){	
		start_date.setDate(start_date.getDate() -1);
		if (i == -5)		{ h_month_pre_5 = start_date;}
		else if (i == -6)	{ h_month_pre_6 = start_date;}
		else if (i == -19)	{ h_month_pre_19 = start_date;}
		var day = date_to_str(start_date);
		$('#h_day_' + i + ' input').val(day);
		if(start_date < today){
			$('#h_day_' + i + ' input').attr('disabled', 'disabled');
		} else {
			$('#h_day_' + i + ' input').removeAttr('disabled');
		}
		
		$('#h_label_' + i).text(start_date.getDate());	
	}	
	
	var start_date = str_to_date($(date_id).val());
	for(var i = 1; i <= 19; i++){
		start_date.setDate(start_date.getDate() + 1);
		var day = date_to_str(start_date);
		$('#h_day_' + i + ' input').val(day);
		if(start_date < today){
			$('#h_day_' + i + ' input').attr('disabled', 'disabled');
		} else {
			$('#h_day_' + i + ' input').removeAttr('disabled');
		}
		
		$('#h_label_' + i).text(start_date.getDate());
		if (i == 5){ h_month_nex_5 = start_date;}
		else if (i == 6){ h_month_nex_6 = start_date;}
		else if (i == 19){ h_month_nex_19 = start_date;}
	}
	
	for(var i = 0; i <= i18n.month_names.length; i++){
		if (i == h_month_pre_5.getMonth())	{ $('#h_month_-5').text(i18n.month_names[i] + ' ' + h_month_nex_6.getFullYear()); }
		if (i == h_month_pre_6.getMonth())	{ $('#h_month_-6').text(i18n.month_names[i] + ' ' + h_month_nex_6.getFullYear()); }
		if (i == h_month_pre_19.getMonth()) { $('#h_month_-19').text(i18n.month_names[i] + ' ' + h_month_nex_6.getFullYear()); }
		if (i == h_month_nex_6.getMonth())	{ $('#h_month_5').text(i18n.month_names[i] + ' ' + h_month_nex_6.getFullYear()); }
		if (i == h_month_nex_19.getMonth()) { $('#h_month_6').text(i18n.month_names[i] + ' ' + h_month_nex_6.getFullYear()); }
		if (i == h_month_nex_6.getMonth())	{ $('#h_month_19').text( i18n.month_names[i] + ' ' + h_month_nex_6.getFullYear()); }
	}
	
}
