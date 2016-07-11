/**
 * Filter Search Results
 *
 * @author Khuyenpv
 * @since  Mar 13, 2015
 */

function filter_results(page){
	var search_params = $('#frm_hotel_search').serialize();

	//var filter_params = $('#frm_search_filters').serialize();
	//var ajax_url = search_params + '&' + filter_params;

    var ajax_url = search_params;
	if(page != undefined && page != ''){
		ajax_url = ajax_url + '&page=' + page;
	}

	ajax_url = 'hotel-ajax-search.html?' + ajax_url;

	$("html, body").animate({ scrollTop: 0 }, "fast");

	show_loading_data();

	$.ajax({

		cache: true,

   		url: ajax_url,

   		success: function(response_html, textStatus, jqXHR){
     		$("#hotel_search_results").html(response_html);
     		show_loading_data(false);
   		},

   		complete: function(){
   			apply_ajax_paging();
   		}
 	});
}

/**
 * Sort the search results
 *
 * @author Khuyenpv
 * @since  Mar 13, 2015
 */
function sort_by(sort_by){
	$('#hotel_sort_by').val(sort_by);
	filter_results();
}

/**
 * Apply Paging Click to call Ajax search
 *
 * @author Khuyenpv
 * @since  Mar 13, 2015
 */
function apply_ajax_paging(){
	$(".pagination a").click(function(event) {
		var page_link = $(this).attr("href");
		var link_arr = page_link.split('/');
		var page = link_arr[link_arr.length-1];

		filter_results(page);
		return false;
	});
}

/**
 * Clear the Search Filter
 *
 * @author Khuyenpv
 * @since  Mar 13, 2015
 */
function clear_filter(id){

	$('#'+id).attr('checked', false);

	if(id.indexOf('cruise_cabin') != -1){
		$('#cruise_cabin_0').prop('checked', true);
	}

	filter_results();
}

