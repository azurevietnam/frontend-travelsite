function check_form() {
    $('#applicant_details tr').each(function() {
        var id = $(this).attr('id');
        if (id.indexOf('edit_app_') != -1) {
            id = id.replace('edit_app_', '');
            if (!_check_applicant_details(id, '')) {
                $('#app_' + id).hide();
                $("#edit_app_" + id).show();
            }
        }
    });
}

function book() {
    var stcb = document.getElementById("agree_cancelpolicy");
    if (stcb.checked) {

        $('select[name*="birth_day"]').each(function() {
            var id = $(this).attr('id').replace('birth_day', '');
            var day = $(this).val();
            var month = $('#birth_month' + id).val();
            var year = $('#birth_year' + id).val();

            if (day && month && year) {
                $('#birthday' + id).val(day + '-' + month + '-' + year);
            }
        });

        $('input[name*="nationality_name"]').each(function() {
            var id = $(this).attr('id').replace('nationality_name', '');
            var nat_name = $("#nationality" + id + " option:selected").text();
            $(this).val(nat_name);
        });

        document.frmPayment.cf_action.value = "submit";
        document.frmPayment.submit();

    } else {
        alert(i18n.payment_term_condition_cfm);
    }
}

function _edit_applicant(index) {
    $('#app_' + index).hide();
    $('#edit_app_' + index).show();
}

function _update_applicant(action, index) {
    if (action == 'update') {
        if (!_check_applicant_details(index, 'update')) { return false; }

        // update price
        update_visa_payment_price();
    }

    $('#app_' + index).show();
    $('#edit_app_' + index).hide();
}

function _check_applicant_details(rowIndex, action) {
    var check = true;

    var inputs = ["input[name='passport_name" + rowIndex + "']", "select[name='gender" + rowIndex + "']",
            "select[name='nationality" + rowIndex + "']", "select[name='birth_day" + rowIndex + "']",
            "select[name='birth_month" + rowIndex + "']", "select[name='birth_year" + rowIndex + "']",
            "input[name='passport_number" + rowIndex + "']"];

    inputs.forEach(function(entry, index) {
        var input = $("#edit_app_" + rowIndex + " " + entry);

        if (!input.val()) {
            $(input).addClass("input-error");
            check = false;
        } else {
            $(input).removeClass("input-error");
            
            var input_name = $(input).attr('name');

            if (action == 'update') {
            	
            	// passport name and passport number
                if (index == 0 || index == 6) {
                	$("#app_" + input_name).html(input.val());
                	
                // gender and nationality
                } else if (index == 1 || index == 2) {
                    var value = $(input).find(":selected").text();
                    
                    $("#app_" + input_name).html(value);
                    
                // birthday
                } else if (index == 3 || index == 4 || index == 5) {
                    var day = $('#birth_day' + rowIndex).val();
                    var month = $('#birth_month' + rowIndex).val();
                    var year = $('#birth_year' + rowIndex).val();

                    if (day && month && year) {
                        month = $('#birth_month' + rowIndex).find(":selected").text().substr(0, 3);
                        day = day.length == 1 ? '0' + day : day;
                        $("#app_birthday" + rowIndex).html(day + ' ' + month + ' ' + year);
                    }
                }
            }
        }
    });

    if (!check) $('#dv_err').show();

    return check;
}

function update_visa_payment_price() {

    var numb_visa = $('#numb_visa').val();

    if (numb_visa != 0) {

        var default_nationality = $('#visa_nationality').val();

        var visa_type = $('#visa_type').val();

        var rush_service = $('#rush_service').val();

        var bank_fee = $('#bank_fee').val();

        var total_price = 0;

        for (i = 0; i < numb_visa; i++) {

            var nationality = default_nationality;

            if ($('#nationality' + i) && $('#nationality' + i).val()) {
                nationality = $('#nationality' + i).val();
            }

            var value = get_visa_price(nationality, 1, visa_type, rush_service);

            total_price = parseInt(total_price, 10) + parseInt(value.rate, 10);
        }

        $('#visa_total_fee').html(total_price);

        var visa_bank_fee = total_price * bank_fee / 100;

        visa_bank_fee = Math.round(visa_bank_fee * 100) / 100;

        $("#visa_bank_fee").html(visa_bank_fee);

        var visa_final_total = total_price + visa_bank_fee;

        $("#visa_final_total").html(visa_final_total);
    }
}