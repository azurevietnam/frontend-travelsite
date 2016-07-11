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