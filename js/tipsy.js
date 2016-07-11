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
