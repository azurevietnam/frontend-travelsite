<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
	$start_date_id = '#arrival_day_check_rate_'.$hotel['id'];
	$start_month_id = '#arrival_month_check_rate_'.$hotel['id'];
	$departure_date_id = '#arrival_date_check_rate_'.$hotel['id'];
	$night_id = '#hotel_night_check_rate_'.$hotel['id'];
	$departure_day_display_id = '#departure_date_check_rate_display_'.$hotel['id'];
?>
			
<div style="float: left;width: 710px;">
	
	<div style="float: left; width: 710px;">
		<?=$check_rate_form?>
		
		<?=$check_rate_table?>
	</div>
	
	<div class="more_tour">
		<span class="arrow">&rsaquo;</span>
				
		<a target="_blank" href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>" class="link"><?=lang('hotel_view_full') ?></a>
	</div>
		
</div>

<script type="text/javascript">
	
	 // Create the tooltips only on document load
	$(document).ready(function() 
	{
		$("#btn_check_rate_<?=$hotel['id']?>").click(function() {

			var url ="<?=site_url('/hotelextrabooking/').'/'.$hotel['id'].'/'.$parent_id.'/'?>";	

			var id = '<?='hotel_'.$hotel['id']?>';
			
			var dataString = $("#frm_hotel_check_rate_<?=$hotel['id']?>").serialize();

			$('div#'+id).html('<div style="float: left;width:100%;text-align:center;"><img src="/media/loading-indicator.gif"></div>');
			
			$.ajax({
				url: url,
				type: "POST",
				data: dataString,
				success:function(value){
					$('div#'+id).html(value);
				}
			});
			
		});

		var this_date = '<?=date('d-m-Y')?>';

		var current_date = '<?=date('d-m-Y', strtotime($search_criteria['arrival_date']))?>';

		initDate(this_date, current_date, '<?=$start_date_id?>','<?=$start_month_id?>', '<?=$departure_date_id?>', '<?=$night_id?>', '<?=$departure_day_display_id?>');

		
		var img = '<?=lang('extra_bed_help')?>';
		
		$("span[name='info']").tipsy({fallback: img, gravity: 's', html: true, width: '250px'});	
		
		
		$("#btn_book_<?=$hotel['id']?>").click(function() {

			if (checkRoomTypeBooking('<?=$hotel['id']?>')){
				
				var url ="/hotelreservation/<?=$hotel['id']?>/<?=$parent_id?>/";	

				var id = '<?='hotel_'.$hotel['id']?>';
				
				var dataString = $("#frm_hotel_reservation_<?=$hotel['id']?>").serialize();

				$('div#'+id).html('<div style="float: left;width:100%;text-align:center;"><img src="/media/loading-indicator.gif"></div>');
				
				$.ajax({
					url: url,
					type: "POST",
					data: dataString,
					success:function(value){
						//$('div#'+id).html(value);
						window.location.href = window.location.href;
					}
				});

			} else {
				$("#booking_warning_<?=$hotel['id']?>").show();
			}
		});
		
	});
</script>
