<div id="contentLeft">	
	
	<!-- Search Form -->
	<?=$tour_search_view?>
	
	<?php if(isset($filter_results)):?>
	<!-- Search Filter-->
	<?=$filter_results?>
	<?php endif;?>
	
    <!-- Why Use -->
    <?=$why_use?>

	<!-- Top Destination -->
	<?=$topDestinations?>
	
	
	<div id="tour_faq">
		<?=$faq_context?>
	</div>
</div>
<div id="contentMain">
<?=$contentMain?>
</div>


<div id="loading_data" style="display:none;"><b><?=lang('process_data')?></b></div>

<div id="overlay_popup" onclick="close_popup()" class="overlay_popup"></div>
	
<div id="popup_container" class="popup_container">

<span onclick="close_popup()" class="icon btn-popup-close"></span>

<div class="popup_content" id="popup_content">

	<center><img alt="" src="<?=get_static_resources('/media/loading-indicator.gif')?>"></center>

</div>

</div>


<script type="text/javascript">

function sort_By(sort_by){
	$("#loading_data").css("display", "");

	var str_filter_data = $('#frm_search_filter').serialize();
	
	$.ajax({
   		type: "POST",
   		cache: true,
   		url: "<?=site_url('/tour_search/sort/').'/'?>",
    	data: "sort_by=" + sort_by + '&'+str_filter_data,
   		success: function(responseText){
     		$("#contentMain").html(responseText);
   		},
   		complete: function(){
   			$("#loading_data").css("display", "none");
   			applyPagination();
   		} 
 	});
}

function applyPagination() {
	$("#ajax_paging a").click(function() {

	$("html, body").animate({ scrollTop: 0 }, "fast");
	
	$('#loading_data').show();

	var str_filter_data = $('#frm_search_filter').serialize();
	
	var url = $(this).attr("href") + "/";
	
	$.ajax({
			type: "POST",
			data: "ajax=1&" + str_filter_data,
			url: url,
			beforeSend: function() {
				//$("#contentMain").html("");
			},
			success: function(msg) {
				$("#contentMain").html(msg);
				applyPagination();
				$('#loading_data').hide();
			}
		});
		
		return false;
	});
}

$(document).ready(function(){	
	applyPagination();
});

</script>