function get_cruise_properties_deckplans(id, name){
	$.ajax({
		url: "cruise_detail/get_cruise_properties_deckplans/",
		type: "POST",
		cache: true,
		data: {	
			"id": id,
		},
		success:function(value){	
			$("#cruise_properties_deckplans").html(value);
			$('#lb_cruise_name').html(name);
		}
	});	
}

function get_videos(id) {
	$.ajax({
		url: "cruise_detail/get_videos/",
		type: "POST",
		cache: true,
		data: {	
			"id": id,					
		},
		success:function(value) {
			$("#cruise_videos").html(value);	
		}
	});	
}

function showVideo(video_id) {
	
	var img_id = "#video_" + video_id + "_img";

	var content_id = "#video_" + video_id + "_content";

	var src = $(img_id).attr("src");

	if (src.indexOf('btn_mini.gif') > 0){
		
		src = src.replace('btn_mini.gif', 'btn_mini_hover.gif');

		$(img_id).attr("src", src);

		$(content_id).show();
		
	} else {

		src = src.replace('btn_mini_hover.gif', 'btn_mini.gif');

		$(img_id).attr("src", src);

		$(content_id).hide();
	}
}

function get_tour_itinerary() {

	var url_title = $('#cruise_itineraries').val();
	console.log(url_title);
	
	show_loading_data();
	
	$.ajax({
		url: "/cruise_detail/get_itinerary/",
		type: "POST",
		cache: true,
		data: {'url_title' : url_title},
		success:function(value){
			$("#detail_tour_itinerary").html(value);
			show_loading_data(false);
		},
		error:function(var1, var2, var3){
			show_loading_data(false);
		}
	});	
}

