<div class="bpt-col-right pull-right" id="hotel_search_results">
	<?=$search_results?>
</div>
<div class="bpt-col-left pull-left">

	<?=$hotel_search_overview?>

	<?=$hotel_search_form?>

    <?=$hotel_destinations?>

	<?=$faq_by_page?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		apply_ajax_paging();
	});
</script>

