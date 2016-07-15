/*! Basic Functions of Best Price Project
 * http://www.bestpricevn.com
 * Includes: all minimal and needed functions for the website
 * Copyright 2015 Bestpricevn.com */

/**
 * ---------------------------------------------------------
 * BEGIN OF DATEPICKER FUNCTIONS
 * ---------------------------------------------------------
 */

var daysofweek = i18n.days_of_week;
var FORMAT_DATE = 'dd-mm-yy';

/**
 * Khuyenpv March 09 2015
 * Format Date oject to string of dd-mm-yyyy
 **/
function date_to_str (now) {
    pad = function (val, len) {
        val = String(val);
        len = len || 2;
        while (val.length < len) val = "0" + val;
        return val;
    };

    var d = now.getDate();
    var m = now.getMonth();
    m++;
    var y = now.getFullYear();

    return pad(d) + "-" + pad(m) + "-" + y;
}

/**
 * Khuyenpv March 09 2015
 * Convert string (dd-mm-yyy) to Date oject
 **/
function str_to_date(str){
    var d = str.split('-');
    return new Date(parseInt(d[2], 10), [parseInt(d[1], 10)-1], parseInt(d[0], 10), 0, 0, 0, 0);
}
/**
 * Khuyenpv 04-02-2015
 * Loader: for loading Javascipt Asynchronously
 */
var Register = function(){
	this.resources = []; // storing list of resource will be loaded
	this.loaders = []; // storing list of loader object
};
Register.prototype = {
	// register the resouce
	addResouce: function(src){
		if(!this.isRegistered(src)){
			var resource = {'src':src,'loaded':false};
			this.resources.push(resource);
		}
	},
	
	// register the loader
	addLoader: function(loader){
		this.loaders.push(loader);
	},
	
	// set the resouce is loaded
	setLoaded: function(src){
		for(var i = 0; i < this.resources.length; i++){
			if(src == this.resources[i].src){
				this.resources[i].loaded = true; // set loaded
			}
		}
	},
	// check if the resouce is marked as loaded
	isLoaded: function(src){
		for(var i = 0; i < this.resources.length; i++){
			
			if(src == this.resources[i].src && this.resources[i].loaded){
				return true;
			}
		}
		return false;
	},
	// check if the resouce is registered
	isRegistered: function(src){
		for(var i = 0; i < this.resources.length; i++){
			if(src == this.resources[i].src){
				return true;
			}
		}
		return false;
	},
	
	// call the loader callbacks
	fireLoaderCallback: function(){
		for(var i = 0; i < this.loaders.length; i++){
			this.loaders[i].fireCallback();
		}
	}
}

var register = new Register();

var Loader = function () {
	this.isFiredCallback = false; // loader callback is not fired yet
	this.resources = []; // the resources of this loader
	this.callback = ''; // the callback of this loader
};

Loader.prototype = {
    require: function (scripts, callback) {
    	// storing the loader
        var self = this;
        register.addLoader(self);     
    	
        this.callback       = callback;

        for (var i = 0; i < scripts.length; i++) {
        	var is_js = is_script_file(scripts[i]);
        	if(is_js){
        		// storing the resources to the loader
        		this.resources.push(scripts[i]);
        		this.writeScript(scripts[i]);
        	} else {
        		this.writeCSS(scripts[i]);
        	}
        }
    },
    
    // fire the callback function of each loader
    fireCallback: function(){
    	if(!this.isFiredCallback){ // not fired yet
    		var all_resouce_loaded = true;
    		for(var i = 0; i < this.resources.length ; i++){
    			all_resouce_loaded = all_resouce_loaded && register.isLoaded(this.resources[i]);
    		}
    	
    		if(all_resouce_loaded && typeof this.callback == 'function'){
    			
    			this.callback.call(); // fired callback
    			
    			this.isFiredCallback = true; // set that the callback is already call
    		}
    	}
    },
    
    writeCSS: function (src){
    	// css link to be writen
    	var css_link = '<link rel="stylesheet" type="text/css" href="' + src + '"/>';

    	// first header tag
    	var head_tag = $('head')[0];

    	// children of the header tags
    	var resources = $(head_tag).children();

    	// check if the css is already writen
    	var is_writen = false;

    	for(var i = 0; i < resources.length; i++){
    		var chd = resources[i];
    		if($(chd).attr('href') == src){
    			is_writen = true;
    			break;
    		}
    	}
    	// only insert css link if it's not insterted
    	if(!is_writen){
    		$(head_tag).append(css_link);
    	}
    },
    writeScript: function (src) {
    	if(!register.isRegistered(src)){ // if the resouce is not register (call) then get the resouce from the server
    		
    		register.addResouce(src); // register the resouce
    		
    		// get script from the server
    		$.ajax({
        		  url: src,
        		  dataType: "script",
        		  cache: true, // cache in the browser
        	}).done(function(e) {
        		
        		register.setLoaded(src); // mark the resouce is loaded
        		
        		register.fireLoaderCallback(); // fire Loader Callback
        	});
    	}else{ // already register
    		if(register.isLoaded(src)){ // allready loaded
    			register.fireLoaderCallback(); // fire Loader Callback
    		}
    	}
    }
}

function is_script_file(file) {
	if(file.indexOf(".js") > -1 || file.indexOf("googleapis") > -1) {
		return true;
	}

	return false;
}

/**
 * COMMON SEARCH FUNCTIONS
 */
function change_search_type(){

    var search_form = $("input:radio[name ='search-type']:checked").val();

    $('.search-tour-form').hide();
    $('.search-hotel-form').hide();
    $('.search-flight-form').hide();

    $('.' + search_form).show();
}

/**
 * Khuyenpv 06-03-2015
 * Init common Datepicker Functions
 */
function init_datepicker(day_id, month_id, date_id, available_dates, selected_date){


    if(selected_date == undefined || selected_date == ''){
        selected_date = new Date(); // default for today
        selected_date = date_to_str(selected_date);
    }

    var today = new Date();

    // select the nearest date
    if(available_dates.length > 0 && available_dates.indexOf(selected_date) == -1){

        for(var i = 0; i < available_dates.length; i++){

            var date_value = str_to_date(available_dates[i]);

            if(date_value != str_to_date(selected_date) && date_value >= today){

                selected_date = available_dates[i];

                break;
            }
        }
    }

    set_current_selected_date(day_id, month_id, date_id, available_dates, selected_date);
}
/**
 * Khuyenpv 06-03-2015
 * Change the day of datepicker
 */
function change_datepicker_day(day_id, month_id, date_id){
    var selected_date = get_current_selected_date(day_id, month_id);
    $(date_id).val(selected_date);
    $(date_id).change();
}

/**
 * Khuyenpv 06-03-2015
 * Change the month of datepicker
 */
function change_datepicker_month(day_id, month_id, date_id, available_dates, is_update_input_value){
    init_datepicker_days(day_id, month_id, available_dates);

    if(is_update_input_value == undefined) is_update_input_value = true; // default to update the selected date to the Date Input (date_id)

    if(is_update_input_value){
        var selected_date = get_current_selected_date(day_id, month_id);
        $(date_id).val(selected_date);
        $(date_id).change();
    }
}

/**
 * ---------------------------------------------------------
 * BEGIN OF DATEPICKER FUNCTIONS
 * ---------------------------------------------------------
 */


/**
 * Khuyenpv 06-03-2015
 * Init Datepicker Days
 */
function init_datepicker_days(day_id, month_id, available_dates){

    var previous_selected_date = $.trim($(day_id + ' option:selected').val());


    var htmlDays = '';
    var month_selected = $(month_id + ' option:selected').val();
    var month_arr = month_selected.split('-');
    var days = days_in_month(month_arr[0], month_arr[1]);

    var has_same_day = false;

    for(var i=0; i<days.length; ++i){

        var dayarr = days[i].split('-');

        var day_value = dayarr[1].toString();
        if(day_value.length == 1) day_value = '0'+day_value;


        if(is_available_dates(day_value, month_id, available_dates)){

            htmlDays += '<option value="' + day_value +'">' + dayarr[0] + ', ' + dayarr[1] + '</option>';

            if(previous_selected_date == dayarr[1]) has_same_day = true;

        }
    }

    $(day_id).html(htmlDays);

    if(has_same_day){
        $(day_id).val(previous_selected_date);
    } else {
        // select the first available date in the list
    }
}

/**
 * Khuyenpv March 06 2015
 * Get Days In a Month
 */
function days_in_month(iMonth, iYear)
{
    iMonth = parseInt(iMonth, 10);
    iYear = parseInt(iYear, 10);
    var days = new Array();
    var numdays =  32 - new Date(iYear, iMonth - 1, 32).getDate();
    for(var i=1; i<=numdays; ++i) {
        day = new Date(iYear, iMonth - 1, i);
        days.push(daysofweek[day.getDay()] +  "-" + i);
    }
    return days;
}

/**
 * Khuyenpv March 06 2015
 * Get Days In a Month
 */
function is_available_dates(day_value, month_id, available_dates){

    if(available_dates.length == 0) return true;

    var selected_date = day_value + '-' + $(month_id + ' option:selected').val();

    for(var i = 0; i < available_dates.length; i++){
        if(selected_date == available_dates[i]) return true;
    }

    return false;
}

/**
 * Khuyenpv March 09 2015
 * Create the datepiker calendar instance
 */
function setup_datepicker(input_id, available_dates, fn_select, language_code, is_mobile){

    var num_months = 2;

    if (typeof is_mobile !== "undefined" && is_mobile) {
        is_mobile = true;
        num_months = 1;
    } else {
        is_mobile = false;
    }

    if(fn_select == undefined && typeof fn_select != 'function'){
        fn_select = null;
    }

	if(is_mobile) {
		$(input_id).datepicker({
			numberOfMonths: num_months,
			closeText: i18n.close,
			currentText: i18n.today,
			showButtonPanel: is_mobile,
			minDate: 0,
			dateFormat: FORMAT_DATE,
			beforeShowDay: function(date){
			    var selected_date = date_to_str(date);

			    if(available_dates == '' || available_dates.length == 0){
			        return [true];
			    } else {
			        return [available_dates.indexOf(selected_date) != -1];
			    }
			},
			onSelect: fn_select
	    });
		
		// workaround with read-only bug in Safari iOS 8
		$(input_id).on('focus', function(ev) {
		    $(this).trigger('blur');
		});
	} else {
		$(input_id).datepicker({
	        numberOfMonths: num_months,
	        showOn: "button",
	        showButtonPanel: is_mobile,
	        buttonImage: '/media/icon/calendar.png',
	        buttonImageOnly: true,
	        minDate: 0,
	        dateFormat: FORMAT_DATE,
	        beforeShowDay: function(date){
	            var selected_date = date_to_str(date);

	            if(available_dates == '' || available_dates.length == 0){
	                return [true];
	            } else {
	                return [available_dates.indexOf(selected_date) != -1];
	            }
	        },
	        onSelect: fn_select
	    });
	}

    //$(input_id).datepicker("option", $.datepicker.regional[language_code]);
}

/**
 * Khuyenpv March 09 2015
 * Get current selected date
 */
function get_current_selected_date(day_id, month_id){

    var day_value = $(day_id + ' option:selected').val();

    var month_value = $(month_id + ' option:selected').val();

    var selected_date = day_value + '-' + month_value;

    return selected_date;
}

/**
 * Khuyenpv March 09 2015
 * Set current selected date
 */
function set_current_selected_date(day_id, month_id, date_id, available_dates, selected_date){

	if($(day_id).length && $(month_id).length){

		var date_arr = selected_date.split('-');

	    var day_value = date_arr[0];

	    var month_value = date_arr[1] + '-' + date_arr[2];
	    $(month_id + ' option[value="' + month_value +'"]').prop('selected', true);

	    change_datepicker_month(day_id, month_id, date_id, available_dates, false);

	    $(day_id + ' option[value="' + day_value +'"]').prop('selected', true);

	}

    $(date_id).val(selected_date);

    $(date_id).change();

    //alert(date_id + ' ' + $(date_id).val())
}

/**
 * Change the Datepicker Date
 * @author Khuyenpv
 * @since March 16 2015
 */
function change_datepicker_date(date_id, night_nr, night_nr_id){
    var departure_date = $(date_id).val();

    if(night_nr_id != undefined && night_nr_id != '' && $(night_nr_id).length > 0){ // for hotel night number
        night_nr = parseInt($(night_nr_id).val());
        //alert(departure_date + ' - ' + night_nr);
    }
    
    night_nr = parseInt(night_nr);

    departure_date_obj = str_to_date(departure_date);
    departure_date_obj.setDate(departure_date_obj.getDate() + night_nr);

    var month_names = i18n.month_names;
    var daysofweek = i18n.days_of_week;

    var str_end_date = month_names[departure_date_obj.getMonth()] + " " + departure_date_obj.getFullYear();

    str_end_date = daysofweek[departure_date_obj.getDay()] + " " + departure_date_obj.getDate() + " " + str_end_date;

    //alert(str_end_date);
    str_end_date += get_date_direction(date_id, departure_date);

    $(date_id + '_end').text(str_end_date);
}

/**
 * toanlk 27-06-2015
 * check date is upstream or downstream
 */
function get_date_direction(date_id, selected_date) {

	direction = '';

	if( $('#upstream_dates').length ) {
    	upstream_dates = $('#upstream_dates').val().split(",");
    	if(upstream_dates.indexOf(selected_date) != -1) {
    		direction = ' ('+i18n.cruise_upstream+')';
    	}
    }

    if( $('#downstream_dates').length ) {
    	downstream_dates = $('#downstream_dates').val().split(",");
    	if(downstream_dates.indexOf(selected_date) != -1) {
    		direction = ' ('+i18n.cruise_downstream+')';
    	}
    }

    return direction;
}

/**
 * ---------------------------------------------------------
 * END OF DATEPICKER FUNCTIONS
 * ---------------------------------------------------------
 */


/**
 * ---------------------------------------------------------
 * BEGIN OF TOUR SEARCH FUNCTIONS
 * ---------------------------------------------------------
 */
/**
 * Khuyenpv March 09 2015
 * Set Tour-Destination Autocomplete
 */
function set_search_des_auto(module){
    var module = module;

    var destinations = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),//'name'
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/' + module + '-des-auto-prefetch/' + module + '-des-auto.json',
        remote: '/' + module + '-des-auto-remote/%QUERY.json',
        limit:20
    });

    destinations.initialize();

    $('#' + module + '_destination').typeahead({
        minLength: 2,
        highlight : true,
        hint : true,
        autoselect: true
    },{
        name: 'destinations',
        displayKey: 'name',
        source: destinations.ttAdapter(),
        templates: {
            suggestion: Handlebars.compile('<span class="pull-left type-width" style="font-size:10px; background-color: {{color}};">{{destination_type}}</span>  <span class="pull-left arrow-seach" style=" border-color: transparent transparent transparent {{color}};"></span> <span class="margin-left-15">{{name}}</span> <span class="pull-right">{{parent_name}}</span>')
        }
    }).on("typeahead:selected", function($e, datum){
        //alert('go here 2');4
    	if(module == 'hotel'){	
    		
    		if(datum.is_hotel != undefined){ // select the hotel
    			$('#' + module + '_destination_id').val('');
    			$('#hotel_search_id').val(datum.id);
    		} else {
    			$('#' + module + '_destination_id').val(datum.id);
    			$('#hotel_search_id').val('');
    		}
    		
    		
    	} else {
    		$('#' + module + '_destination_id').val(datum.id);
    	}        

    }).on("typeahead:autocompleted", function($e, datum){
        //alert('go here');
        $('.tt-dataset-destination .tt-suggestions .tt-suggestion').first().addClass('tt-cursor');
    }).on("keyup", function(e){
        if(e.keyCode != 13){
            $('#' + module + '_destination').popover('destroy');
            $('#' + module + '_destination').removeClass('input-error');
            $('#' + module + '_destination_id').val('');
            
            if(module == 'hotel'){	
            	$('#hotel_search_id').val('');
            }
        }
    });
}

/**
 * Validate The Tour Search Form
 *
 * @author Khuyenpv
 * @since  Mar 10, 2015
 */
function validate_search(destination_id, date_id, module){
	
	if(module == '' || module == undefined) module = 'tour';
	
    var des_id = $(destination_id + '_id').val();
    
    var hotel_search_id = $('#hotel_search_id').val();
    
    var is_invaid_search = false;
    
    if(module == 'tour'){
    	is_invaid_search = des_id == '';
    }
    
    if(module == 'hotel'){
    	is_invaid_search = des_id == '' && hotel_search_id == '';
    	
    }
    if(is_invaid_search){
        $(destination_id).addClass('input-error');
        /*
         var help_cnt = i18n.search_destination_required;

         var options = {container:'body', 'title': i18n.help, 'placement': 'right', 'html':true, 'content': help_cnt, 'trigger':'manual'};

         $(destination_id).popover(options);
         $(destination_id).popover('show');
         $(destination_id).focus();
         */
        set_popover(destination_id, 'manual');
        $(destination_id).popover('show');
        $(destination_id).focus();
        return false;
    }

    alert_travel_start_date(date_id);


    return true;
}

/**
 * Get Current Search
 *
 * @author Khuyenpv
 * @since  Mar 11, 2015
 */
function get_current_tour_search(){
    $.getJSON( "ajax/tour_ajax/get_lasted_tour_search/", function( data ) {

        if(data.destination != undefined) $('#tour_destination').val(data.destination);

        if(data.destination_id != undefined) $('#tour_destination_id').val(data.destination_id);

        if(data.departure_date != undefined){
            set_current_selected_date('#departure_day', '#departure_month', '#departure_date', [], data.departure_date);
        }

        var travel_styles = data.travel_styles != undefined ? data.travel_styles : new Array();

        $('.-travel-styles').each(function(){
            var ts_val = $(this).val();
            if(travel_styles.indexOf(ts_val) != -1){
                $(this).prop('checked', true);
            }
        });

        var duration = data.duration != undefined ? data.duration : '';
        $('#duration option[value="' + duration +'"]').prop('selected', true);

        var group_type = data.group_type != undefined ? data.group_type : '';
        $('#group_type option[value="' + group_type +'"]').prop('selected', true);

        var budgets = data.budgets != undefined ? data.budgets : new Array();
        $('.-budgets').each(function(){
            var bud_val = $(this).val();
            if(budgets.indexOf(bud_val) != -1){
                $(this).prop('checked', true);
            }
        });


    });
}

/**
 * Get Current Search Hotel
 *
 * @author TinVM
 * @since  Jun 30, 2015
 */
function get_current_hotel_search(){
	
    $.getJSON( "ajax/hotel_ajax/get_lasted_hotel_search/", function( data ) {

        if(data.destination != undefined) $('#hotel_destination').val(data.destination);

        if(data.destination_id != undefined) $('#hotel_destination_id').val(data.destination_id);

        if(data.start_date != undefined){
            set_current_selected_date('#departure_day', '#departure_month', '#departure_date', [], data.start_date);
        }

        if( data.stars != undefined && data.stars.length ) {
        	
        	$('.hotel-stars').each(function(){
                var ts_val = $(this).val();
                if(data.stars.indexOf(ts_val) != -1){
                    $(this).prop('checked', true);
                }
            });
        }

        var nights = data.hotel_night_nr != undefined ? data.hotel_night_nr : '';
        $('#hotel_night_nr[value="' + nights +'"]').prop('selected', true);

    });
}

/**
 * ---------------------------------------------------------
 * END OF TOUR SEARCH FUNCTIONS
 * ---------------------------------------------------------
 */

/**
 * ---------------------------------------------------------
 * BEGIN OF COMMON FUNCTIONS
 * ---------------------------------------------------------
 */
/**
 * Set the tool-tip help
 *
 * @author Khuyenpv
 * @since  Mar 10, 2015
 */
function set_help(id){

    $(id).each(function(){

        $(this).css('cursor','pointer');

        var title = $(this).attr('data-title');
        if(title == undefined || title == '') title = i18n.help;

        var data_target = $(this).attr('data-target');

        var content = $(data_target).html();

        var placement = $(this).attr('data-placement');
        if(placement == undefined || placement == '') placement = 'auto';

        if($.trim(content) != ''){
            var options = {container: 'body', 'title': title, 'placement': placement, 'html':true, 'content': content, 'trigger':'hover'};
            $(this).popover(options);
        }
    });
}

/**
 * Set the popover click on
 *
 * @author Khuyenpv 20.03.2015
 */
function set_popover(id, trigger){

    if(trigger == undefined) trigger = 'click';

    $(id).each(function(){
    	
    	var data_pop = $(this).attr('data-pop');
    	
    	if(data_pop == '' || data_pop == undefined){ // not set the popover yet
    		
    		var popover_togglers = this;
    		
    		var data_target = $(this).attr('data-target');
    		
    		var pop_css_target = data_target.substring(1, data_target.length); 
    		
        	var template = '<div class="popover" role="tooltip">'
                + '<div class="arrow"></div>'
                + '<h3 class="popover-title"></h3>'
                + '<div class="popover-content"></div>'
                + '<div class="popover-footer text-right">'
                + '<button type="button" class="btn btn-blue btn-sm ' + pop_css_target + '">' + i18n.close + '</button>'
                + '</div>'
                + '</div>';
        	
    		
	        var title = $(this).attr('data-title');
	        if(title == undefined || title == '') title = i18n.help;

	        title = title + '<button type="button" class="close ' + pop_css_target+ '" aria-hidden="true" data-dismiss="popover"><span class="glyphicon glyphicon-remove"></span></button>';

	        
	        var content = $(data_target).html();

	        var placement = $(this).attr('data-placement');
	        if(placement == undefined || placement == '') placement = 'auto';

	        if($.trim(content) != ''){
	            var options = {container: 'body', 'title': title, 'placement': placement, 'html':true, 'content': content, 'template': template, 'trigger':trigger};
	            $(popover_togglers).popover(options);
	            $(popover_togglers).on('shown.bs.popover', function () {
	            	$('.' + pop_css_target).click(function(){
	            		$(popover_togglers).popover('hide');
	            	});
            	})
	        }
	        $(popover_togglers).attr('data-pop','1'); // marked as the popover is already set
    	}
    });
}


/**
 * Set show-hide and element
 *
 * @author Khuyenpv
 * @since 07.04.2015
 */
function set_show_hide(id, speed){
    if(speed == undefined) speed = 'fast';
    $(id).each(function(){

        $(this).click(function(e) {

            //e.preventDefault();

            var show = $(this).attr('data-show');
            var data_target = $(this).attr('data-target');

            var data_icon = $(this).attr('data-icon');
            if(data_icon != ''){
                var data_icon_show = $(data_icon).attr('data-show');
                var data_icon_hide = $(data_icon).attr('data-hide');
            }

            if(show == 'show'){
                $(data_target).hide(speed);
                $(this).attr('data-show', 'hide');
                if(data_icon !=''){
                    $(data_icon).removeClass(data_icon_show);
                    $(data_icon).addClass(data_icon_hide);
                }
            } else{
                $(this).attr('data-show', 'show');
                $(data_target).show(speed);

                if(data_icon !=''){
                    $(data_icon).removeClass(data_icon_hide);
                    $(data_icon).addClass(data_icon_show);
                }
            }
        });


    });
}


/**
 * Alert if the start-date is today or in the past
 *
 * @author Khuyenpv
 * @since  Mar 17, 2015
 */
function alert_travel_start_date(date_id){

    var depature_date = $(date_id).val();
    depature_date = str_to_date(depature_date);

    var today = new Date();
    today = date_to_str(today);
    today = str_to_date(today);


    if(depature_date <= today){
        alert(i18n.search_alert_date);
    }
}

/**
 * Go to an url
 * @author Khuyenpv
 * @since 02.04.2015
 */
function go_url(url){
    window.location.href = url;
}


/**
 * Go to top of a page
 * @author Khuyenpv
 * @since 02.04.2015
 */
function go_top(speed){
    if(speed == undefined) speed = "fast";
    $("html, body").animate({ scrollTop: 0}, speed);
}

/**
 * Go to bottom of a page
 * @author Khuyenpv
 * @since 02.04.2015
 */
function go_bottom(speed){
    if(speed == undefined) speed = "slow";
    $("html, body").animate({ scrollTop: $(document).height()-$(window).height()}, speed);
}

/**
 * Go to a position of an element
 * @author Khuyenpv
 * @since 02.04.2015
 */
function go_position(id, speed){
    if(speed == undefined) speed = "fast";
    $("html, body").animate({ scrollTop: $(id).offset().top}, speed);
}

/**
 * Show-Hide the Loading Indicator
 *
 * @author Khuyenpv
 * @since 03.04.2015
 */
function show_loading_data(show_status, id, message){
	
    if(show_status  == undefined) show_status = true;

    if(message == undefined || message == '') message = i18n.loading;

    var loading_html = '<div class="bpt-loading text-center">'
        + '<img src="/media/icon/loading.gif"/>'
        + '<span>' + message + '</span>'
        + '</div>';
    if(show_status){

        if(id == undefined || id == ''){

            $('body').append(loading_html);

            $('.bpt-loading').center();

        } else {
            $(id).append(loading_html);
        }


    } else {

        $('.bpt-loading').remove();


    }
}

/**
 * Get cruise price froms
 *
 * @author Khuyenpv
 * @since 09.04.2015
 */
function get_cruise_price_from(){
    var post_data = '';
    var is_first = true;

    $('.cruise-ids').each(function(){

        var cruise_id = $(this).attr('data-id');

        if(!is_first){
            post_data = post_data + '&';
        }

        post_data = post_data + 'cruise_ids[]='+ cruise_id;

        is_first = false;
    });

    $.ajax({
        url: '/cruise-price-from/',
        type: "POST",
        dataType:'json',
        data: post_data,
        success:function(value){
            for(var i = 0; i < value.length; i++){

                var price = value[i];
                var cruise_id = price.cruise_id;
                if(price.price_origin != price.price_from){
                    $('.c-origin-'+cruise_id).html('$'+price.price_origin);
                }
                $('.c-from-'+cruise_id).html('$'+price.price_from);
                $('.c-from-'+cruise_id).show();
                $('.c-unit-'+cruise_id).show();
                $('.c-includes-'+cruise_id).html(price.service_includes);
                $('.c-excludes-'+cruise_id).html(price.service_excludes);

                if(value[i].is_hot_deals == 1 && price.price_origin != price.price_from
                		&& $('#c-pro-rate-'+cruise_id).length){
                	var offer_rate = Math.round((price.price_origin - price.price_from) * 100 / price.price_origin);

    				$('#c-pro-rate-'+cruise_id).html('-'+offer_rate + '%');
    				$('#c-pro-rate-'+cruise_id).show();
    				$('#c-pro-rate-bg-'+cruise_id).show();
                }
            }

            set_popover('.what-included');
        }
    });
}

/**
 * Get tour price froms
 *
 * @author Khuyenpv
 * @since 10.04.2015
 */
function get_tour_price_from(){

    var post_data = '';
    var is_first = true;
    $('.tour-ids').each(function(){

        var tour_id = $(this).attr('data-id');

        if(!is_first){
            post_data = post_data + '&';
        }

        post_data = post_data + 'tour_ids[]='+ tour_id;

        is_first = false;
    });

    $.ajax({
        url: '/tour-price-from/',
        type: "POST",
        dataType:'json',
        data: post_data,
        success:function(value){
            for(var i = 0; i < value.length; i++){
                var price = value[i];
                var tour_id = price.tour_id;
                if(price.price_origin != price.price_from){
                    $('.t-origin-'+tour_id).html('$'+price.price_origin);
                }
                $('.t-from-'+tour_id).html('$'+price.price_from);
                $('.t-from-'+tour_id).show();
                $('.t-unit-'+tour_id).show();

                var is_hot_deals = value[i].is_hot_deals;
                if(is_hot_deals == 1 && price.price_origin != price.price_from){
                	var offer_rate = Math.round((price.price_origin - price.price_from) * 100 / price.price_origin);
    				$('.t-offer-rate-'+tour_id).html(offer_rate + '%');
    				$('.t-offer-rate-'+tour_id).show();
                }
            }
        }
    });
}

/**
 * See cruise/tour/hotel overview
 *
 * @author Khuyenpv
 * @since 13.04.2015
 */
function see_overview(url_title, service_type, name, star, location){

	var modal_html = '<div class="modal fade" id="service_overview" tabindex="-1" role="dialog" aria-labelledby="see_more_deal_title" aria-hidden="true">'
        + '<div class="modal-dialog modal-lg">'
        + '<div class="modal-content">'
        + '<div class="modal-header" id="service_overview_header">'
        + '</div>'
        + '<div class="modal-body" id="service_overview_cnt">'
        + '</div>'
        + '<div class="modal-footer">'
        + '<button type="button" class="btn btn-blue btn-sm" data-dismiss="modal">' + i18n.close + '</button>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>';

    if($('#service_overview').length > 0){
        // already exist: do nothing
    } else {
        $('body').append(modal_html);
    }

    var header_html = '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span></button>';

    if(name != '' && name != undefined){
        header_html = header_html + '<h2 class="text-highlight margin-bottom-0">' + name + '</h2>';
    }


    $('#service_overview_header').html(header_html);

    $('#service_overview_cnt').html('');

    $('#service_overview').modal();

    var url = '';
    if(service_type == 'tour'){
        url = '/ajax/tour_ajax/see_overview/';
    }

    if(service_type == 'cruise'){
        url = '/ajax/cruise_ajax/see_overview/';
    }

    if(service_type == 'hotel'){
        url = '/ajax/hotel_ajax/see_overview/';
    }

    if(service_type == 'destination'){
        url = '/ajax/destination_ajax/see_overview/';
    }

    if(url != ''){
        show_loading_data(true, '#service_overview_cnt');
        $.ajax({
            url: url,
            type: "POST",
            cache: true,
            dataType:'json',
            data: {
                url_title: url_title
            },
            success:function(value){

                $('#service_overview_header h2').html(value.title);

                $('#service_overview_cnt').html(value.content);

                show_loading_data(false);

            }
        });
    }
}



/**
 * Toggle plugin
 *
 * Ex: $(element).bpvToggle();
 *
 * @author toanlk
 * @since  Mar 19, 2015
 */
jQuery.fn.bpvToggle = function (callback) {
    $( this ).click(function(e) {
        // prevent the default action of the click event
        // ie. prevent the browser from redirecting to the link's href
        e.preventDefault();

        // 'target' is the execution context of the event handler
        // it refers to the clicked target element
        var target = $(this).attr('data-target');

        // check exists
        if( $(target).length == 0 ) {
            return false;
        }

        var bpv = this;

        // Trigger the sliding animation on .content
        // The Animation Queues Up: .not(':animated')
        $(target).not(':animated').slideToggle("slow","swing", function() {

            // change icon here
            if (typeof callback == 'function') { // make sure the callback is a function
                callback.call(bpv, {id: target}); // brings the scope to the callback
            }

        });
    });
}

/**
 * Center screen plugin
 *
 * Ex: $(element).center();
 *
 * @author toanlk
 * @since  Mar 19, 2015
 */
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
    $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
    $(window).scrollLeft()) + "px");
    return this;
}

var clockID = 0;
function get_time_left() {
    var text = $('#timeLeft').html();
    text = text.split(":");
    var sec = $.trim(text[2]);
    var min = $.trim(text[1]);
    var hr = $.trim(text[0]);

    sec--;
    if(sec < 0){
        sec = (sec+60)%60;
        min--;
    }
    if(min < 0){
        min = (min+60)%60;
        hr--;
    }
    if(hr < 0){
        hr = (hr+24)%24;
    }

    if(clockID) {
        clearTimeout(clockID);
        clockID  = 0;
    }
    text = " " 	+ hr + ":"
    + min + ":"
    + sec;
    $('#timeLeft').html(text);
    clockID = setTimeout("get_time_left()", 1000);
}

/**
 * Load tripadvisor widget via ajax
 *
 * @author toanlk
 * @since  Apr 14, 2015
 */
function load_tripadvisor(id) {

    url = '';

    if(id == 'TA_rated56') {
        url = 'http://www.tripadvisor.com/WidgetEmbed-rated?uniq=56&locationId=4869921&lang=en_US&langversion=2';
    } else if(id == 'TA_certificateOfExcellence138') {
    	url = 'http://www.tripadvisor.com/WidgetEmbed-certificateOfExcellence?locationId=4869921&uniq=138&year=2015&lang=en_US&display_version=2';
    } else {
        url = 'http://www.tripadvisor.com/WidgetEmbed-selfserveprop?nreviews=0&uniq=417&iswide=false&locationId=4869921&rating=true&popIdx=false&border=true&writereviewlink=true&langversion=2&lang=en_US';
    }

    jQuery.ajax({
        type: "GET",
        url: url,
        success: function() {
        	$('#'+id).removeClass('tripad-placeholder');
            $('#'+id).removeClass('hide');
        },
        error:function(){
            //console.log('Failed load tripadvisor widget: '+id);
        },
        dataType: "script",
        cache: true
    });
}

/**
 * Load more cruises or tours via ajax
 *
 * @author toanlk
 * @since  Apr 14, 2015
 */
function load_more_cruise_tour_items(container, button) {

    $(button).click(function(e) {

        e.preventDefault();

        var limit = 10;
        var url = $(this).attr("data-link");
        var offset = $(button).attr("data-offset");
        var post_data = $(this).data();

        // data() function doesn't update value
        post_data.offset = offset;

        // load data
        show_loading_data();

        $.ajax({
            url: url,
            type: "POST",
            data: { data: post_data },
            success:function(value) {
                show_loading_data(false);


                if(value != '') {
                	// remove old button
                	if ( $(container+'_btn').length ) {
                		$(container+'_btn').remove();
                	}
                	
                	// update content
                    $(container).append(value);

                    // update offset
                    offset = parseInt(offset) + limit;
                    $(button).attr("data-offset", offset);

                    set_popover('.what-included');
                } else {
                    $(button).remove();
                }

            },
            error:function(var1, var2, var3){
                // do nothing
                show_loading_data(false);
            }
        });
    });
}

/**
 * Load arrow in offer via ajax
 *
 * @author huutd
 * @since  Jun 05, 2015
 */

function load_arrow_offer(item_id, is_equal) {

	$(item_id).each(function(){

			var self = this;

			var height = 0;

		    if (is_equal){
		        $(self).find('.item-offer').each(function(){
		            if($(this).height() > height) {

		                height = parseInt($(this).height(), 10);
		            }
		        });

		        $(self).find('.item-offer').css('height', height+10+'px');
		    }
		    else {
		        height =  parseInt($(self).find('.item-offer').height(), 10);
		    }

		    if(height > 0) {
		        height = (height + 10) / 2;
		        $(self).find('.item-offer-arrow-before').css('border-width', height+'px 16px');
		        $(self).find('.item-offer-arrow-after').css('border-width', height+'px 15px');
		    }


	});
}


/**
 * Check show hide for button show more
 * @author TinVM
 * @since July 15 2015
 */
function check_btn_show_more(btnId, numberItem, itemClass){
    var number_count = $(btnId).attr(numberItem);

    var count_item = $(itemClass).length;

    if(count_item >= number_count){
        $(btnId).hide();
    }
}

function update_url(param, value) {
	
	/*
	 * queryParameters -> handles the query string parameters
	 * queryString -> the query string without the fist '?' character
	 * re -> the regular expression
	 * m -> holds the string matching the regular expression
	 */
	var queryParameters = {}, queryString = location.search.substring(1),
	    re = /([^&=]+)=([^&]*)/g, m;
	 
	// Creates a map with the query string parameters
	while (m = re.exec(queryString)) {
	    queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
	}
	 
	// Add new parameters or update existing ones
	queryParameters[param] = value;
	//queryParameters['existingParameter'] = 'new value';
	 
	/*
	 * Replace the query portion of the URL.
	 * jQuery.param() -> create a serialized representation of an array or
	 *     object, suitable for use in a URL query string or Ajax request.
	 */
	
	var url = document.location.href;
	url = url.replace(/[#\?].*/,'');
	
	url_param = $.param(queryParameters); // Causes page to reload
	history.pushState({}, '', url + '?' + url_param);
}

/**
 * Initial mobile tab
 * 
 * toanlk - 22/07/2015
 */
function init_mobile_tab(id) {
	$(id+' a').click(function (e) {
		var href = $(this).attr('href');
		if(href.indexOf('#') == 0) {
			e.preventDefault();
		    $(this).tab('show');
		    
		    if (history.pushState) {
		    	update_url('activeTab', href.replace('#', ''));
		    }
		}
	});
}

/**
 * Set equal height div tags
 * 
 * Ex: equal_height('.div1, .div2');
 * 
 * toanlk - 22/07/2015
 */
function equal_height(str) {
	
	var ids = str.trim().split(",");
	
	for (i = 0; i < ids.length; i++) {
		
		var id = ids[i].trim();
		
		if ( $(id).length ) {
			
			// find the highest div
			var max_height = 0;
			$(id).each(function() {
				var height = $(this).height()
				max_height = height > max_height ? height : max_height;
			});
			
			// set equal height
			$(id).css('height', max_height);
		}
	}
}

/**
 * Initial shopping cart
 * 
 * huutd - 23/07/2015
 */

function initGUI() {

    if(jQuery("#divCart").length > 0) {
        $.ajax({
            url: "getcart/",
            type: "POST",
            cache: false,
            data: {
            },
            success:function(value){
                $("#divCart").append(value);
            }
        });
    }
}
