function click_book_together(url_title_1, url_title_2, mode){
	window.location.href = '/book-together/' + url_title_1 + '/' + url_title_2 + '/' + mode + '/';
}

/**
 * Show A Block of Service Recommendation
 * 
 * @author Khuyenpv
 * @since 04.04.2015
 */
function show_block(obj, block_id){

	var block_search_content_id = '#block_search_content_' + block_id;

	var show_more_id = '#show_more_' + block_id;
	
	var block_class = $(obj).attr('show');

	//alert(block_class);
	
	if (block_class == 'hide'){

		$(obj).attr('show','show');
		
		$(block_search_content_id).show();

		$(show_more_id).show();
		
	} else {

		$(obj).attr('show','hide');	
		
		$(block_search_content_id).hide();

		$(show_more_id).hide();
	}
}

/**
 * Show each service Recommendation
 * 
 * @author Khuyenpv
 * @since 04.04.2015
 */
function show_service(id, url){
	
	var img_id = '#' + id + "_img_collapse";

	var src = $(img_id).attr("src"); 

	if (src == '/media/btn_mini.gif'){
		
		src = '/media/btn_mini_hover.gif';

		$(img_id).attr("src", src);

		$('div#'+id).show();

		var loaded = $('div#'+id).attr("load");

		if (loaded != "loaded"){
			
			show_loading_data(true, 'div#'+id);
			
			$.ajax({
				url: url,
				type: "POST",
				data: '',
				success:function(value){
					$('div#'+id).html(value);
					$('div#'+id).attr("load","loaded");
					
					show_loading_data(false);
				}
			});

		}

		$('#'+ id + '_button_book').hide();

		$('.plus_icon_'+ id).show();
	} else {

		src = '/media/btn_mini.gif';

		$(img_id).attr("src", src);

		$('div#'+id).hide();

		$('#'+ id + '_button_book').show();
		
	}
}

/**
 * Search More Service Recommendations
 * 
 * @author Khuyenpv
 * @since 04.04.2015
 */ 

function search_more(block_id, url){
	
	// go to the recommendation position first
	go_position("#block_recommendation_" + block_id);
	
	if ($('#destination_id_'+block_id).length > 0){ // only check if the destination_id field exits
		
		if($('#hotel_id_'+block_id).length > 0){ // if search for the hotel
			
			var destination_id = $('#destination_id_'+block_id).val();
			
			var hotel_id = $('#hotel_id_'+block_id).val();
			
			if (destination_id == '' && hotel_id == ''){
				alert(i18n.search_destination_required);
				$("#destination_"+block_id).focus();
				$("#destination_"+block_id).addClass('input-error');
				return false;
			}
			
		} else {
			
			var destination_id = $('#destination_id_'+block_id).val();
			if (destination_id == ''){
				alert(i18n.search_destination_required);
				$("#destination_"+block_id).focus();
				$("#destination_"+block_id).addClass('input-error');
				return false;
			}
			
		}
	}

	if (url == undefined || url == ''){	
		url = $("#form_" + block_id).attr('action');
	}
	
	var dataString = $("#form_" + block_id).serialize();
	
	var block_search_content_id = '#block_search_content_' + block_id;
	
	var block_search_result = '#block_search_result_' + block_id;
	
	if ($(block_search_result).length > 0){
		$(block_search_result).html('');
		show_loading_data(true, block_search_result);
	} else {
		$(block_search_content_id).html('');
		show_loading_data(true, block_search_content_id);
	}
	
	$.ajax({

		url: url,

		type: "POST",

		data: dataString,
		
		success:function(value){
			
			$(block_search_content_id).html(value);
			
		}
	});

}

/**
 * Set auto-complete for Quick Tour Search Form
 * 
 * @author Khuyenpv
 * @since 04.04.2015
 */
function set_quick_search_des_auto(block_id, service_type){
	
	if (service_type == 'tour'){
		
		var destinations = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '/tour-des-auto-prefetch/tour-des-auto.json',
			remote: '/tour-des-auto-remote/%QUERY.json'
		});
		
	} else {
		
		var destinations = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '/hotel-des-auto-prefetch/hotel-des-auto.json',
			remote: '/hotel-des-auto-remote/%QUERY.json'
		});
	}
		 
	destinations.initialize();
		 
	$('#destination_' + block_id).typeahead({
		minLength: 2,
		highlight : true,
		hint : true,
		autoselect: true
	}, {
		name: 'destination',
		displayKey: 'name',
		source: destinations.ttAdapter()
	}).on("typeahead:selected", function($e, datum){
		//alert('go here 2');
		
		if(datum.is_hotel != undefined){ // select the hotel
			$('#hotel_id_'+block_id).val(datum.id);
			$('#destination_id_'+block_id).val('');
		} else {
			$('#hotel_id_'+block_id).val('');
			$('#destination_id_'+block_id).val(datum.id); // select the destination
		}
		
		
	}).on("typeahead:autocompleted", function($e, datum){
		//alert('go here');
		$('.tt-dataset-destination .tt-suggestions .tt-suggestion').first().addClass('tt-cursor');
	}).on("keyup", function(e){
		if(e.keyCode != 13){
			
			$('#destination_' + block_id).removeClass('input-error');
			// remove destination id value
			$('#destination_id_'+block_id).val('');
			$('#hotel_id_'+block_id).val('');
		}
	});	
}

/**
 * User click on Sort-By on Quick Search
 * 
 * @author Khuyenpv
 * @since 04.04.2015
 */
function bt_sort_by(block_id, sort_value){
	
	$('#sort_by_' + block_id).val(sort_value);
	
	search_more(block_id);
}

/**
 * Call Ajax when click on paging
 * 
 * @author Khuyenpv
 * @since 05.04.2015
 */
function recommend_more_ajax_paging(block_id) {
	
	$("#ajax_pagination_" + block_id + " a").click(function() {
		
		var url = $(this).attr("href") + "/";
		
		search_more(block_id, url);

		return false;
	
	});
}

/**
 * User click on Book_In on Extra-booking Services
 * 
 * @author Khuyenpv
 * @since 07.04.2015
 */
function book_it(form_id, area_id, service_type, submit_btn, hotel_id){
	
	var url = $(form_id).attr('action');	
	
	var dataString = $(form_id).serialize();
	
	if (service_type == 'tour'){
		var acc_selected = $(submit_btn).attr('name') + '=' + $(submit_btn).attr('value');
		dataString = dataString + '&' + acc_selected;
	}
	
	if (service_type == 'tour' || validate_hotel_room_selection(hotel_id)){

		$(area_id).html('');
		show_loading_data(true, area_id);
		
		$.ajax({
			url: url,
			type: "GET",
			data: dataString,
			success:function(value){
				window.location.href = window.location.href;
			}
		});
		
	}
	
	return false;
}

/**
 * Check if the number of room selected > 0
 * 
 * @author Khuyenpv
 * @since 07.04.2015
 */
function validate_hotel_room_selection(hotel_id){
	var ret = false;
	var room_selects = '.room_select_' + hotel_id;
	$(room_selects).each(function(){
		if($(this).val() != '0'){
			ret = true;
		}
	});
	
	if(!ret){
		$('#booking_warning_' + hotel_id).show();
	} else{
		$('#booking_warning_' + hotel_id).hide();
	}
	
	return ret;
}

/**
 * User click on See-More-Deals on Search Tour Page
 * 
 * @author Khuyenpv
 * @since 13.04.2015
 */
function see_more_deals(tour_id, tour_name, departure_date){
	
	$('#see_more_deal').modal();
	
	$("#see_more_deal_cnt").html('');
	
	$('#see_more_deal_tour_name').text(tour_name);
	
	show_loading_data(true, '#see_more_deal_cnt');
	
	$.ajax({
		url: "/ajax/tour_ajax/see_more_deals/",
		type: "POST",
		cache: true,
		data: {
			"tour_id":tour_id,
			"departure_date":departure_date					
		},
		success:function(value){
			$("#see_more_deal .modal-body").html(value);
			show_loading_data(false);
		}
	});	
}