(function($) {
    $.fn.tipsy = function(options) {

        options = $.extend({}, $.fn.tipsy.defaults, options);
        
        return this.each(function() {
            
            var opts = $.fn.tipsy.elementOptions(this, options);
            
            $(this).hover(function() {

                $.data(this, 'cancel.tipsy', true);

                var tip = $.data(this, 'active.tipsy');
				var gravity = (typeof opts.gravity == 'function') ? opts.gravity.call(this) : opts.gravity;
                if (!tip) {
					ctn = '<div class="tipsy">';
					if(opts.title != 'title') {
						ctn += '<div class="tipsy-title">'+i18n.help+'</div>';
					}
					ctn += '<div class="tipsy-inner"/>';
					ctn += '<div class="tipsy-arrow"><div class="arrow-before"></div><div class="arrow-after"></div></div>';
					ctn += '</div>';
                    tip = $(ctn);
                    if(opts.width  != '') {
                    	$(tip).css('width', opts.width);
                    }
                    if(gravity.charAt(0)=='i'){$(tip).css('width', 'auto');}
                    $.data(this, 'active.tipsy', tip);
                }

                tip.find('.tipsy-inner')[opts.html ? 'html' : 'text'](opts.fallback);
                if(opts.title != 'title') {
                	tip.find('.tipsy-title')[opts.html ? 'html' : 'text'](opts.title);
                }

                var pos = $.extend({}, $(this).offset(), {width: this.offsetWidth, height: this.offsetHeight});
                tip.get(0).className = 'tipsy'; // reset classname in case of dynamic gravity
                tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).appendTo(document.body);
                var actualWidth = tip[0].offsetWidth, actualHeight = tip[0].offsetHeight;
                
                var scX = $(window).scrollLeft();
                var scY = $(window).scrollTop();
                var scMaxX = scX + $(window).width();
                var scMaxY = scY + $(window).height();
                //var down_arrow_pos = (actualHeight - 2) +'px';
                //var down_arrow_bg = '-175px -85px';
                //var up_arrow_pos = '-9px';
                //var up_arrow_bg = '-175px -65px';
                var contentHeight = pos.top + actualHeight + 25;
                var contentWidth = pos.left + actualWidth + 30;
                
                var direction = gravity.charAt(0);

                switch (direction) {
                   case 'n': // north
                	    //tip.find('.tipsy-arrow').css('background-position', down_arrow_bg);
                	    tip.find('.tipsy-arrow').addClass('tipsy-arrow-down');
                   		tip.find('.tipsy-arrow').removeClass('tipsy-arrow-up');
                	   	//tip.find('.tipsy-arrow').css('top', down_arrow_pos);
                	   	tip.css({top: pos.top - actualHeight, left: pos.left + pos.width/2 - 20});
                	   	//console.log('Go here 0');
                        break;
                    case 's': // south
                    	tip.find('.tipsy-arrow').addClass('tipsy-arrow-up');
                	    tip.find('.tipsy-arrow').removeClass('tipsy-arrow-down');
                   
                    	//tip.find('.tipsy-arrow').css('background-position', up_arrow_bg);
                 		//tip.find('.tipsy-arrow').css('top', up_arrow_pos);
                        tip.css({top: pos.top + pos.height + 10, left: pos.left + pos.width/2 - 20});
                        //console.log('Go here 1');
                        break;
                    case 'e': // east
                    	tip.find('img').each(function(index) {
                    		tip.find('.tipsy-inner')[opts.html ? 'html' : 'text']('<img src="media/loading.gif"> Loading ...');
                    		tip.find('.tipsy-arrow').css('display', 'none');
                    		actualWidth = 80; // loading block width
                    		$(this).bind("load", function()
            			    {
                    			actualWidth = this.width + 20;
                    			tip.css({top: pos.top, left: pos.left - actualWidth - 10});
                    			tip.find('.tipsy-arrow').css('display', '');
                    			tip.find('.tipsy-inner')[opts.html ? 'html' : 'text'](opts.fallback);
            			    }).attr('src', $(this).attr('src'));
                    	});
                    	tip.find('.tipsy-arrow').addClass('tipsy-arrow-right');
                        tip.css({top: pos.top, left: pos.left - actualWidth - 10});
                        //console.log('Go here right');
                        break;
                    case 'w': // west
                    	tip.find('img').each(function(index) {
                    		tip.find('.tipsy-inner')[opts.html ? 'html' : 'text']('<img src="media/loading.gif"> Loading ...');
                    		tip.find('.tipsy-arrow').css('display', 'none');
                    		actualWidth = 80;
                    		$(this).bind("load", function()
            			    {
                    			actualWidth = this.width + 20;
                    			tip.css({top: pos.top, left: pos.left + pos.width + 10});
                    			tip.find('.tipsy-arrow').css('display', '');
                    			tip.find('.tipsy-inner')[opts.html ? 'html' : 'text'](opts.fallback);
            			    }).attr('src', $(this).attr('src'));
                    	});
                    	tip.css({top: pos.top, left: pos.left + pos.width + 10});
                        break;
                }
                
                if(direction == 'n' || direction == 's') {
                	 if(contentHeight >= scMaxY) {
                 		//tip.find('.tipsy-arrow').css('background-position', down_arrow_bg);
                     	tip.find('.tipsy-arrow').addClass('tipsy-arrow-down');
                     	tip.find('.tipsy-arrow').removeClass('tipsy-arrow-up');
                 		tip.css('top', pos.top - actualHeight);
                 		//console.log('Go here 2');
                 	}
                	 
                    //console.log('top:'+ (pos.top - (actualHeight + 30))+'|scroll:'+scY);
					//if ((pos.top - (actualHeight + 30)) < scY) {
					//	tip.find('.tipsy-arrow').css('background-position', up_arrow_bg);
					//	tip.find('.tipsy-arrow').addClass('tipsy-arrow-up');
					//	tip.find('.tipsy-arrow').removeClass('tipsy-arrow-down');
					//	tip.find('.tipsy-arrow').css('top', up_arrow_pos);
					//	tip.css('top', pos.top + 30);
					//	console.log('Go here 3');
					//}
                     
                     if(contentWidth >= scMaxX) {
              		   tip.css('left', pos.left - actualWidth + 30);
              		   tip.find('.tipsy-arrow').css('left', actualWidth - 30);
              	    }
                }

                if (opts.fade) {
                    tip.css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: 0.8});
                } else {
                    tip.css({visibility: 'visible'});
                }

            }, function() {
                $.data(this, 'cancel.tipsy', false);
                var self = this;
                setTimeout(function() {
                    if ($.data(this, 'cancel.tipsy')) return;
                    var tip = $.data(self, 'active.tipsy');
                    if (opts.fade) {
                       tip.stop().fadeOut(function() { $(this).remove(); });
                    } else {
                       tip.remove();
                    }
                }, 100);

            });
            
        });
        
    };
    

    $.fn.tipsy.defaults = {
        fade: false,
        fallback: '',
        gravity: 'n',
        html: true,
        title: 'title'
    };
    
    $.fn.tipsy.elementOptions = function(ele, options) {
        return $.metadata ? $.extend({}, options, $(ele).metadata()) : options;
    };
})(jQuery);

(function($) {
    $.fn.tiptab = function(conf) {

        var config = jQuery.extend({
            selected:       0,                 // Which tab is initially selected (hash overrides this)
            show:           'show',            // Show animation
            hide:           'hide',            // Hide animation
            duration:       0,                 // Animation duration
            type:           0,                 // type 0 is normal, type 1 uses "data-name" attribute
            ajaxOptions:    {},
            select:    function () {return true}       // Callback after tab has been clicked
        }, conf);

        return this.each(function () {
            var root    = jQuery(this);
            var ul      = jQuery(this).find(".bpt-tabs");//.find( "ul" ).eq( 0 );
            var ipl     = 'a[href^="#"]';
            var ipl_sc  = 'a[data-name^="#"]';
            var selectedIndex = 1;
        
            // remove all selected
            ul.find('a').removeClass('selected');

            // select 
            ul.find('a').each(function (i) {
            	
                // remote tab
                if (! $(this).is(ipl) && config.type == 0) {

                    // Add remote data panel
                    var panelId = $(this).attr('title').replace(' ', '_');

                    $(this).attr('xhr', $(this).attr('href'));

                    $(this).attr('href', '#'+panelId);

                    var panel = $( "<div>" ).attr( "id", panelId );
                    root.append( panel );
                }

                // normal tabs
                if (i == config.selected) {
                    if ($(this).attr('xhr')) {
                        $.fn.tiptab.loadData($(this).attr('xhr'), $(this).attr('href'), config);
                    }
                    $(this).addClass('selected');
                }
            });

            // Go through all the in-page links in the ul
            // and hide all but the selected's contents
            if(config.type == 1) {
            	ul.find(ipl_sc).each(function (i) {
                    var link = jQuery(this);

                    if (i == config.selected) {

                        // fix change tab use external function
                        if(i > 0) {
                            window.location.hash = link.attr('data-name');
                        }
                    }
                    else {
                        jQuery(link.attr('data-name')).hide();
                    }
                });
            } else {
            	ul.find(ipl).each(function (i) {
                    var link = jQuery(this);

                    if (i == config.selected) {

                        // fix change tab use external function
                        if(i > 0) {
                            window.location.hash = link.attr('href');
                        }
                    }
                    else {
                        jQuery(link.attr('href')).hide();
                    }
                });
            }

            // When clicking the UL (or anything within)
            ul.click(function (e) {
                var clicked    = jQuery(e.target);
                var link    = false;
                var is_continue = true;
                
                var data_name = $(clicked).attr('data-name');
                
                var data_attr = 'href';
                
                if(config.type == 1 && data_name !== undefined && data_name !== false) {
                	data_attr = 'data-name';
                }
                
                e.preventDefault();

                if (clicked.is(ipl) || config.type == 1) {
                    link = clicked;
                }
                else {
                    var parent = clicked.parents(ipl);

                    if (parent.length) {
                        link = parent;
                    }
                }

                selectedIndex = $(clicked).parent().index();

                // Call back function
                is_continue = config.select(selectedIndex);

                if(!is_continue) return false;

                // Only continue if the clicked element was an in page link
                if (link) {
                    var selected = ul.find('a.selected');

                    // Ignore when click currently selected
                    if($(selected).attr(data_attr) == $(clicked).attr(data_attr)) {
                        return false;
                    }
                    
                    if (selected.length) {
                    	
                    	//console.log(selected);
                        // Remove currently .selected, hide the element it was pointing to
                        jQuery(selected.removeClass('selected').attr(data_attr))[config.hide](config.duration, function () {
                            
                        });
                        // Then show the element the clicked link was pointing to
                        jQuery(link.attr(data_attr))[config.show](config.duration, function () {
                            //config.select(selectedIndex);
                        });

                        if (link.attr('xhr')) {
                            $.fn.tiptab.loadData(link.attr('xhr'), link.attr(data_attr), config);
                        }

                        link.addClass('selected');
                    }
                    else {
                        jQuery(link.addClass('selected').attr(data_attr))[config.show](config.duration, function () {
                            //config.select(selectedIndex);
                        });
                    }

                    // Update the hash
                    $.fn.tiptab.updateHash(link.attr(data_attr));

                    return false;
                }
            });

            // If a hash is set, click that tab
            var hash = window.location.hash;

            if (hash) {
            	// We can't simply .click() the link since that will run the show/hide animation
            	if(config.type == 1) {
            		
            		jQuery(ul.find('a').removeClass('selected').attr('data-name')).hide();
                    jQuery(ul.find('a[data-name="' + hash + '"]').addClass('selected').attr('data-name')).show();
                    //config.select(selectedIndex);

                    var link = ul.find('a[data-name="' + hash + '"]');

                    if (link.attr('xhr')) {
                        $.fn.tiptab.loadData(link.attr('xhr'), link.attr('data-name'), config);
                    }
            	} else {            		
                    jQuery(ul.find('a').removeClass('selected').attr('href')).hide();
                    jQuery(ul.find('a[href="' + hash + '"]').addClass('selected').attr('href')).show();
                    //config.select(selectedIndex);

                    var link = ul.find('a[href="' + hash + '"]');

                    if (link.attr('xhr')) {
                        $.fn.tiptab.loadData(link.attr('xhr'), link.attr('href'), config);
                    }
            	}
            }
        });

    };


    $.fn.tiptab.updateHash = function(hash) {
        hash = hash.replace( /^#/, '' );
        var fx, node = $( '#' + hash );
        if ( node.length ) {
            fx = $( '<div></div>' )
                .css({
                    position:'fixed',
                    left:0,
                    top:0,
                    visibility:'hidden'
                })
                .attr( 'id', hash )
                .appendTo( document.body );
            node.attr( 'id', '' );
        }
        document.location.hash = hash;
        if ( node.length ) {
            fx.remove();
            node.attr( 'id', hash );
        }
    };

    $.fn.tiptab.loadData = function(anchor, panelId, config) {

        var indicator = $( "<div>" ).addClass( "txtC").html('<img src="/media/loading-indicator.gif"/>');
        $(panelId).empty().append(indicator);  	
        
        var _type = "GET";
        var _data = {};
        if(config.ajaxOptions && config.ajaxOptions.data) {
        	_type = "POST";
            _data = config.ajaxOptions.data;
        }

        $.ajax({ type: _type, url: anchor, data: _data, success: function(response) {
            $(panelId).empty().append(response);

            // handle url
            $(panelId).find('a').click(function(event) {

                var url = $(this).attr('href');

                var noAjax = false;
                if($(this).attr('datatype')) {
                    if($(this).attr('datatype') == 'no-ajax') {
                        noAjax = true;
                    }
                }

                if(url != 'javascript:void(0)' && !noAjax) {
                    event.preventDefault();
                    $.fn.tiptab.loadData(url, panelId, config);
                }
            });
        }
        });
    };

})(jQuery);

(function($) {
    $.fn.tiptip = function(options) {

        options = $.extend({}, $.fn.tiptip.defaults, options);
        
        return this.each(function() {
            
            var opts = $.fn.tiptip.elementOptions(this, options);
            
            $(this).click(function() {

                $.data(this, 'cancel.tiptip', true);

                var tip = $.data(this, 'active.tiptip');
				var gravity = (typeof opts.gravity == 'function') ? opts.gravity.call(this) : opts.gravity;
                if (!tip) {
					ctn = '<div class="tiptip">';
					if(opts.title != 'title') {
						ctn += '<div class="tiptip-title">'+i18n.help+'</div>';
					}
					ctn += '<div class="tiptip-inner"/>';
					btn_close = '<span class="box_btn_close">x</span>';
					footer_close = '<span class="btn-close">'+i18n.close+'</span>';
					ctn += '<div class="tiptip-footer">'+footer_close+'</div>';
					ctn += btn_close + '</div>';
                    tip = $(ctn);
                    if(opts.autowidth) {
						if(opts.fallback.length >= 400 && opts.fallback.length <= 500) {opts.width = 500;}
						if(opts.fallback.length < 400) {opts.width = 300;}
					}
                    if(opts.width  != '') {
                    	$(tip).css('width', opts.width);
                    }
                    if(gravity.charAt(0)=='i'){$(tip).css('width', 'auto');}
                    $.data(this, 'active.tiptip', tip);
                }

                tip.find('.tiptip-inner')[opts.html ? 'html' : 'text'](opts.fallback);
                if(opts.title != 'title') {
                	tip.find('.tiptip-title')[opts.html ? 'html' : 'text'](opts.title);
                }

                var pos = $.extend({}, $(this).offset(), {width: this.offsetWidth, height: this.offsetHeight});
                tip.get(0).className = 'tiptip'; // reset classname in case of dynamic gravity
                tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).appendTo(document.body);
                var actualWidth = tip[0].offsetWidth, actualHeight = tip[0].offsetHeight;
                
                // Close buttons
                tip.find('.box_btn_close').click(function() {            		
            		tip.remove();
            	});
                tip.find('.btn-close').click(function() {            		
            		tip.remove();
            	});
                
                // Close when users click ouside of dialog
                $(document).click(function(e) {
                	var evt = (e)?e:event;
                    var theElem = (evt.srcElement)?evt.srcElement:evt.target;
                    //console.log('Go here: '+e.target.className);
                    if (tip.has(e.target).length === 0 && theElem!="javascript:void(0)" && e.target.className!="tiptip") { 
                    	$('.tiptip').remove();
                    }
                });

                //var scX = $(window).scrollLeft();
                var scY = $(window).scrollTop();
                //var scMaxX = scX + $(window).width();
                var scMaxY = scY + $(window).height();
                var contentHeight = pos.top + actualHeight + 25;
                //var contentWidth = pos.left + actualWidth + 30;
                var rp_top = Math.round(pos.top);

                switch (gravity.charAt(0)) {
	                case 'n':
	                	var pos_top = rp_top - actualHeight;
	                	if(pos_top < 10) pos_top = 10;
	                	var pos_left = pos.left - actualWidth + this.offsetWidth;
	                	tip.find('.tipsy-arrow').css('display', 'none');
	             	   	tip.css({top: pos_top, left: pos_left});
	             	    if ((rp_top - (actualHeight)) < scY) {
	             	    	if(contentHeight >= scMaxY) {
	             	    		var extend = contentHeight - scMaxY;
	             	    		tip.css('top', rp_top - actualHeight - extend);
	             	    	} else {
	             	    		tip.css('top', rp_top);
	             	    	}
	                    }
	                    break;
	                case 's':
	             	   	tip.find('.tipsy-arrow').css('display', 'none');
	             	    var pos_top = rp_top + this.offsetHeight;
	             	    //var winHeight = window.innerHeight || $(window).height();
	                	var pos_left = pos.left - actualWidth + this.offsetWidth;
	                    tip.css({top: pos_top, left: pos_left});
	                    if(contentHeight >= scMaxY && rp_top > actualHeight) {
	                    	if ((rp_top - (actualHeight)) < scY) {
	                    		var extend = scY - (rp_top - (actualHeight));
	                    		if(rp_top > extend) {
	                    			tip.css('top', rp_top - extend);
	                    		}
		                    } else {
		                    	tip.css('top', rp_top - actualHeight);
		                    }
		               	}
	                    break;
                    case 'e':
                        tip.css({top: pos.top + pos.height - 35, left: pos.left - actualWidth - 10});
                        break;
                    case 'w':
                    	tip.css({top: pos.top + 35, left: pos.left + pos.width/2 - 20});
                        break;
                    case 'c':
                    	tip.css({top: pos.top + 35, left: pos.left + pos.width/2 - 20});
                        break;
                    case 'i':
                    	tip.css({top: pos.top + pos.height - 35, left: pos.left - actualWidth - 10});
                        break;
                }

                if (opts.fade) {
                    tip.css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: 0.8});
                } else {
                    tip.css({visibility: 'visible'});
                }
            }, function() {
            });
        });
        
    };

    $.fn.tiptip.elementOptions = function(ele, options) {
        return $.metadata ? $.extend({}, options, $(ele).metadata()) : options;
    };
    
    $.fn.tiptip.defaults = {
        fade: false,
        fallback: '',
        gravity: 'n',
        html: true,
        title: 'title',
        autowidth: false
    };
})(jQuery);

//Include: tipsy.js, tiptab.js, tiptip.js, main.js
function setAutocomplete(){					
	$( "#destinations" )         
         .bind( "keydown", function( event ) {
         		if ( event.keyCode === $.ui.keyCode.TAB &&
         			$( this ).data( "autocomplete" ).menu.active ) {
         			event.preventDefault();
         		}
          }).autocomplete({
       		minLength: 1,
       		autoFocus: true,
    		source: function(req, responseFn) {
		        var re = $.ui.autocomplete.escapeRegex(req.term);
		        var matcher = new RegExp( "^" + re, "i" );
		        var a = $.grep( GLOBALS[0], function(item,index){
		            return matcher.test(item[1]);
		        });
		        responseFn( a );
		    },
     		focus: function() {
     			// prevent value inserted on focus
     			return false;
     		},
     		select: function( event, ui ) {
				$("#destinations" ).val( ui.item[1]);

				return false;
            }
		})
		.data("autocomplete")._renderItem = (function (ul, item) {
    		t = "<span style='*float:left; *width:60%'>" + item[1] + "</span>";
    		t = t + "<span style='float:right;*float:left; *width:32%;*display:inline;*text-align: right;'>" + getRegion(item[2], item[3]) + "</span>";
			return $( "<li></li>" )
        	.data( "item.autocomplete", item )
        	.append( "<a>" + t + "</a>" )
        	.appendTo( ul );
			
		});

		// remove round corner
		$( "#destinations" ).autocomplete('widget').removeClass('ui-corner-all'); 
}	


function initSearchBox() {	
	if ($("#destinations").val() == $("#destinations").attr('alt')) {
		$("#destinations").css("color", "#808080");
		$("#destinations").css("font-style", "italic");		
	}
}

function get_des_selected_ids() {	
	if ($("#destinations").val() == ''
		|| $("#destinations").val() == $("#destinations").attr('alt')) {
		return null;
	}
	//var selected_dess = $("#destinations").val().split(',');
	/*for(var j=0; j<selected_dess.length; ++j) {	
		if(selected_dess[j] == '') {
			selected_dess.splice(j, 1);
		}
	}*/		
	
	var selected_dess = $("#destinations").val();
	
	selected_dess = $.trim(selected_dess);
	
	var selected_ids = new Array();
	var destinationData = GLOBALS[0];
	
	var k = 0;
	for(var i=0; i<destinationData.length; ++i) {		
		//for(var j=0; j<selected_dess.length; ++j) {	
			if (selected_dess != '' && destinationData[i][1] != ''
					&& $.trim(destinationData[i][1]) == selected_dess) {
				selected_ids[k] = destinationData[i][0];
				k++;
			}
		//}		
	}
	
	return selected_ids;
}

function searchfield_focus(obj)
{
	if (obj.value == $(obj).attr('alt')) {
		obj.value = "";
		obj.style.color = "";
		obj.style.fontStyle = "";
	}
}
function searchfield_blur(obj)
{	
	if (obj.value == "") {
		obj.value = $(obj).attr('alt');
		obj.style.color = "#808080";
		obj.style.fontStyle = "italic";
	}
}

function split( val ) {
	return val.split( /,\s*/ );
}
function extractLast( term ) {
	return split( term ).pop();
}

function check_travel_date(departure_date, alert_message) {
	var d = new Date();
	var str_date = departure_date.split('-');
	var date1 = new Date(d.getFullYear(), d.getMonth(), d.getDate()); 
	var date2 = new Date(parseInt(str_date[2], 10), [parseInt(str_date[1], 10)-1], parseInt(str_date[0], 10)); 
	if(date2 <= date1) { 
		alert(alert_message);
	}
}

function getSearchParams(){
	
	var params = "destination=" + $("#destinations").val() + "&departure_date=" + $("#departure_date").val();

	var travel_style = getSelectedTravelStyles();

	if (travel_style != ''){
		
		params = params + "&travel_styles=" + travel_style;
		
	}
	
	params = params + "&duration=" + $("#duration option:selected").text();
	
	params = params + "&group=" + $("#group_type").val();

	var class_sv = getSelectedClassServices();

	if (class_sv != ''){
					
		params = params + "&class_sv=" + class_sv;
		
	}

	if ($("#tour_type").attr("checked")){
		
		params = params + "&tour_type=private";
		
	}
	return params;
}

function getSelectedClassServices(){
	var selected = '';
	$("input[name^='class_service']:checked").each(function(index) {
		selected = selected + $(this).attr('alt') +':';
	});

	if (selected != ''){
		selected = selected.substring(0, selected.length - 1);
	}
	
	return selected;
}

var disabledDays = '';

function initDate(this_date, current_date, start_date_id, start_month_id, departure_date_id, night_id, departure_day_display_id, tour_departure, language_code) {
	
	if (night_id == undefined) night_id = '';
	
	if (departure_day_display_id == undefined) departure_day_display_id = '';
	
	if (tour_departure == undefined) tour_departure = '';
	
	// If get a posible closer departure date
	var arr_current = current_date.split('-');	
	var near_date = '';
	if(tour_departure != '' && typeof(arr_current[1]) != 'undefined') {
		var c_day = parseInt(arr_current[0], 10);
		var c_month = parseInt(arr_current[1], 10);
		var c_year = parseInt(arr_current[2], 10);
		
		if (!checkDate(c_day, c_month, c_year, tour_departure)) {
			near_date = getNearDepartureDate(c_day, c_month, c_year, tour_departure);
			if(near_date == '') near_date = this_date;
			current_date = near_date;
		}
	}
	
	initOptionMonth(this_date, current_date, start_month_id, tour_departure);
	
	initOptionDay(current_date, start_date_id, tour_departure);
	
	// if the closer departure date is not avaiable then select first date in combobox
	if(tour_departure != '' && near_date == this_date) {
		var f_day = $(start_date_id+" option:first").val();
		var f_month = $(start_month_id+" option:first").val();
		if(typeof(f_day) != 'undefined' && typeof(f_month) != 'undefined') {
			current_date = f_day+'-'+f_month;
		}
	}
	
	
	
	$(departure_date_id).val(current_date);
	
	if(typeof(tour_departure) != 'undefined' && tour_departure != '') {
		disabledDays = tour_departure;
	}
	
	
	$(departure_date_id).datepicker({showOn: 'button',dateFormat: 'dd-mm-yy', buttonImage: '/media/calendar.gif', buttonImageOnly: true,duration: '', buttonText:'Pick a date to check rates',
		onSelect: function(dateText, inst) {
			selectDate(dateText, start_date_id, start_month_id, tour_departure);
			getDepartureDay(dateText, night_id, departure_day_display_id);
			$(start_date_id).change();
		},
		beforeShowDay: function(date){
			
			if(typeof(tour_departure) != 'undefined' && tour_departure != '') {
				
				sDate = date.getDate();
				sMonth = date.getMonth()+1;
				
				if (checkDate(sDate, sMonth, date.getFullYear(), disabledDays)) {
					return [true, ""];
				} else {
					return [false,"","Unavailable"];
				}
			}
			
			return [true, ""];
		}
	});	
	
	$( departure_date_id ).datepicker( "option", $.datepicker.regional[ language_code ] );
	
	getDepartureDay(current_date, night_id, departure_day_display_id);
	
}

function getNearDepartureDate(date, month, year, tour_departure) {
	var near_departure = '';
	
	var select_date = new Date([month, date, year].join('/'));
	var nextDateIndexesByDiff = [];
    var prevDateIndexesByDiff = [];
    var objects = [];
	
    var cnt = 0;
	for(var i=0; i<tour_departure.length; ++i){
		var d_year = tour_departure[i][0];
		
		var d_month = tour_departure[i][1];
		
		for(var j=0; j<d_month.length; ++j){
			var d_day = tour_departure[i][1][j].date;
			d_day = d_day.split(',');
			for(var k=0; k<d_day.length; ++k){
				
				var thisDateStr = [d_month[j].month, d_day[k], d_year].join('/');
				thisDate    = new Date(thisDateStr),
		        curDiff     = select_date - thisDate;
				objects.push([cnt, thisDate]);

				curDiff < 0 ? nextDateIndexesByDiff.push([cnt, curDiff]): prevDateIndexesByDiff.push([cnt, curDiff]);
				cnt++;
			}
		}
	}
	
	nextDateIndexesByDiff.sort(function(a, b) { return a[1] < b[1]; });
	prevDateIndexesByDiff.sort(function(a, b) { return a[1] > b[1]; });

	//console.log('celected date', select_date);
	//console.log('closest future date', objects[nextDateIndexesByDiff[0][0]][1]);
	//console.log('closest past date', objects[prevDateIndexesByDiff[0][0]][1]);
	
	// Get closest date in future or past
	if(typeof(nextDateIndexesByDiff[0]) != 'undefined') {
		var c_day = objects[nextDateIndexesByDiff[0][0]][1].getDate();
		var c_month = objects[nextDateIndexesByDiff[0][0]][1].getMonth()+1;
		var c_year = objects[nextDateIndexesByDiff[0][0]][1].getFullYear();
		near_departure = c_day+'-'+c_month+'-'+c_year;
		
		//console.log('Closest date: ', near_departure);
	} else if(typeof(prevDateIndexesByDiff[0]) != 'undefined') {
		var c_day = objects[prevDateIndexesByDiff[0][0]][1].getDate();
		var c_month = objects[prevDateIndexesByDiff[0][0]][1].getMonth()+1;
		var c_year = objects[prevDateIndexesByDiff[0][0]][1].getFullYear();
		near_departure = c_day+'-'+c_month+'-'+c_year;
		
		//console.log('Closest date: ', near_departure);
	}
	
	return near_departure;
}

function selectDate(dateText, start_date_id, start_month_id, tour_departure) {

	var datearr = dateText.split('-');
	
	$.each($(start_month_id).attr("options"), function(i, obj) {
		optarr = obj.value.split('-');
		if (parseInt(datearr[1], 10) == parseInt(optarr[0], 10) 
				&& parseInt(datearr[2], 10) == parseInt(optarr[1], 10)) {
			obj.selected = true;
			initOptionDay(dateText, start_date_id, tour_departure);
			return;
		}
	})
	
}


function initOptionMonth(this_date, current_date, start_month_id, tour_departure) {
	var htmlMonths = '';
	var this_date_arr = this_date.split('-');
	var current_date_arr = current_date.split('-');
	var months = getMonthsAndYears(this_date_arr[1], this_date_arr[2], tour_departure);
	var current_month = current_date_arr[1];
	var current_year = current_date_arr[2];
	
	for(var i=0; i<months.length; ++i){
		var montharr = months[i].split('-');
		
		var s_year = montharr[1];
		var s_month = montharr[0];
		
		// for the tour that has specific departure dates
		if(typeof(tour_departure) != 'undefined' && tour_departure != '') {
			
			if(!checkMonth(s_month, s_year, tour_departure)) {
				continue;
			}
		}
		
		if (parseInt(current_month, 10) == parseInt(s_month, 10) && current_year == s_year) {
			htmlMonths += '<option value="' + months[i] +'" selected="selected" >' + month_names[s_month -1] + ', ' + s_year + '</option>';
		} else {
			htmlMonths += '<option value="' + months[i] +'">' + month_names[s_month -1] + ', ' + s_year + '</option>';
		}
	}
	
	$(start_month_id).html(htmlMonths);
	
}

function initOptionDay(current_date, start_date_id, tour_departure) {	
	var htmlDays = '';
	
	var current_date_arr = current_date.split('-');	
	
	var days = daysInMonth(current_date_arr[1], current_date_arr[2]);
	
	for(var i=0; i<days.length; ++i){
		
		// for tour that has specifice departure dates
		if(typeof(tour_departure) != 'undefined' && tour_departure != '') {
			var arrDate = days[i].split('-');
			if(!checkDate(arrDate[1], parseInt(current_date_arr[1], 10), current_date_arr[2], tour_departure)) {
				continue;
			}
		}
		
		var dayarr = days[i].split('-');
		if (parseInt(dayarr[1], 10) == parseInt(current_date_arr[0], 10)) {
			htmlDays += '<option value="' + dayarr[1] +'" selected>' + dayarr[0] + ', ' + dayarr[1] + '</option>';
		} else {
			htmlDays += '<option value="' + dayarr[1] +'">' + dayarr[0] + ', ' + dayarr[1] + '</option>';
		}
	}
	
	$(start_date_id).html(htmlDays);
}

function changeMonth(start_date_id, start_month_id, departure_date_id, night_id, departure_day_display_id, tour_departure) {
	
	var optionMonths = $(start_month_id).attr("options");
	
	var optionDays = $(start_date_id).attr("options");
	
	
	var montharr = optionMonths[optionMonths.selectedIndex].value.split('-');
	
	if(typeof optionDays[optionDays.selectedIndex] != 'undefined')
	{
		if (optionDays.selectedIndex > -1){
			
			var daySelected = optionDays[optionDays.selectedIndex].value;	
			var dateSelected = daySelected + '-' + montharr[0] + '-' + montharr[1];
			
			initOptionDay(dateSelected, start_date_id, tour_departure);
			
			changeDay(start_date_id, start_month_id, departure_date_id, night_id, departure_day_display_id);
			
		}
	}
}
function changeDay(start_date_id, start_month_id, departure_date_id, night_id, departure_day_display_id){
	
	var optionMonths = $(start_month_id).attr("options");
	
	var optionDays = $(start_date_id).attr("options");
	
	
	var daySelected = optionDays[optionDays.selectedIndex].value;	
	var montharr = optionMonths[optionMonths.selectedIndex].value.split('-');

	
	
	$(departure_date_id).val(daySelected + '-' + montharr[0] + '-' + montharr[1]);
	
	getDepartureDay(daySelected + '-' + montharr[0] + '-' + montharr[1], night_id, departure_day_display_id);

}

function changeNight(night_id, departure_date_id, departure_day_display_id){
	
	var	arrive_date = $(departure_date_id).val();
	
	getDepartureDay(arrive_date, night_id, departure_day_display_id);
	
}

function show_sortlist() {	
	$("#sortlist").show();	
}
function hide_sortlist() {	
	$("#sortlist").hide();
}

/**
 * 
 * LIB
 */

var month_names = i18n.month_names;
var daysofweek = i18n.days_of_week;

var LIMIT_MONTH = 18;
var FAVOURITE_TOURS = 'favourite_tours';

var MY_VIEWED_HOTELS = 'my_viewed_hotels';

var MY_VIEWED_CRUISES = 'my_viewed_cruises';

function getDepartureDay(selected_date, night_id, departure_day_display_id){
	
	if (night_id == undefined || night_id == ''){
		// do nothing
	} else {
		
		var nights = '';
		
		nights = parseInt($(night_id).val());
		
		var selected_date_arr = selected_date.split('-');
		
		var selected_date_obj = new Date(parseInt(selected_date_arr[2], 10), parseInt(selected_date_arr[1], 10) - 1, parseInt(selected_date_arr[0], 10));
		
		selected_date_obj.setDate(selected_date_obj.getDate() + nights);
		
		var depart_display = month_names[selected_date_obj.getMonth()] + " " + selected_date_obj.getFullYear();
		
		depart_display = daysofweek[selected_date_obj.getDay()] + " " + selected_date_obj.getDate() + " " + depart_display;
		
		$(departure_day_display_id).text(depart_display);
		
	}
	
}

/**
 * 
 * @param this_month
 * @param this_year
 * @return
 */
function getMonthsAndYears(this_month, this_year, tour_departure) {
	this_month = parseInt(this_month, 10);
	this_year = parseInt(this_year, 10);
	
	if(tour_departure != '') LIMIT_MONTH = 18;
	
	var monthsAndYears = new Array();
	t_nextmonth = new Date(this_year, this_month -1 , 1);	
	for (var i = 0; i < LIMIT_MONTH; ++i) {	
		n_month = t_nextmonth.getMonth() + 1;		
		n_year = t_nextmonth.getFullYear();
		monthsAndYears.push(n_month + "-" + n_year);		
		
		t_nextmonth.setMonth(n_month);
	}
	return monthsAndYears;
}

function daysInMonth(iMonth, iYear)
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

function getRegion(region, parent) {	
	if (parent != null && parent != "") {
		return parent;
	}
	
	return "";
}
if(!Array.indexOf){
    Array.prototype.indexOf = function(obj){
        for(var i=0; i<this.length; i++){
            if(this[i]==obj){
                return i;
            }
        }
        return -1;
    }
}
if(!String.replaceAll){
	String.prototype.replaceAll = function(find,replace){
	  	var temp = this;
	
	    var index = temp.indexOf(find);
	    while(index != -1){
	        temp = temp.replace(find,replace);
	        index = temp.indexOf(find);
	    }
	
	    return temp;
	}
}
function unique(arr) {
	tmpArr = new Array(0);
	for(var i = 0; i < arr.length; i++){
		if(arr[i] != '' && tmpArr.indexOf(arr[i]) == -1){
   			tmpArr.length += 1;
   			tmpArr[tmpArr.length-1] = arr[i];
  		}
 	}

 	return tmpArr;
}


function checkDate(date, month, year, tour_departure) {
	var check = false;
	for(var i=0; i<tour_departure.length; ++i){
		if(typeof(tour_departure[i]) == 'undefined' || tour_departure == '') continue;
		
		if(year == tour_departure[i][0]) {
			
			var index = get_index_of_month(tour_departure[i][1], month);
			if(index > -1) {
				var arrDate = tour_departure[i][1][index].date;
				arrDate = arrDate.split(',');
				for(var j=0; j<arrDate.length; ++j){
					if(parseInt(date, 10) == parseInt(arrDate[j], 10)) {
						check = true;
					}
				}
			}
		}
	}
	return check;
}

function get_index_of_month(arr, month) {
	
	for(var i=0; i<arr.length; ++i){
		
		if(parseInt(arr[i].month) == parseInt(month)) {
			return i;
		}
	}
	
	return -1;
}

function getMonthsAndYearsCheckRates(this_month, this_year) {
	this_month = parseInt(this_month, 10);
	this_year = parseInt(this_year, 10);
	
	var monthsAndYears = new Array();
	t_nextmonth = new Date(this_year, this_month -1 , 1);	
	for (var i = 0; i < LIMIT_MONTH; ++i) {	
		n_month = t_nextmonth.getMonth() + 1;		
		n_year = t_nextmonth.getFullYear();
		monthsAndYears.push(n_month + "-" + n_year);		
		
		t_nextmonth.setMonth(n_month);
	}
	return monthsAndYears;
}


function checkMonth(month, year, tour_departure) {
	
	for(var i=0; i< tour_departure.length; ++i){
		
		if(typeof(tour_departure[i]) == 'undefined') continue;
		
		if(year == tour_departure[i][0]) {
			
			if(get_index_of_month(tour_departure[i][1], month) > -1) {
				
				return true;
				
			}
		}
	}
	
	return false;
}






function getTomorrow() {
	var today = new Date();
	var td = today.getDate();
	var tm = today.getMonth();
	var ty = today.getFullYear();
	var tomorrow=new Date(ty,tm,td+1);
	
	return tomorrow;
}

/**
 * Hotel booking
 */
function checkRoomTypeBooking(hotel_id){
	var ret = false;
	$('.room_select_'+hotel_id).each(function(){
		//alert($(this).val());

		var rooms = $(this).find("option:selected").val();
		
		if (rooms > 0){
			
			ret = true;	
		
		}
	});

	return ret;
}

function openRoomTypeInfo(id){

	var img_class = $('#img_' + id).attr('class');
	
	if (img_class == 'togglelink'){

		$('#img_' + id).removeClass('togglelink');
		
		$('#img_' + id).addClass('togglelink_open');		

		$('#detail_infor_' + id).show();
		
	} else {

		$('#img_' + id).removeClass('togglelink_open');
		
		$('#img_' + id).toggleClass('togglelink');	
		
		$('#detail_infor_' + id).hide();
	}
	
	return false;								
}

function openExtrabedInfo(id){
	
	var img_class = $('#img_extra_' + id).attr('class');
		
	if (img_class == 'togglelink'){
	
		$('#img_extra_' + id).removeClass('togglelink');
		
		$('#img_extra_' + id).addClass('togglelink_open');		
	
		$('#extra_bed_' + id + '_select').show();
		
	} else {
	
		$('#img_extra_' + id).removeClass('togglelink_open');
		
		$('#img_extra_' + id).toggleClass('togglelink');	
		
		$('#extra_bed_' + id + '_select').hide();
	}
	
	return false;								
}

function show_hotel_detail(url_title, atts) {
	
	var url = "/hotel_detail/detail/" + url_title;
	
	window.open(url, '_blank', atts);
	
}

/**
*	Tour Booking
*/
function addDays(myDate,days) {
	return new Date(myDate.getTime() + days*24*60*60*1000);
}

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
function check_error_check_rates(tour_id){

	var is_error = false;

	var object_change = $("#object_change_" + tour_id).val();
	

	if (object_change == 'change_cabin'){
	
		var num_cabin = $("#num_cabin_" + tour_id + " option:selected").val();

		
		
		for (var i = 1; i <= num_cabin; i++){

			var type = parseInt($("#" + tour_id + "_type_" + i + " option:selected").val());
			
			var adults = parseInt($("#" + tour_id + "_adults_" + i + " option:selected").val());

			var children = parseInt($("#" + tour_id + "_children_" + i + " option:selected").val());

			var infants = parseInt($("#" + tour_id + "_infants_" + i + " option:selected").val());

			//alert(adults);

			if (adults + children + infants > 3){
				$("#" + tour_id + "_errors_" + i).show();
				
				$("#" + tour_id + "_errors_" + i + "_1").show();
				$("#" + tour_id + "_errors_" + i + "_2").hide();
				$("#" + tour_id + "_errors_" + i + "_3").hide();

				is_error = true;

				//break;
			} else 

			if (adults + children == 0){

				$("#" + tour_id + "_errors_" + i).show();
				
				$("#" + tour_id + "_errors_" + i + "_2").show();
				$("#" + tour_id + "_errors_" + i + "_1").hide();
				$("#" + tour_id + "_errors_" + i + "_3").hide();


				is_error = true;

				//break;
				
			} else 

			if (adults + children != 1 && type == 3){

				$("#" + tour_id + "_errors_" + i).show();
				
				$("#" + tour_id + "_errors_" + i + "_3").show();
				$("#" + tour_id + "_errors_" + i + "_1").hide();
				$("#" + tour_id + "_errors_" + i + "_2").hide();


				is_error = true;

				//break;
				
			}
		
		}

	}

	return is_error;
	
}

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

function get_end_date_of_tour(start_date_id, start_month_id, end_date_id, duration, tour_departure_up_stream, tour_departure_down_stream) {
	
	var departure_day = $(start_date_id).val();
	
	var departure_month = $(start_month_id).val();
	
	if (departure_day != '' && departure_day != null && departure_month != '' && departure_month != null){
	
		departure_month = departure_month.split('-');
		
		var d_year  = parseInt($.trim(departure_month[1]));
		var d_month = parseInt($.trim(departure_month[0])) -1 ;
		var d_date  = parseInt($.trim(departure_day));
		var endDate = new Date(d_year, d_month, d_date);
		
		endDate.setDate(endDate.getDate() + duration); 
		var month_names = i18n.month_names;
	
		var txt_EndDate = endDate.getDate()+' '+month_names[endDate.getMonth()]+', '+endDate.getFullYear();
	
		var direction = "";
		if(typeof(tour_departure_up_stream) != 'undefined' && tour_departure_up_stream != '') {
			for(var i=0; i<tour_departure_up_stream.length; ++i){
				var depart = d_date+"-"+(d_month+1)+"-"+d_year;
				if(depart == tour_departure_up_stream[i]) 
					direction = " ("+i18n.cruise_upstream+")";
			}
		}
		if(typeof(tour_departure_down_stream) != 'undefined' && tour_departure_down_stream) {
			for(var i=0; i<tour_departure_down_stream.length; ++i){
				var depart = d_date+"-"+(d_month+1)+"-"+d_year;
				if(depart == tour_departure_down_stream[i]) 
					direction = " ("+i18n.cruise_downstream+")";
			}
		}
	
		txt_EndDate = txt_EndDate + direction;
		$(end_date_id).html(txt_EndDate);
	
	}
}

function show_tour_detail(url_title, atts) {
	
	var url = "/tour_detail/detail/" + url_title+'.html';
	
	window.open(url, '_blank', atts);
	
}

function show_accomm_detail(id){
	
	var accomm_detail_id = "accomm_detail_" + id;

	var img_class = $('#img_' + id).attr('class');
	
	if (img_class == 'togglelink'){

		$('#img_' + id).removeClass('togglelink');
		
		$('#img_' + id).addClass('togglelink_open');		

		$('#accomm_detail_' + id).show();
		
	} else {

		$('#img_' + id).removeClass('togglelink_open');
		
		$('#img_' + id).toggleClass('togglelink');	
		
		$('#accomm_detail_' + id).hide();
	}

	return false;								
}

function setAjaxAutocomplete(type, data){	
	
	$("#destination_ajax_"+type)         
         .bind( "keydown", function( event ) {
         		if ( event.keyCode === $.ui.keyCode.TAB &&
         			$( this ).data( "autocomplete" ).menu.active ) {
         			event.preventDefault();
         		}
          }).autocomplete({
       		minLength: 1,
       		autoFocus: true,
    		source: function(req, responseFn) {
		        var re = $.ui.autocomplete.escapeRegex(req.term);
		        var matcher = new RegExp( "^" + re, "i" );
		        var a = $.grep( data, function(item,index){
		        	if (type.toLowerCase().indexOf("hotel") >= 0) {
		        		return matcher.test(item.name);
		        	} else {
		        		return matcher.test(item[1]);
		        	}
		        });
		        responseFn( a );
		    },
     		focus: function() {
     			// prevent value inserted on focus
     			return false;
     		},
     		select: function( event, ui ) {
     			if (type.toLowerCase().indexOf("hotel") >= 0) {
     				$("#destination_ajax_"+type).val( ui.item.name);
	        	} else {
	        		$("#destination_ajax_"+type).val( ui.item[1]);
	        	}

				return false;
            }
		})
		.data("autocomplete")._renderItem = (function (ul, item) {
			var name;var region; var parent;
			if (type.toLowerCase().indexOf("hotel") >= 0) {
				name = item.name;
				region = item.region;
				parent = item.parent;
        	} else {
        		name = item[1];
				region = item[2];
				parent = item[3];
        	}
    		t = "<span style='*float:left; *width:60%'>" + name + "</span>";
    		t = t + "<span style='float:right;*float:left; *width:40%;*display:inline;*text-align: right;'>" + getRegion(region, parent) + "</span>";
			return $( "<li></li>" )
        	.data( "item.autocomplete", item )
        	.append( "<a>" + t + "</a>" )
        	.appendTo( ul );
			
		});

		// remove round corner
		$("#destination_ajax_"+type).autocomplete('widget').removeClass('ui-corner-all'); 
}

function getSelectedTourAjax(type){
	var selected_dess = $("#destination_ajax_"+type).val();
	
	selected_dess = $.trim(selected_dess);
	var destinationData = GLOBALS[0];
	
	for(var i=0; i<destinationData.length; ++i) {		
		if (destinationData[i][1] == selected_dess) {
			return destinationData[i][0];
		}	
	}

	return null;
}

function getSelectedHotelAjax(type){
	if ($("#destination_ajax_"+type).val() == '') return null;

	for(var i = 0; i < destinations.length; i++){
		if (destinations[i].name == $("#destination_ajax_"+type).val()){
			if(destinations[i].object_type == 1) {
				return destinations[i].name; // if it's a hotel
			} else {
				return destinations[i].id;
			}
		}
	}
}


function show_block(obj, block_id){

	var block_search_content_id = '#block_search_content_' + block_id;

	var show_more_id = '#show_more_' + block_id;
	
	var block_class = $(obj).attr('show');

	//alert(block_class);
	
	if (block_class == 'hide'){

		$(obj).attr('show','show');
		
		$(block_search_content_id).show();

		$(show_more_id).show();
		
	} else {

		$(obj).attr('show','hide');	
		
		$(block_search_content_id).hide();

		$(show_more_id).hide();
	}
}

function show_cruise_detail(url_title, atts) {
	
	var url = "/cruise_detail/detail/" + url_title;
	
	window.open(url, '_blank', atts);
	
}

function getPriceNumber(price_text){
	price_text = price_text.replace("$","");
	price_text = $.trim(price_text);
	return getFormatNumber(price_text);
}

function getFormatNumber(text) {
	text = text.replace(",","");
	return Number(text);
}

function show_booking(rowid){
	
	var img_id = '#' + rowid + "_img_booking";

	var booking_content_id = '#' + rowid + "_booking_content";

	var booking_total_id = '#' + rowid + "_booking_total";

	var src = $(img_id).attr("src"); 

	if (src == "/media/btn_mini.gif"){

		src = "/media/btn_mini_hover.gif";

		$(img_id).attr("src", src);

		$(booking_content_id).show();

		$(booking_total_id).hide();
		
	} else {

		src = "/media/btn_mini.gif";

		$(img_id).attr("src", src);

		$(booking_content_id).hide();

		$(booking_total_id).show();
	}
}

var clockID = 0;
function getTimeLeft() {
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
	clockID = setTimeout("getTimeLeft()", 1000);
}

function initSearchForm(this_date, current_date, language_code){
	
	if($('input:radio[name="search_type"]')[0]) {
		$('input:radio[name="search_type"]')[0].checked = true;
	}

	initSearchBox();
	initDate(this_date, current_date, '#departure_day', '#departure_month', '#departure_date', language_code);
	setAutocomplete();
	
	$('#search_help').tipsy({fallback: $('#search_help_content').val(), gravity: 's', width: 'auto', title: i18n.help});
	$('#tour_type_help').tipsy({fallback: $('#tour_type_help_content').val(), gravity: 's', width: 'auto', title: i18n.help});
	$('#destination_help').tipsy({fallback: $('#destination_help_content').val(), gravity: 's', width: 'auto', title: i18n.help});
	$('#travel_style_help').tipsy({fallback: $('#travel_style_help_content').val(), gravity: 's', width: 'auto', title: i18n.help});
	
}

function change_search_type(ele, this_date, current_date, language_code){
	var type = $(ele).val();
	if(type == 2){
		$('#frmSearchForm').css('display', 'none');
		$('#block_hotel_search_form').css('display', 'block');
		$('#search_help').tipsy({fallback: $('#hotel_help').val(), gravity: 's'});
	} else {
		$('#block_hotel_search_form').css('display', 'none');
		$('#frmSearchForm').css('display', 'block');
		if ($("#destinations").val() == $("#destinations").attr('alt')) {
			$("#destinations").css("color", "#808080");
			$("#destinations").css("font-style", "italic");		
		}

		initSearchForm(this_date, current_date, language_code);
	}
}

function search(alert_message, search_url) {
	var check = true;
	var selected_dess = get_des_selected_ids();
	
	if (selected_dess != null && selected_dess.length > 0) {
		$("#destination_ids").val(selected_dess);
		$("#is_cruise_port").val('');
	} else {
		alert(i18n.search_destination_required);
		check = false;
		return false;
	}
	if(check) {
		check_travel_date($("#departure_date").val(), alert_message);
		
		document.frmSearchForm.action = search_url + getSearchParams();
		document.frmSearchForm.submit();
	}
}

function getSelectedTravelStyles(){
	var selected_styles = '';

	for(var i=0; i<GLOBAL_TRAVEL_STYLE.length; ++i) {
		if($("#travelstyle_"+i).attr("checked")){
   			selected_styles = selected_styles + GLOBAL_TRAVEL_STYLE[i].name + ":";
   		}
	}

	if (selected_styles != ''){
		selected_styles = selected_styles.substring(0, selected_styles.length - 1);
	}

	return selected_styles;
}

/**
 * 
 * BOOK SERVICE TOGETHER
 * 
 */

function click_book_together(url_title_1, url_title_2, mode){

	window.location.href = '/book-together/' + url_title_1 + '/' + url_title_2 + '/' + mode + '/';
	
}

function back_to_top(){
	$("html, body").animate({ scrollTop: 0}, "fast");
}

function go_bottom(){
	$("html, body").animate({ scrollTop: $(document).height()-$(window).height()}, "slow");
}

function go_book_together_position(){
	
	$("html, body").animate({ scrollTop: $("#booking_together_section").offset().top}, "fast");
}

// show the recommendation service check rate (tour-booking page)
function show_service(id, url){
	
	var img_id = '#' + id + "_img_collapse";

	var src = $(img_id).attr("src"); 

	if (src == '/media/btn_mini.gif'){
		
		src = '/media/btn_mini_hover.gif';

		$(img_id).attr("src", src);

		$('div#'+id).show();

		var loaded = $('div#'+id).attr("load");

		if (loaded != "loaded"){
		
			$.ajax({
				url: url,
				type: "POST",
				data: '',
				success:function(value){
					$('div#'+id).html(value);
					$('div#'+id).attr("load","loaded");
				}
			});

		}

		$('#'+ id + '_button_book').hide();

		$('.plus_icon_'+ id).show();
	} else {

		src = '/media/btn_mini.gif';

		$(img_id).attr("src", src);

		$('div#'+id).hide();

		$('#'+ id + '_button_book').show();
		
	}
}

function search_more(block_id, url, check_des, s_type){

	if (check_des != undefined) {
		
		if (s_type == 'hotel'){

			var destination_id = getSelectedHotelAjax(block_id);
			
		} else {
			var destination_id = getSelectedTourAjax(block_id);
		}
		

		if (destination_id == null || destination_id == ''){
		
			alert(i18n.search_destination_required);
			
			$("#destination_ajax_"+block_id).focus();
	
			return false;

		} else {
			
			$('#destination_id_' + block_id).val(destination_id);
		}
		
	} 
	
	if (url == undefined || url == ''){	
		url = $("#form_" + block_id).attr('action');
	}
	
	var dataString = $("#form_" + block_id).serialize();

	var block_search_content_id = '#block_search_content_' + block_id;

	$("html, body").animate({ scrollTop: $("#block_recommendation_" + block_id).offset().top}, "fast");
	
	if ($('#block_search_result_' + block_id).length > 0){
		showIndicator('#block_search_result_' + block_id);
	} else {
		showIndicator(block_search_content_id);
	}
	
	$.ajax({

		url: url,

		type: "POST",

		data: dataString,
		
		success:function(value){

			$(block_search_content_id).html(value);
		}
	});

	$('#show_more_'+block_id).css('display', 'none');	
}

function showIndicator(block_search_content_id) {

	var imgIndicator = '/media/loading-indicator.gif';
	
	$(block_search_content_id).html('<div style="width:100%;text-align:center;"><img src="'+imgIndicator+'"/></div>');
}

function bt_sort_by(block_id, sort_value, s_type){

	$('#sort_by_' + block_id).val(sort_value);
	
	search_more(block_id, '', '1', s_type);
}

function go_check_rate_position(){
	
	$("html, body").animate({ scrollTop: $("#tabs").offset().top}, "fast");
}

function go_url(url){
	window.location.href = url;
}

/*
 * GET CRUISE OVEVIEW POPUP 
 */

function close_popup(){
	$('#overlay_popup').hide();
	$('#popup_container').hide();
	$('#popup_content').html('');
}

function see_cruise_overview(cruise_id, departure_date, cruise_name){
	
	var de_date = getCookie('departure_date');
	
	if (de_date == null || de_date == ''){
		
	} else {
		departure_date = de_date;
	}
	
	if (cruise_name == null || cruise_name == undefined){
		cruise_name = '';
	}
	
	$("#popup_content").html('<center><img alt="" src="http://www.bestpricevn.net/media/loading-indicator.gif"></center>');

	var screenTop = $(document).scrollTop() + 60;

	$('#popup_container').css('top', screenTop);
	
	
	$('#overlay_popup').show();

	$('#popup_container').show();
	
	$.ajax({
		url: "/cruise_detail/see_overview/",
		type: "POST",
		cache: true,
		data: {
			"cruise_id":cruise_id,
			"departure_date": departure_date,
			"cruise_name": cruise_name
		},
		success:function(value){
							
			$("#popup_content").html(value);	

		}
	});	
	
}

function see_more_deals(tour_id, departure_date){

	$("#popup_content").html('<center><img alt="" src="http://www.bestpricevn.net/media/loading-indicator.gif"></center>');

	var screenTop = $(document).scrollTop() + 80;

	$('#popup_container').css('top', screenTop);
	
	
	$('#overlay_popup').show();

	$('#popup_container').show();
	
	$.ajax({
		url: "/tour_search/see_more_deals/",
		type: "POST",
		cache: true,
		data: {
			"tour_id":tour_id,
			"departure_date":departure_date					
		},
		success:function(value){
							
			$("#popup_content").html(value);	

		}
	});	
	
}

function see_tour_overview(tour_id, departure_date, tour_name){
	
	var de_date = getCookie('departure_date');
	
	if (de_date == null || de_date == ''){
		
	} else {
		departure_date = de_date;
	}
	
	if (tour_name == null || tour_name == undefined){
		tour_name = '';
	}
	
	
	$("#popup_content").html('<center><img alt="" src="http://www.bestpricevn.net/media/loading-indicator.gif"></center>');

	var screenTop = $(document).scrollTop() + 60;

	$('#popup_container').css('top', screenTop);
	
	
	$('#overlay_popup').show();

	$('#popup_container').show();
	
	$.ajax({
		url: "/tour_search/see_overview/",
		type: "POST",
		cache: true,
		data: {
			"tour_id":tour_id,
			"departure_date":departure_date,
			"tour_name": tour_name
		},
		success:function(value){
							
			$("#popup_content").html(value);	

		}
	});	
	
}

function see_hotel_overview(hotel_id, arrival_date, hotel_name){
	
	var ar_date = getCookie('arrival_date');
	
	if (ar_date == null || ar_date == ''){
		
	} else {
		arrival_date = ar_date;
	}
	
	if (hotel_name == null || hotel_name == undefined){
		hotel_name = '';
	}
	
	$("#popup_content").html('<center><img alt="" src="http://www.bestpricevn.net/media/loading-indicator.gif"></center>');

	var screenTop = $(document).scrollTop() + 60;

	$('#popup_container').css('top', screenTop);
	
	
	$('#overlay_popup').show();

	$('#popup_container').show();
	
	$.ajax({
		url: "/hotel_detail/see_overview/",
		type: "POST",
		cache: true,
		data: {
			"hotel_id":hotel_id,
			"arrival_date": arrival_date,
			"hotel_name": hotel_name
		},
		success:function(value){
							
			$("#popup_content").html(value);	

		}
	});	
	
}

function see_destination_overview(destination_id, departure_date, destination_name){
	
	var de_date = getCookie('departure_date');
	
	if (de_date == null || de_date == ''){
		
	} else {
		departure_date = de_date;
	}
	
	if (destination_name == null || destination_name == undefined){
		destination_name = '';
	}
	
	$("#popup_content").html('<center><img alt="" src="http://www.bestpricevn.net/media/loading-indicator.gif"></center>');

	var screenTop = $(document).scrollTop() + 60;

	$('#popup_container').css('top', screenTop);
	
	
	$('#overlay_popup').show();

	$('#popup_container').show();
	
	$.ajax({
		url: "/destination/see_overview/",
		type: "POST",
		cache: true,
		data: {
			"destination_id": destination_id,
			"destination_name":destination_name,
			"departure_date": departure_date
		},
		success:function(value){
							
			$("#popup_content").html(value);	

		}
	});	
	
}

function see_activity_overview(activity_id, activity_name, departure_date){
	
	var de_date = getCookie('departure_date');
	
	if (de_date == null || de_date == ''){
		
	} else {
		departure_date = de_date;
	}
	
	if (activity_name == null || activity_name == undefined){
		activity_name = '';
	}
	
	$("#popup_content").html('<center><img alt="" src="http://www.bestpricevn.net/media/loading-indicator.gif"></center>');

	var screenTop = $(document).scrollTop() + 60;

	$('#popup_container').css('top', screenTop);
	
	
	$('#overlay_popup').show();

	$('#popup_container').show();
	
	$.ajax({
		url: "/destination/see_activity_overview/",
		type: "POST",
		cache: true,
		data: {
			"activity_id": activity_id,
			"activity_name":activity_name,
			"departure_date": departure_date
		},
		success:function(value){
							
			$("#popup_content").html(value);	

		}
	});	
	
}


function show_hide_img(obj){

	var stat = $(obj).attr('stat');

	if (stat == 'hide'){

		$('.img_hide').show();

		$(obj).attr('stat', 'show');

		$(obj).html('Show less &laquo;');
		
	} else {

		$('.img_hide').hide();

		$(obj).attr('stat', 'hide');

		$(obj).html('Show more &raquo;');
	}	

}

function get_tour_prices_ajax(departure_date, txt_currency, txt_per_pax, txt_offers, txt_na){
	if(typeof tour_ids != 'undefined' && tour_ids !='')
	{

	var current_date = getCookie('departure_date');

	if (current_date == null || current_date ==''){
		current_date = departure_date;
	}
			
	$.ajax({
		url: "/vietnam_tours/get_tour_prices/",
		type: "POST",
		cache: true,
		dataType: "json",
		data: {	
			"tour_ids": tour_ids,
			"departure_date": current_date						
		},
		success:function(value){
			
			for(var i = 0; i < value.length; i++){

				var tour = value[i];
				var fromPrice = txt_currency + tour.f_price;
				if(tour.f_price == 0) {
					fromPrice = txt_na;
					$('.'+ tour.id + 'from_label').html('');
				}
				
				$('.'+ tour.id + 'from_price').html(fromPrice);
				$('.'+ tour.id + 'from_price').parent().parent().append(txt_per_pax);

				$('.'+ tour.id + 'block_price').show();
				
				if(tour.d_price != 0) {
					$('.'+ tour.id + 'promotion_price').html(txt_currency + tour.d_price);
					$('.'+ tour.id + 'block_pro_price').show();
				} else {
					$('.'+ tour.id + 'block_pro_price').hide();
				}
				
				if(tour.text_promotion != '') {
					var text = tour.text_promotion.split(',');
					for(var j=0; j<text.length; ++j) {

						if ($('#'+tour.id+'_offer_title').attr('rel') == 'best_tour'){

							$('.'+ tour.id + 'text_promotion').append('<li><span class="icon icon_checkmark"></span><a class="special" href="javascript:void(0)" id="promotion_' + tour.id + '_' + tour.promotion_id + '_' + j + '">' + text[j] + ' &raquo;</a></li>');
							
						} else {	
							$('.'+ tour.id + 'text_promotion').append('<li><a class="special" href="javascript:void(0)" id="promotion_' + tour.id + '_' + tour.promotion_id + '_' + j + '">' + text[j] + ' &raquo;</a></li>');							
						}
						
						$('#promotion_' + tour.id + '_' + tour.promotion_id + '_' + j).tiptip({fallback: tour.deal_content, gravity: 's', title: tour.deal_title, width: '400px'});
					}
					if (tour.is_hot_deal == 0){
						if ($('#'+tour.id+'_offer_title').attr('rel') == 'best_tour'){
							$('#'+tour.id+'_offer_title').show();
						} else {
							$('#'+tour.id+'_offer_title').html(txt_offers+':');
						}
					}
					$('.'+ tour.id + 'block_text_promotion').show();
				} 
			}
			
		}
	});	
	}
}

function getCookie(c_name) {
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1) {
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1) {
		c_value = null;
	} else {
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1) {
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start, c_end));
	}
	return c_value;
}

function getRandomImage() {
	var length = $('#top-ads a').length;
    var num = Math.floor( Math.random() * length );
	$('#top-ads a').eq(num).show();
}

var ads_index = 0;

function changeImage(){
	var $ads_imgs = $('#top-ads a');
    var next = (++ads_index % $ads_imgs.length);
    $($ads_imgs.get(next - 1)).fadeOut(1000, function() {
    	$($ads_imgs).hide();
    	$($ads_imgs.get(next)).fadeIn(1500);
    });
}

function initGUI() {

	setInterval(changeImage, 7000);
	getRandomImage();

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
	
	$.ajax({
		url: "home/getmobilelink/",
		type: "POST",
		cache: false,
		data: {								
		},
		success:function(value){									
			$("#about_bpt").append(value);
		}
	});
}