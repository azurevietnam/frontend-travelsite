function load_bpv_reviews(container, url) {
	show_loading_data();
	
	$.ajax({
		url: url,
		type: "GET",
		success:function(value) {
			show_loading_data(false);
			$(container).html(value);
			$("html, body").animate({ scrollTop: $(".reviews-panel").offset().top}, "fast");
		},
		error:function(var1, var2, var3){
			// do nothing
			show_loading_data(false);
		}
	});
}

function read_more(id){
	$('#'+id+'_short').hide();
	$('#'+id+'_full').show();
}

function read_less(id){
	$('#'+id+'_short').show();
	$('#'+id+'_full').hide();
}