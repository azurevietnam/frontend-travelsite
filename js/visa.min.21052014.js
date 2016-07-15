var RATE_TABLE = [{"id":"1","country":["2","5","6","7","10","11","16","17","19","21","24","25","27","29","31","33","37","39","41","45","47","48","55","59","60","65","67","78","83","84","85","86","87","93","95","96","97","98","102","106","108","120","121","123","124","127","128","131","134","139","140","145","148","151","163","166","168","169","170","172","173","174"],"price":{"1":[{"p":"12","up":"10","q":"1","d":"5"},{"p":"12","up":"10","q":"2","d":"5"},{"p":"12","up":"10","q":"3","d":"5"},{"p":"12","up":"10","q":"4","d":"5"},{"p":"12","up":"10","q":"5","d":"5"},{"p":"12","up":"10","q":"6","d":"5"},{"p":"12","up":"10","q":"7","d":"5"},{"p":"12","up":"10","q":"8","d":"5"},{"p":"12","up":"10","q":"9","d":"5"},{"p":"12","up":"10","q":"10","d":"5"}],"2":[{"p":"25","up":"10","q":"1","d":"5"},{"p":"25","up":"10","q":"2","d":"5"},{"p":"25","up":"10","q":"3","d":"5"},{"p":"25","up":"10","q":"4","d":"5"},{"p":"25","up":"10","q":"5","d":"5"},{"p":"25","up":"10","q":"6","d":"5"},{"p":"25","up":"10","q":"7","d":"5"},{"p":"25","up":"10","q":"8","d":"5"},{"p":"25","up":"10","q":"9","d":"5"},{"p":"25","up":"10","q":"10","d":"5"}],"3":[{"p":"20","up":"10","q":"1","d":"5"},{"p":"20","up":"10","q":"2","d":"5"},{"p":"20","up":"10","q":"3","d":"5"},{"p":"18","up":"10","q":"4","d":"5"},{"p":"18","up":"10","q":"5","d":"5"},{"p":"16","up":"10","q":"6","d":"5"},{"p":"16","up":"10","q":"7","d":"5"},{"p":"16","up":"10","q":"8","d":"5"},{"p":"16","up":"10","q":"9","d":"5"},{"p":"16","up":"10","q":"10","d":"5"}],"4":[{"p":"40","up":"10","q":"1","d":"5"},{"p":"40","up":"10","q":"2","d":"5"},{"p":"40","up":"10","q":"3","d":"5"},{"p":"38","up":"10","q":"4","d":"5"},{"p":"38","up":"10","q":"5","d":"5"},{"p":"36","up":"10","q":"6","d":"5"},{"p":"36","up":"10","q":"7","d":"5"},{"p":"36","up":"10","q":"8","d":"5"},{"p":"36","up":"10","q":"9","d":"5"},{"p":"36","up":"10","q":"10","d":"5"}]}},{"id":"3","country":["26","61","66","143","153"],"price":{"1":[{"p":"25","up":"20","q":"1","d":"5"},{"p":"25","up":"20","q":"2","d":"5"},{"p":"25","up":"20","q":"3","d":"5"},{"p":"25","up":"20","q":"4","d":"5"},{"p":"25","up":"20","q":"5","d":"5"},{"p":"25","up":"20","q":"6","d":"5"},{"p":"25","up":"20","q":"7","d":"5"},{"p":"25","up":"20","q":"8","d":"5"},{"p":"25","up":"20","q":"9","d":"5"},{"p":"25","up":"20","q":"10","d":"5"}],"2":[{"p":"35","up":"20","q":"1","d":"5"},{"p":"35","up":"20","q":"2","d":"5"},{"p":"35","up":"20","q":"3","d":"5"},{"p":"35","up":"20","q":"4","d":"5"},{"p":"35","up":"20","q":"5","d":"5"},{"p":"35","up":"20","q":"6","d":"5"},{"p":"35","up":"20","q":"7","d":"5"},{"p":"35","up":"20","q":"8","d":"5"},{"p":"35","up":"20","q":"9","d":"5"},{"p":"35","up":"20","q":"10","d":"5"}],"3":[{"p":"30","up":"20","q":"1","d":"5"},{"p":"30","up":"20","q":"2","d":"5"},{"p":"30","up":"20","q":"3","d":"5"},{"p":"30","up":"20","q":"4","d":"5"},{"p":"30","up":"20","q":"5","d":"5"},{"p":"30","up":"20","q":"6","d":"5"},{"p":"30","up":"20","q":"7","d":"5"},{"p":"30","up":"20","q":"8","d":"5"},{"p":"30","up":"20","q":"9","d":"5"},{"p":"30","up":"20","q":"10","d":"5"}],"4":[{"p":"50","up":"20","q":"1","d":"5"},{"p":"50","up":"20","q":"2","d":"5"},{"p":"50","up":"20","q":"3","d":"5"},{"p":"50","up":"20","q":"4","d":"5"},{"p":"50","up":"20","q":"5","d":"5"},{"p":"50","up":"20","q":"6","d":"5"},{"p":"50","up":"20","q":"7","d":"5"},{"p":"50","up":"20","q":"8","d":"5"},{"p":"50","up":"20","q":"9","d":"5"},{"p":"50","up":"20","q":"10","d":"5"}]}}];

function get_visa_rates() {
	var nationality = $('#visa_nationality').val();
	var numb_visa = $('#numb_visa').val();
	var visa_type = $('#visa_type').val();
	var no_discount = 0;
	if($('#no_discount').length > 0) {
		no_discount = 1;
	}

	var rush_service = $('input:radio[name=rush_service]:checked').val();
	
	$('#selection_receive_date').html('');
	if(numb_visa != 0) {
		getSelections(numb_visa);
		
		var value = get_visa_price(nationality, numb_visa, visa_type, rush_service);
		
		$('#visa_from_price').css('color', '#B20000');
		$('#visa_from_price').css('font-size', '12px');
		$("#visa_from_price").html('Calculating ...');
		$('#visa_total_fee').html('');
		$('#div_discount').css('display', 'none');
		
		var rate = value.rate;
		var discount = value.discount;
		$('#visa_from_price').css('font-size', '14px');
		$('#visa_from_price').css('color', '#333');
		
		if(discount > 0) {
			$('#visa_discount').html('-$'+discount);
			if(!isNaN(rate)) rate = '$'+rate;
			$('#visa_total_fee').html(rate);
			
			$('#div_discount').css('display', 'block');
		} else {
			if(rate != 'NA' && rate != 'Free') rate = '$'+rate;
			$('#visa_total_fee').html(rate);
			
			$('#div_discount').css('display', 'none');
			//$('#visa_total_fee').css('font-size', '16px');
		}
		
		if(no_discount == 1) {
			$("#visa_from_price").html('$'+value.price+' x '+numb_visa+'&nbsp;=&nbsp;');
			
			if($('#stemp_fee_table').length > 0) {
				var stemp_fee_table = $('#stemp_fee_table').val();
				var stemp_fee = stemp_fee_table.split(',')[visa_type-1];
				$('#stamp_fee').html('$'+stemp_fee+' x '+numb_visa+'&nbsp;=&nbsp;');
				var total_stemp_fee = parseInt(stemp_fee)*parseInt(numb_visa);
				$('#stamp_total_fee').html('$'+total_stemp_fee);
			}
		} else {
			$("#visa_from_price").html('$'+value.price+' x '+numb_visa);
		}
		
		if ($('#selection_receive_date').length > 0) { 
		    // it exists 
			$.ajax({
				url: "/vietnam_visa/get_receive_date/",
				type: "POST",
				cache: true,
				data: {
					"rush_service":rush_service,		
				},
				success:function(value){
					if(value != '') {
						$('#selection_receive_date').html(value);
					}
				}
			});
		}
		
		/*
		$.ajax({
			url: "/vietnam_visa/get_visa_rates/",
			type: "POST",
			cache: true,
			dataType: "json",
			data: {
				"nationality":nationality,
				"numb_visa":numb_visa,
				"visa_type":visa_type,
				"rush_service":rush_service,		
				"no_discount":no_discount
			},
			success:function(value){
				var rate = value.rate;
				var discount = value.discount;
				$('#visa_from_price').css('font-size', '14px');
				$('#visa_from_price').css('color', '#333');
				
				if(discount > 0) {
					$('#visa_discount').html('-$'+discount);
					if(!isNaN(rate)) rate = '$'+rate;
					$('#visa_total_fee').html(rate);
					
					$('#div_discount').css('display', 'block');
				} else {
					if(rate != 'NA' && rate != 'Free') rate = '$'+rate;
					$('#visa_total_fee').html(rate);
					
					$('#div_discount').css('display', 'none');
					$('#visa_total_fee').css('font-size', '16px');
				}
				
				if(no_discount == 1) {
					$("#visa_from_price").html('$'+value.price+' x '+numb_visa+'&nbsp;=&nbsp;');
					
					if($('#stemp_fee_table').length > 0) {
						var stemp_fee_table = $('#stemp_fee_table').val();
						var stemp_fee = stemp_fee_table.split(',')[visa_type-1];
						$('#stamp_fee').html('$'+stemp_fee+' x '+numb_visa+'&nbsp;=&nbsp;');
						var total_stemp_fee = parseInt(stemp_fee)*parseInt(numb_visa);
						$('#stamp_total_fee').html('$'+total_stemp_fee);
					}
				} else {
					$("#visa_from_price").html('$'+value.price+' x '+numb_visa);
				}
			}
		});
		*/
	} else {	
		clearSelections();
	}
}

function get_visa_price(nationality, $numb_visa, visa_type, $rush_service) {
	
	var $visa_rates = null;
	
	if(nationality == 0) nationality = 6;
	
	var groupId = 0;
	$.each(RATE_TABLE, function(i, group) {
		
		$.each(group.country, function(i, country) {
			if(nationality == country) {
				groupId = group.id;
			}
		});
	});
	
	$.each(RATE_TABLE, function(i, group) {
		
		if(group.id == groupId) {
			$.each(group.price, function(i, obj) {
				
				//use obj.id and obj.name here, for example:
				if(visa_type == i) {
					$.each(obj, function(i, rate) {
						
						if($numb_visa == rate.q) {
							//alert(rate.toSource());
							var $visa_prices = rate;
							
							$price = 0;
							if($visa_prices.p != '') {
								$total_fee = $visa_prices.p  * $numb_visa;
								$price = $visa_prices.p;
							} else {
								$total_fee = 0;
							}
						
								
							if($rush_service == 2) {
								$total_fee += ($visa_prices.up * $numb_visa);
								$price = parseInt($visa_prices.p, 10) + parseInt($visa_prices.up, 10);
							}
						
							if($total_fee == 0) {
								if($visa_prices.p != '') {
									$total_fee = 'Free';
								} else {
									$total_fee = 'NA';
								}
							}
						
							$visa_rates = {'rate':$total_fee, 'discount':0 , 'price':$price};
						}
					});
				}
				
			});
		}
		
	});
	
	return $visa_rates;
}

function getSelections(numb_visa) {
	$('#selection_nationality').css('color', '#333');
	var txtSelections = numb_visa > 1 ? numb_visa+" applicants" : numb_visa+" applicant";
	
	var selection_nationality = '';
	if($("#visa_nationality option:selected").val() != '0') {
		selection_nationality = " - " + $("#visa_nationality option:selected").text();
	}
	
	$('#selection_nationality').html(txtSelections + selection_nationality);
	$('#selection_visa_type').html($("#visa_type option:selected").text());
	$('#selection_rush_service').html($('input:radio[name=rush_service]:checked').attr('title') + " processing");
}

function clearSelections() {
	$('#selection_nationality').css('color', '#B20000');
	$('#selection_nationality').html('Please fill the apply form');
	$('#selection_visa_type').html('&nbsp;');
	$('#selection_rush_service').html('&nbsp;');
	
	$('#visa_from_price').html('');
	$('#visa_total_fee').html('');
	$('#div_discount').css('display', 'none');
}

function book_visa(action) {
	var nationality = $('#visa_nationality').val();
	var numb_visa = $('#numb_visa').val();

	if(numb_visa != '0' && nationality != '0') {
		window.frmApplyVisaDetail.action.value = 'book';
		window.frmApplyVisaDetail.submit();
	} else {
		if (typeof(action) != 'undefined') {
			alert('Please select your nationality, number of visa, type of visa and processing time !!!');
		}
	}
}

function change_visa_options() {
	if($('#update_visa_form').css('display') == 'none') {
		$('#update_visa_form').css('display', 'block');
		$('#change_search').html('Hide Visa Options<span class="icon icon-arrow-down"></span>');
	} else {
		$('#update_visa_form').css('display','none');
		$('#change_search').html('Change Visa Options<span class="icon icon-arrow-down"></span>');
	}
}

function edit_visa_booking() {
	var nationality = $('#visa_nationality').val();
	var numb_visa = $('#numb_visa').val();
	var crNumbVisa = $('#crNumbVisa').val();

	if(nationality != '0' && numb_visa != '0') {
		if (crNumbVisa > numb_visa && !confirm('Do you really want to change the number of visa?')) {
			return false;
		}
		window.frmVisaDetails.action.value = 'update';
		window.frmVisaDetails.submit();
	}
}

function submit_visa_details(action) {

	if(validate_form()) {
		var arrival_day = $('#arrival_day').val();
		var arrival_month = $('#arrival_month').val();
		var arrival_year = $('#arrival_year').val();
		if(arrival_day != '' && arrival_month != '' && arrival_year != '') {
			window.frmVisaDetails.arrival_date.value = arrival_day+'-'+arrival_month+'-'+arrival_year;
		}

		var exit_day = $('#exit_day').val();
		var exit_month = $('#exit_month').val();
		var exit_year = $('#exit_year').val();
		if(exit_day != '' && exit_month != '' && exit_year != '') {
			window.frmVisaDetails.exit_date.value = exit_day+'-'+exit_month+'-'+exit_year;
		}

		$('select[name*="birth_day"]').each(function(){
			var id = $(this).attr('id');
			id = id.replace("birth_day", "");
			var day = $(this).val();
			var month = $('#birth_month'+id).val();
			var year = $('#birth_year'+id).val();
			
			if(day != '' && month != '' && year != '') {
				$('#birthday'+id).val(day+'-'+month+'-'+year);
			}
		});
		
		$('select[name*="expired_day"]').each(function(){
			var id = $(this).attr('id');
			id = id.replace("expired_day", "");
			var day = $(this).val();
			var month = $('#expired_month'+id).val();
			var year = $('#expired_year'+id).val();
			
			if(day != '' && month != '' && year != '') {
				$('#passport_expired'+id).val(day+'-'+month+'-'+year);
			}
		});
		
		$('input[name*="nationality_name"]').each(function(){
			var id = $(this).attr('id');
			id = id.replace("nationality_name", "");
			var nat_name = $("#nationality"+id+" option:selected").text();
			$(this).val(nat_name);
		});
		
		window.frmVisaDetails.action.value = action;
		window.frmVisaDetails.submit();
	}
}

function skip_visa_details() {
	if(confirm('Do you really want skip this step and provide visa details later?')) {
		window.location = '/my-booking/';
	}
}

function check_requirements() {
	var nat = $('#ck_nationality').val();
	if(nat != '') {
		window.location = "/vietnam-visa/visa-for-"+nat;
	} else {
		alert('Please select your nationality !!!');
	}
}

function init_visa_details() {
	$('#frmVisaDetails').find ('input:visible:first').focus();
	
	// store the state of form
	$('#frmVisaDetails').data('serialize',$('#frmVisaDetails').serialize());

	window.onbeforeunload = function() {
		if($('#frmVisaDetails').serialize()!=$('#frmVisaDetails').data('serialize')
				&& window.frmVisaDetails.action.value == ''){
	    	return 'Are you sure you want to leave this page?';
		}
	};
	
	// check passport apply type
	change_apply_type();
}

function change_apply_type(){
	var value = $('input[name=detail_type]:checked').val();

	if(value == 2) {
		$('#applicant_details').addClass('hide');
		$('#visa_email_note').removeClass('hide');
	} else if(value == 1) {
		$('#applicant_details').removeClass('hide');
		$('#visa_email_note').addClass('hide');

		// focus on the first text input field in the first field on the page
        $("input[type='text']:first", document.forms[0]).focus();
	}
}

function _check_applicant_details(rowIndex, action) {
	var check = true;

	var inputs = [ "input[name='passport_name"+rowIndex+"']", "select[name='gender"+rowIndex+"']", 
	      		"select[name='nationality"+rowIndex+"']", "select[name='birth_day"+rowIndex+"']",
	      		"select[name='birth_month"+rowIndex+"']", "select[name='birth_year"+rowIndex+"']",
	      		"input[name='passport_number"+rowIndex+"']" ];
	
	inputs.forEach(function(entry, index) {
		var input = $("#edit_app_" + rowIndex + " " + entry);
		if(input.val().length == 0) {
			$(input).addClass("red-border");
			check = false;
		} else {
			$(input).removeClass("red-border");

			if(action == 'update') {
				if(index == 0 || index == 6) {
					var columnIndex =  $(input).parent().index();
					$("#app_" + rowIndex).find('td').eq(columnIndex).html(input.val());
				} else if(index == 1 || index == 2) {
					var columnIndex =  $(input).parent().index();
					var value = $(input).find(":selected").text();
					$("#app_" + rowIndex).find('td').eq(columnIndex).html(value);
				} else if(index == 3 || index == 4 || index == 5) {
					var columnIndex =  $(input).parent().index();
					
					var day = $('#birth_day'+rowIndex).val();
					var month = $('#birth_month'+rowIndex).val();
					var year = $('#birth_year'+rowIndex).val();
					
					
					if(day != '' && month != '' && year != '') {
						month = $('#birth_month'+rowIndex).find(":selected").text();
						month = month.substr(0,3);
						var value = day + ' ' + month + ' ' + year;
						$("#app_" + rowIndex).find('td').eq(columnIndex).html(value);
					}
				}
			}
		}
	});

	if(check == false) $('#dv_err').show();

	return check;
}

function validate_form() {
	if ($('input[name=detail_type]').length) {
		var detail_type = $('input[name=detail_type]:checked').val();
		
		if(typeof detail_type === "undefined") {
			$('#dv_err').show();
			return false;
		}
		
		if(detail_type == 2) {
			return true;
		}
	}
	
	var status = true;
	$('#applicant_details tr').each(function() {
		var tr = $(this);
		var str_edit = $(tr).attr('id').indexOf("edit_app"); 
		if(str_edit == 0) {
			var index = $(tr).attr('id').replace("edit_app_", ""); 
			if(!_check_applicant_details(index, '')) {
				status = false;
			}
		}
	});
	
	return status;
}