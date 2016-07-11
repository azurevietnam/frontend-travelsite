function show_review_tab() {
	$('#tab_tours a[href=#tab_reviews]').tab('show');
	$("html, body").animate({ scrollTop: $("#tab_reviews").offset().top}, "fast");
}

function init_tour_detail(is_mobile) {
	if (typeof is_mobile !== "undefined" && is_mobile) {
        is_mobile = true;
    } else {
        is_mobile = false;
    }
	
	$('.nav-itinerary').click(function() {
		$('#tab_tours a:first').tab('show');

		// set selected nav itinerary summary
		$('.nav-itinerary-pr').removeClass('active');
		$(this).parent().addClass('active');

		// scroll to itinerary content
		var id = $(this).attr('name');
		$("html, body").animate({ scrollTop: $("#"+id).offset().top}, "fast");

		// show content if it's invisible
		var content_id = "#"+id.replace('details', 'content');
		if( !$(content_id).is(':visible') ) {
			$(content_id).show();
			var icon = id.replace('details', 'icon');
			$("#"+icon).toggleClass('glyphicon-plus-sign glyphicon-minus-sign');
		}
	});

	// show review tab
	$('.review_link').click(function() {
		show_review_tab();
	});

	// show check rates tab
	$('.btn_book_tour').click(function() {
		if(is_mobile) {
			$('#tour_tabs a[href="#tab_check_rates"]').tab('show');
			$("html, body").animate({ scrollTop: $(".check-rate-form").offset().top}, "fast");
		} else {
			$('#tab_tours a[href=#tour_rate]').tab('show');
			$("html, body").animate({ scrollTop: $("#tour_rate").offset().top}, "fast");
		}
	});
	
	// show more itinerary highlight
	if ( $( "#btn_show_more_ih" ).length ) {
		$('#btn_show_more_ih').click(function(e){
	    	e.preventDefault();
	    	if(!$('.ih-row-more').is(':visible'))
	    	{
	    		$( "#btn_show_more_ih .pl-text" ).html($(this).attr('data-lang-less'));
	    		$('.ih-row-more').css('display', 'block');
	    	} else {
	    		$( "#btn_show_more_ih .pl-text" ).html($(this).attr('data-lang-more'));
	    		$('.ih-row-more').css('display', 'none');	
	    	}
	    });
	}
}

function hide_route_map(id) {
	$(id).not(':animated').slideToggle("slow","swing", function(){
		$('#itinerary_highlight_content').removeClass("col-xs-12").addClass("col-xs-8");
		$('#tour_map_small').show();
	});
}

function expand_route_map(id) {
	$(id).show();
	
	if(bpv_map != undefined && bpv_map_data != undefined) {
		
		render_marker(bpv_map, bpv_map_data);
		
		var center = bpv_map.getCenter();
	    google.maps.event.trigger(bpv_map, "resize");
	    bpv_map.setCenter(center);
	}

	$('#tour_map_small').hide();

    $('#itinerary_highlight_content').removeClass("col-xs-8").addClass("col-xs-12");
}