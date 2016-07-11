/**
 * Functions for Tour/Check Rates & Booking
 * 
 * @author Khuyenpv
 * @since  Mar 17, 2015
 */

/**
 * --------------------------------------------------------------
 * BEGIN FUNCTIONS FOR TOUR CHECK-RATES
 * --------------------------------------------------------------
 */

function re_arrange_cabin(tour_id){
	$('#re_arrange_cabin_' + tour_id).show();
	$('#re_arrange_cabin_text_' + tour_id).hide();
	$('#re_arrange_cabin_guide_' + tour_id).hide();
}

function hide_re_arrange_cabin(tour_id){
	$('#re_arrange_cabin_' + tour_id).hide();
	$('#re_arrange_cabin_text_' + tour_id).show();
	$('#re_arrange_cabin_guide_' + tour_id).show();
}

/**
 * Change the number of cabin on Cabin Arrangement Manually
 * 
 * @author Khuyenpv
 * @since March 17 2015
 */
function change_cabin(tour_id, cabin_limit){

	var num_cabin = $("#num_cabin_" + tour_id + " option:selected").val();
	
	for (var i = 1; i <= cabin_limit; i++){

		var cabin_id = '#' + tour_id + '_cabin_' + i;

		if (i <= num_cabin){
			$(cabin_id).show();
		} else {
			$(cabin_id).hide();
		}
	
	}
	
	object_change_info('change_cabin', tour_id);
}

/**
 * Validate the Cabin Arrangement Input before check rate
 * 
 * @author Khuyenpv
 * @since March 17 2015
 */
function check_error_check_rates(tour_id, cabin_limit){

	var is_error = false;

	var object_change = $("#object_change_" + tour_id).val();
	

	if (object_change == 'change_cabin'){
	
		var num_cabin = $("#num_cabin_" + tour_id + " option:selected").val();
		
		for (var i = 0; i <= cabin_limit; i++){
			$("#" + tour_id + "_type_" + i).prop('name', '');
			$("#" + tour_id + "_adults_" + i).prop('name', '');
			$("#" + tour_id + "_children_" + i).prop('name', '');
			$("#" + tour_id + "_infants_" + i).prop('name', '');
		}
		
		
		for (var i = 1; i <= num_cabin; i++){
			
			$("#" + tour_id + "_type_" + i).prop('name', tour_id + '_type_'+i);
			$("#" + tour_id + "_adults_" + i).prop('name',  tour_id + '_adults_' + i);
			$("#" + tour_id + "_children_" + i).prop('name',  tour_id + '_children_' + i);
			$("#" + tour_id + "_infants_" + i).prop('name',  tour_id + '_infants_' + i);

			var type = parseInt($("#" + tour_id + "_type_" + i + " option:selected").val());
			
			var adults = parseInt($("#" + tour_id + "_adults_" + i + " option:selected").val());

			var children = parseInt($("#" + tour_id + "_children_" + i + " option:selected").val());

			var infants = parseInt($("#" + tour_id + "_infants_" + i + " option:selected").val());
			
			// default: hide all the error message
			$("#" + tour_id + "_errors_" + i).hide();
			$("#" + tour_id + "_errors_" + i + "_1").hide();
			$("#" + tour_id + "_errors_" + i + "_2").hide();
			$("#" + tour_id + "_errors_" + i + "_3").hide();
			
			//alert(adults);

			if (adults + children + infants > 3){
				$("#" + tour_id + "_errors_" + i).show();
				$("#" + tour_id + "_errors_" + i + "_1").show();
				is_error = true;

				//break;
			} else 

			if (adults + children == 0){
				$("#" + tour_id + "_errors_" + i).show();
				$("#" + tour_id + "_errors_" + i + "_2").show();
				is_error = true;

				//break;
				
			} else 

			if (adults + children != 1 && type == 3){

				$("#" + tour_id + "_errors_" + i).show();
				$("#" + tour_id + "_errors_" + i + "_3").show();
			
				is_error = true;

				//break;
				
			}
		
		}

	}

	return is_error;
	
}

/**
 * Update the number of Customer when Rearrange Cabin
 * 
 * @author Khuyenpv
 * @since March 17 2015
 */
function object_change_info(value, tour_id){
	
	$('#object_change_' + tour_id).val(value);

	var object_change = $("#object_change_" + tour_id).val();

	if (object_change == 'change_cabin'){
		
		var num_cabin = $("#num_cabin_" + tour_id + " option:selected").val();

		var adults = 0;

		var children = 0;

		var infants = 0;
		
		for (var i = 1; i <= num_cabin; i++){

			adults = adults + parseInt($("#" + tour_id + "_adults_" + i + " option:selected").val());

			children = children + parseInt($("#" + tour_id + "_children_" + i + " option:selected").val());

			infants = infants + parseInt($("#" + tour_id + "_infants_" + i + " option:selected").val());

		}

		$('#adults_' + tour_id+ ' option[value=' + adults + ']').attr('selected', 'selected');

		$('#children_' + tour_id+ ' option[value=' + children + ']').attr('selected', 'selected');

		$('#infants_' + tour_id+ ' option[value=' + infants + ']').attr('selected', 'selected');

	}
}

