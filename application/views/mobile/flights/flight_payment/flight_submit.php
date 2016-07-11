<?php if(empty($flight_booking) || $flight_booking['is_unavailable'] || isset($submit_status_nr)):?>
	<div style="padding:10px;background-color:#eee">
		<div style="margin-bottom:10px">
			<?php if(isset($submit_status_nr)):?>
				
				<?php if($submit_status_nr == -1):?>
					<?=lang('flight_payment_fare_changed')?>
				<?php else:?>
					<?=lang('flight_payment_fail_to_connect')?>
				<?php endif;?>
				
			<?php else:?>
				<?=lang('flight_payment_session_timeout')?>
			<?php endif;?>
		</div>
		<a style="text-decoration:underline;" href="<?=get_current_flight_search_url($search_criteria)?>"><?=lang('flight_search_again')?></a>
	</div>

<?php else:?>
<div>
	<div class="container margin-bottom-15" id="passenger_area">
			
		<div class="margin-bottom-10">
			<?=$booking_steps?>
			<?//=$flight_review_booking?>
		</div>	
		
		<div class="margin-bottom-10">
			<?=$flight_summary?>
			<?//=$flight_booking_payment?>
		</div>	

		<?=$contact_form?>
		
	</div>
</div>	
	
	<div class="modal fade" id="flight_itinerary" tabindex="-1" role="dialog" aria-labelledby="label_flight_details" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-room" style="width: 61.6398243045388%;">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span>X</button>
	        <h2 class="modal-title text-highlight" id="label_flight_details"><?=lang('flight_itineray')?></h2>
	      </div>
	      <div class="modal-body">
	      		<form id="frm_itinerary" name="frm_itinerary" method="post" action="<?=get_page_url(FLIGHT_DETAIL)?>?sid=<?=$sid?>">
				<input type="hidden" value="change-itinerary" name="action">			
				<?=$flight_itinerary?>
			</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-blue btn-default" data-dismiss="modal">OK</button>
	      </div>
	    </div>
	  </div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="flight_passengers" tabindex="-1" role="dialog" aria-labelledby="label_flight_passengers" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-room" style="width:850px;">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
	        <h2 class="modal-title text-highlight" id="label_flight_passengers"><?=lang('change_passenger')?></h2>
	      </div>
	      <div class="modal-body">
	      	
	      	<form id="frm_passenger" name="frm_passenger" method="post" action="<?=get_page_url(FLIGHT_DETAIL)?>?sid=<?=$sid?>">
				<input type="hidden" value="change-passenger" name="action">
				<?=$flight_passenger?>
			</form>
			
	      	
	      </div>
	      <div class="modal-footer" style="padding-bottom:15px">
	      	<button type="button" class="btn btn-blue btn-default" onclick="apply_changes()"><?=lang('apply_changes')?></button>
	      	
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('cancel_changes')?></button>
	      </div>
	    </div>
	  </div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="submit_data_waiting" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="label_submit_data_waiting" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-room">
	    <div class="modal-content">
	      
	       <?=load_search_waiting(lang('process_flight_booking'))?>
	    </div>
	  </div>
	</div>

<?php endif;?>

<script type="text/javascript">
	
	function apply_changes(){

		if(validate_passengers() && validate_chd_inf_birthday(<?=$search_criteria['CHD']?>, <?=$search_criteria['INF']?>, '<?=$search_criteria['Depart']?>')){

			$('#frm_passenger').submit();
		}
		
	}
	
	$('button[name="action"]').click(function(){
		if($("#submit_data_waiting").length > 0){
			$('#submit_data_waiting').modal();
		}
	});

	
</script>