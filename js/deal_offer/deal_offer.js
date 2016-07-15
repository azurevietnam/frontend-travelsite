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
