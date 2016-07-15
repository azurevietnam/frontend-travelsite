/*!
 * jQuery UI 1.8.18
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI
 */
(function( $, undefined ) {

// prevent duplicate loading
// this is only a problem because we proxy existing functions
// and we don't want to double proxy them
$.ui = $.ui || {};
if ( $.ui.version ) {
	return;
}

$.extend( $.ui, {
	version: "1.8.18",

	keyCode: {
		ALT: 18,
		BACKSPACE: 8,
		CAPS_LOCK: 20,
		COMMA: 188,
		COMMAND: 91,
		COMMAND_LEFT: 91, // COMMAND
		COMMAND_RIGHT: 93,
		CONTROL: 17,
		DELETE: 46,
		DOWN: 40,
		END: 35,
		ENTER: 13,
		ESCAPE: 27,
		HOME: 36,
		INSERT: 45,
		LEFT: 37,
		MENU: 93, // COMMAND_RIGHT
		NUMPAD_ADD: 107,
		NUMPAD_DECIMAL: 110,
		NUMPAD_DIVIDE: 111,
		NUMPAD_ENTER: 108,
		NUMPAD_MULTIPLY: 106,
		NUMPAD_SUBTRACT: 109,
		PAGE_DOWN: 34,
		PAGE_UP: 33,
		PERIOD: 190,
		RIGHT: 39,
		SHIFT: 16,
		SPACE: 32,
		TAB: 9,
		UP: 38,
		WINDOWS: 91 // COMMAND
	}
});

// plugins
$.fn.extend({
	propAttr: $.fn.prop || $.fn.attr,

	_focus: $.fn.focus,
	focus: function( delay, fn ) {
		return typeof delay === "number" ?
			this.each(function() {
				var elem = this;
				setTimeout(function() {
					$( elem ).focus();
					if ( fn ) {
						fn.call( elem );
					}
				}, delay );
			}) :
			this._focus.apply( this, arguments );
	},

	scrollParent: function() {
		var scrollParent;
		if (($.browser.msie && (/(static|relative)/).test(this.css('position'))) || (/absolute/).test(this.css('position'))) {
			scrollParent = this.parents().filter(function() {
				return (/(relative|absolute|fixed)/).test($.curCSS(this,'position',1)) && (/(auto|scroll)/).test($.curCSS(this,'overflow',1)+$.curCSS(this,'overflow-y',1)+$.curCSS(this,'overflow-x',1));
			}).eq(0);
		} else {
			scrollParent = this.parents().filter(function() {
				return (/(auto|scroll)/).test($.curCSS(this,'overflow',1)+$.curCSS(this,'overflow-y',1)+$.curCSS(this,'overflow-x',1));
			}).eq(0);
		}

		return (/fixed/).test(this.css('position')) || !scrollParent.length ? $(document) : scrollParent;
	},

	zIndex: function( zIndex ) {
		if ( zIndex !== undefined ) {
			return this.css( "zIndex", zIndex );
		}

		if ( this.length ) {
			var elem = $( this[ 0 ] ), position, value;
			while ( elem.length && elem[ 0 ] !== document ) {
				// Ignore z-index if position is set to a value where z-index is ignored by the browser
				// This makes behavior of this function consistent across browsers
				// WebKit always returns auto if the element is positioned
				position = elem.css( "position" );
				if ( position === "absolute" || position === "relative" || position === "fixed" ) {
					// IE returns 0 when zIndex is not specified
					// other browsers return a string
					// we ignore the case of nested elements with an explicit value of 0
					// <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
					value = parseInt( elem.css( "zIndex" ), 10 );
					if ( !isNaN( value ) && value !== 0 ) {
						return value;
					}
				}
				elem = elem.parent();
			}
		}

		return 0;
	},

	disableSelection: function() {
		return this.bind( ( $.support.selectstart ? "selectstart" : "mousedown" ) +
			".ui-disableSelection", function( event ) {
				event.preventDefault();
			});
	},

	enableSelection: function() {
		return this.unbind( ".ui-disableSelection" );
	}
});

$.each( [ "Width", "Height" ], function( i, name ) {
	var side = name === "Width" ? [ "Left", "Right" ] : [ "Top", "Bottom" ],
		type = name.toLowerCase(),
		orig = {
			innerWidth: $.fn.innerWidth,
			innerHeight: $.fn.innerHeight,
			outerWidth: $.fn.outerWidth,
			outerHeight: $.fn.outerHeight
		};

	function reduce( elem, size, border, margin ) {
		$.each( side, function() {
			size -= parseFloat( $.curCSS( elem, "padding" + this, true) ) || 0;
			if ( border ) {
				size -= parseFloat( $.curCSS( elem, "border" + this + "Width", true) ) || 0;
			}
			if ( margin ) {
				size -= parseFloat( $.curCSS( elem, "margin" + this, true) ) || 0;
			}
		});
		return size;
	}

	$.fn[ "inner" + name ] = function( size ) {
		if ( size === undefined ) {
			return orig[ "inner" + name ].call( this );
		}

		return this.each(function() {
			$( this ).css( type, reduce( this, size ) + "px" );
		});
	};

	$.fn[ "outer" + name] = function( size, margin ) {
		if ( typeof size !== "number" ) {
			return orig[ "outer" + name ].call( this, size );
		}

		return this.each(function() {
			$( this).css( type, reduce( this, size, true, margin ) + "px" );
		});
	};
});

// selectors
function focusable( element, isTabIndexNotNaN ) {
	var nodeName = element.nodeName.toLowerCase();
	if ( "area" === nodeName ) {
		var map = element.parentNode,
			mapName = map.name,
			img;
		if ( !element.href || !mapName || map.nodeName.toLowerCase() !== "map" ) {
			return false;
		}
		img = $( "img[usemap=#" + mapName + "]" )[0];
		return !!img && visible( img );
	}
	return ( /input|select|textarea|button|object/.test( nodeName )
		? !element.disabled
		: "a" == nodeName
			? element.href || isTabIndexNotNaN
			: isTabIndexNotNaN)
		// the element and all of its ancestors must be visible
		&& visible( element );
}

function visible( element ) {
	return !$( element ).parents().andSelf().filter(function() {
		return $.curCSS( this, "visibility" ) === "hidden" ||
			$.expr.filters.hidden( this );
	}).length;
}

$.extend( $.expr[ ":" ], {
	data: function( elem, i, match ) {
		return !!$.data( elem, match[ 3 ] );
	},

	focusable: function( element ) {
		return focusable( element, !isNaN( $.attr( element, "tabindex" ) ) );
	},

	tabbable: function( element ) {
		var tabIndex = $.attr( element, "tabindex" ),
			isTabIndexNaN = isNaN( tabIndex );
		return ( isTabIndexNaN || tabIndex >= 0 ) && focusable( element, !isTabIndexNaN );
	}
});

// support
$(function() {
	var body = document.body,
		div = body.appendChild( div = document.createElement( "div" ) );

	// access offsetHeight before setting the style to prevent a layout bug
	// in IE 9 which causes the elemnt to continue to take up space even
	// after it is removed from the DOM (#8026)
	div.offsetHeight;

	$.extend( div.style, {
		minHeight: "100px",
		height: "auto",
		padding: 0,
		borderWidth: 0
	});

	$.support.minHeight = div.offsetHeight === 100;
	$.support.selectstart = "onselectstart" in div;

	// set display to none to avoid a layout bug in IE
	// http://dev.jquery.com/ticket/4014
	body.removeChild( div ).style.display = "none";
});





// deprecated
$.extend( $.ui, {
	// $.ui.plugin is deprecated.  Use the proxy pattern instead.
	plugin: {
		add: function( module, option, set ) {
			var proto = $.ui[ module ].prototype;
			for ( var i in set ) {
				proto.plugins[ i ] = proto.plugins[ i ] || [];
				proto.plugins[ i ].push( [ option, set[ i ] ] );
			}
		},
		call: function( instance, name, args ) {
			var set = instance.plugins[ name ];
			if ( !set || !instance.element[ 0 ].parentNode ) {
				return;
			}
	
			for ( var i = 0; i < set.length; i++ ) {
				if ( instance.options[ set[ i ][ 0 ] ] ) {
					set[ i ][ 1 ].apply( instance.element, args );
				}
			}
		}
	},
	
	// will be deprecated when we switch to jQuery 1.4 - use jQuery.contains()
	contains: function( a, b ) {
		return document.compareDocumentPosition ?
			a.compareDocumentPosition( b ) & 16 :
			a !== b && a.contains( b );
	},
	
	// only used by resizable
	hasScroll: function( el, a ) {
	
		//If overflow is hidden, the element might have extra content, but the user wants to hide it
		if ( $( el ).css( "overflow" ) === "hidden") {
			return false;
		}
	
		var scroll = ( a && a === "left" ) ? "scrollLeft" : "scrollTop",
			has = false;
	
		if ( el[ scroll ] > 0 ) {
			return true;
		}
	
		// determine which cases actually cause this to happen
		// if the element doesn't have the scroll set, see if it's possible to
		// set the scroll
		el[ scroll ] = 1;
		has = ( el[ scroll ] > 0 );
		el[ scroll ] = 0;
		return has;
	},
	
	// these are odd functions, fix the API or move into individual plugins
	isOverAxis: function( x, reference, size ) {
		//Determines when x coordinate is over "b" element axis
		return ( x > reference ) && ( x < ( reference + size ) );
	},
	isOver: function( y, x, top, left, height, width ) {
		//Determines when x, y coordinates is over "b" element
		return $.ui.isOverAxis( y, top, height ) && $.ui.isOverAxis( x, left, width );
	}
});

})( jQuery );


/*
 * jQuery UI Button 1.8.18
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Button
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 */
(function( $, undefined ) {

var lastActive, startXPos, startYPos, clickDragged,
	baseClasses = "ui-button ui-widget ui-state-default ui-corner-all",
	stateClasses = "ui-state-hover ui-state-active ",
	typeClasses = "ui-button-icons-only ui-button-icon-only ui-button-text-icons ui-button-text-icon-primary ui-button-text-icon-secondary ui-button-text-only",
	formResetHandler = function() {
		var buttons = $( this ).find( ":ui-button" );
		setTimeout(function() {
			buttons.button( "refresh" );
		}, 1 );
	},
	radioGroup = function( radio ) {
		var name = radio.name,
			form = radio.form,
			radios = $( [] );
		if ( name ) {
			if ( form ) {
				radios = $( form ).find( "[name='" + name + "']" );
			} else {
				radios = $( "[name='" + name + "']", radio.ownerDocument )
					.filter(function() {
						return !this.form;
					});
			}
		}
		return radios;
	};

$.widget( "ui.button", {
	options: {
		disabled: null,
		text: true,
		label: null,
		icons: {
			primary: null,
			secondary: null
		}
	},
	_create: function() {
		this.element.closest( "form" )
			.unbind( "reset.button" )
			.bind( "reset.button", formResetHandler );

		if ( typeof this.options.disabled !== "boolean" ) {
			this.options.disabled = !!this.element.propAttr( "disabled" );
		} else {
			this.element.propAttr( "disabled", this.options.disabled );
		}

		this._determineButtonType();
		this.hasTitle = !!this.buttonElement.attr( "title" );

		var self = this,
			options = this.options,
			toggleButton = this.type === "checkbox" || this.type === "radio",
			hoverClass = "ui-state-hover" + ( !toggleButton ? " ui-state-active" : "" ),
			focusClass = "ui-state-focus";

		if ( options.label === null ) {
			options.label = this.buttonElement.html();
		}

		this.buttonElement
			.addClass( baseClasses )
			.attr( "role", "button" )
			.bind( "mouseenter.button", function() {
				if ( options.disabled ) {
					return;
				}
				$( this ).addClass( "ui-state-hover" );
				if ( this === lastActive ) {
					$( this ).addClass( "ui-state-active" );
				}
			})
			.bind( "mouseleave.button", function() {
				if ( options.disabled ) {
					return;
				}
				$( this ).removeClass( hoverClass );
			})
			.bind( "click.button", function( event ) {
				if ( options.disabled ) {
					event.preventDefault();
					event.stopImmediatePropagation();
				}
			});

		this.element
			.bind( "focus.button", function() {
				// no need to check disabled, focus won't be triggered anyway
				self.buttonElement.addClass( focusClass );
			})
			.bind( "blur.button", function() {
				self.buttonElement.removeClass( focusClass );
			});

		if ( toggleButton ) {
			this.element.bind( "change.button", function() {
				if ( clickDragged ) {
					return;
				}
				self.refresh();
			});
			// if mouse moves between mousedown and mouseup (drag) set clickDragged flag
			// prevents issue where button state changes but checkbox/radio checked state
			// does not in Firefox (see ticket #6970)
			this.buttonElement
				.bind( "mousedown.button", function( event ) {
					if ( options.disabled ) {
						return;
					}
					clickDragged = false;
					startXPos = event.pageX;
					startYPos = event.pageY;
				})
				.bind( "mouseup.button", function( event ) {
					if ( options.disabled ) {
						return;
					}
					if ( startXPos !== event.pageX || startYPos !== event.pageY ) {
						clickDragged = true;
					}
			});
		}

		if ( this.type === "checkbox" ) {
			this.buttonElement.bind( "click.button", function() {
				if ( options.disabled || clickDragged ) {
					return false;
				}
				$( this ).toggleClass( "ui-state-active" );
				self.buttonElement.attr( "aria-pressed", self.element[0].checked );
			});
		} else if ( this.type === "radio" ) {
			this.buttonElement.bind( "click.button", function() {
				if ( options.disabled || clickDragged ) {
					return false;
				}
				$( this ).addClass( "ui-state-active" );
				self.buttonElement.attr( "aria-pressed", "true" );

				var radio = self.element[ 0 ];
				radioGroup( radio )
					.not( radio )
					.map(function() {
						return $( this ).button( "widget" )[ 0 ];
					})
					.removeClass( "ui-state-active" )
					.attr( "aria-pressed", "false" );
			});
		} else {
			this.buttonElement
				.bind( "mousedown.button", function() {
					if ( options.disabled ) {
						return false;
					}
					$( this ).addClass( "ui-state-active" );
					lastActive = this;
					$( document ).one( "mouseup", function() {
						lastActive = null;
					});
				})
				.bind( "mouseup.button", function() {
					if ( options.disabled ) {
						return false;
					}
					$( this ).removeClass( "ui-state-active" );
				})
				.bind( "keydown.button", function(event) {
					if ( options.disabled ) {
						return false;
					}
					if ( event.keyCode == $.ui.keyCode.SPACE || event.keyCode == $.ui.keyCode.ENTER ) {
						$( this ).addClass( "ui-state-active" );
					}
				})
				.bind( "keyup.button", function() {
					$( this ).removeClass( "ui-state-active" );
				});

			if ( this.buttonElement.is("a") ) {
				this.buttonElement.keyup(function(event) {
					if ( event.keyCode === $.ui.keyCode.SPACE ) {
						// pass through original event correctly (just as 2nd argument doesn't work)
						$( this ).click();
					}
				});
			}
		}

		// pull out $.Widget's handling for the disabled option into
		// $.Widget.prototype._setOptionDisabled so it's easy to proxy and can
		// be overridden by individual plugins
		this._setOption( "disabled", options.disabled );
		this._resetButton();
	},

	_determineButtonType: function() {

		if ( this.element.is(":checkbox") ) {
			this.type = "checkbox";
		} else if ( this.element.is(":radio") ) {
			this.type = "radio";
		} else if ( this.element.is("input") ) {
			this.type = "input";
		} else {
			this.type = "button";
		}

		if ( this.type === "checkbox" || this.type === "radio" ) {
			// we don't search against the document in case the element
			// is disconnected from the DOM
			var ancestor = this.element.parents().filter(":last"),
				labelSelector = "label[for='" + this.element.attr("id") + "']";
			this.buttonElement = ancestor.find( labelSelector );
			if ( !this.buttonElement.length ) {
				ancestor = ancestor.length ? ancestor.siblings() : this.element.siblings();
				this.buttonElement = ancestor.filter( labelSelector );
				if ( !this.buttonElement.length ) {
					this.buttonElement = ancestor.find( labelSelector );
				}
			}
			this.element.addClass( "ui-helper-hidden-accessible" );

			var checked = this.element.is( ":checked" );
			if ( checked ) {
				this.buttonElement.addClass( "ui-state-active" );
			}
			this.buttonElement.attr( "aria-pressed", checked );
		} else {
			this.buttonElement = this.element;
		}
	},

	widget: function() {
		return this.buttonElement;
	},

	destroy: function() {
		this.element
			.removeClass( "ui-helper-hidden-accessible" );
		this.buttonElement
			.removeClass( baseClasses + " " + stateClasses + " " + typeClasses )
			.removeAttr( "role" )
			.removeAttr( "aria-pressed" )
			.html( this.buttonElement.find(".ui-button-text").html() );

		if ( !this.hasTitle ) {
			this.buttonElement.removeAttr( "title" );
		}

		$.Widget.prototype.destroy.call( this );
	},

	_setOption: function( key, value ) {
		$.Widget.prototype._setOption.apply( this, arguments );
		if ( key === "disabled" ) {
			if ( value ) {
				this.element.propAttr( "disabled", true );
			} else {
				this.element.propAttr( "disabled", false );
			}
			return;
		}
		this._resetButton();
	},

	refresh: function() {
		var isDisabled = this.element.is( ":disabled" );
		if ( isDisabled !== this.options.disabled ) {
			this._setOption( "disabled", isDisabled );
		}
		if ( this.type === "radio" ) {
			radioGroup( this.element[0] ).each(function() {
				if ( $( this ).is( ":checked" ) ) {
					$( this ).button( "widget" )
						.addClass( "ui-state-active" )
						.attr( "aria-pressed", "true" );
				} else {
					$( this ).button( "widget" )
						.removeClass( "ui-state-active" )
						.attr( "aria-pressed", "false" );
				}
			});
		} else if ( this.type === "checkbox" ) {
			if ( this.element.is( ":checked" ) ) {
				this.buttonElement
					.addClass( "ui-state-active" )
					.attr( "aria-pressed", "true" );
			} else {
				this.buttonElement
					.removeClass( "ui-state-active" )
					.attr( "aria-pressed", "false" );
			}
		}
	},

	_resetButton: function() {
		if ( this.type === "input" ) {
			if ( this.options.label ) {
				this.element.val( this.options.label );
			}
			return;
		}
		var buttonElement = this.buttonElement.removeClass( typeClasses ),
			buttonText = $( "<span></span>", this.element[0].ownerDocument )
				.addClass( "ui-button-text" )
				.html( this.options.label )
				.appendTo( buttonElement.empty() )
				.text(),
			icons = this.options.icons,
			multipleIcons = icons.primary && icons.secondary,
			buttonClasses = [];  

		if ( icons.primary || icons.secondary ) {
			if ( this.options.text ) {
				buttonClasses.push( "ui-button-text-icon" + ( multipleIcons ? "s" : ( icons.primary ? "-primary" : "-secondary" ) ) );
			}

			if ( icons.primary ) {
				buttonElement.prepend( "<span class='ui-button-icon-primary ui-icon " + icons.primary + "'></span>" );
			}

			if ( icons.secondary ) {
				buttonElement.append( "<span class='ui-button-icon-secondary ui-icon " + icons.secondary + "'></span>" );
			}

			if ( !this.options.text ) {
				buttonClasses.push( multipleIcons ? "ui-button-icons-only" : "ui-button-icon-only" );

				if ( !this.hasTitle ) {
					buttonElement.attr( "title", buttonText );
				}
			}
		} else {
			buttonClasses.push( "ui-button-text-only" );
		}
		buttonElement.addClass( buttonClasses.join( " " ) );
	}
});

$.widget( "ui.buttonset", {
	options: {
		items: ":button, :submit, :reset, :checkbox, :radio, a, :data(button)"
	},

	_create: function() {
		this.element.addClass( "ui-buttonset" );
	},
	
	_init: function() {
		this.refresh();
	},

	_setOption: function( key, value ) {
		if ( key === "disabled" ) {
			this.buttons.button( "option", key, value );
		}

		$.Widget.prototype._setOption.apply( this, arguments );
	},
	
	refresh: function() {
		var rtl = this.element.css( "direction" ) === "rtl";
		
		this.buttons = this.element.find( this.options.items )
			.filter( ":ui-button" )
				.button( "refresh" )
			.end()
			.not( ":ui-button" )
				.button()
			.end()
			.map(function() {
				return $( this ).button( "widget" )[ 0 ];
			})
				.removeClass( "ui-corner-all ui-corner-left ui-corner-right" )
				.filter( ":first" )
					.addClass( rtl ? "ui-corner-right" : "ui-corner-left" )
				.end()
				.filter( ":last" )
					.addClass( rtl ? "ui-corner-left" : "ui-corner-right" )
				.end()
			.end();
	},

	destroy: function() {
		this.element.removeClass( "ui-buttonset" );
		this.buttons
			.map(function() {
				return $( this ).button( "widget" )[ 0 ];
			})
				.removeClass( "ui-corner-left ui-corner-right" )
			.end()
			.button( "destroy" );

		$.Widget.prototype.destroy.call( this );
	}
});

}( jQuery ) );


$.widget( "ui.combobox", {
	_create: function() {
		var self = this,
			select = this.element.hide(),
			selected = select.children( ":selected" ),
			value = selected.val() ? selected.text() : "";
		var input = this.input = $( "<input>" )
			.insertAfter( select )
			.val( value )
			.autocomplete({
				delay: 0,
				minLength: 0,
				source: function( request, response ) {
					var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
					response( select.children( "option" ).map(function() {
						var text = $( this ).text();
						if(request.term != '' && this.value == -1) {
							// when search term not empty then ignore all regions have value -1 (vietnam, europe, ...etc)
							return null;
						}
						if ( this.value && ( !request.term || matcher.test(text) ))
							return {
								label: text.replace(
									new RegExp(
										"(?![^&;]+;)(?!<[^<>]*)(" +
										$.ui.autocomplete.escapeRegex(request.term) +
										")(?![^<>]*>)(?![^&;]+;)", "gi"
									), "<strong>$1</strong>" ),
								value: text,
								option: this,
								code: $( this ).val()
							};
					}) );
				},
				select: function( event, ui ) {
					matchSelectCity(select, self, ui, input, event);
				},
				change: function( event, ui ) {
					if ( !ui.item ) {
						var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
							valid = false;
						select.children( "option" ).each(function() {
							if ( $( this ).text().match( matcher ) ) {
								this.selected = valid = true;
								return false;
							}
						});
						if ( !valid ) {
							// remove invalid value, as it didn't match anything
							$( this ).val( "" );
							select.val( "" );
							input.data( "autocomplete" ).term = "";
							return false;
						}
					}
				}
			})
			.addClass( "ui-widget ui-widget-content ui-corner-left" );

		input.data( "autocomplete" )._renderItem = function( ul, item ) {
			respawnCityList(select, ul, item);
		};
		$(input).attr('placeholder', $(select).attr('title'));		

		this.button = $( "<button type='button'>&nbsp;</button>" )
			.attr( "tabIndex", -1 )
			.attr( "title", "Show All Items" )
			.insertAfter( input )
			.button({
				icons: {
					primary: "ui-icon-triangle-1-s"
				},
				text: false
			})
			.removeClass( "ui-corner-all" )
			.addClass( "ui-corner-right ui-button-icon" )
			.click(function() {
				// close if already visible
				if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
					input.autocomplete( "close" );
					return;
				}

				// work around a bug (likely same cause as #5265)
				$( this ).blur();

				// pass empty string as value to search for, displaying all results
				input.autocomplete( "search", "" );
				input.focus();
			});
	},

	destroy: function() {
		this.input.remove();
		this.button.remove();
		this.element.show();
		$.Widget.prototype.destroy.call( this );
	}
});

function matchSelectCity(select, self, ui, input, event) {
	ui.item.option.selected = true;
	self._trigger( "selected", event, {
		item: ui.item.option
	});
	
	var to = $('#flight_destination').val();
	
	if($(select).attr("id") == "flight_origin" && to != '') {
		
		var cityList = '';
		var from = $('#flight_origin').val();
		$.each(mapping_city, function(index) {
			if(typeof mapping_city[index][from] != "undefined") {
				cityList = mapping_city[index][from];
			}
	    });
		
		var n = cityList.indexOf(to);
		if(n == -1 || to == '') {
			$("#to_des :input").val('');
		}
	}
}

function respawnCityList(select, ul, item) {
	
	var from = $('#flight_origin').val();
	
	//console.log('from: '+from);
	
	if($(select).attr("id") == "flight_destination" && from != '') {
		var cityList = '';
		
		$.each(mapping_city, function(index) {
			if(typeof mapping_city[index][from] != "undefined") {
				cityList = mapping_city[index][from];
			}
	    });
		
		if(cityList == '') return null;
		
		//console.log('respawnCityList: '+cityList);
		
		$.each(cityList, function(index) {
			if(cityList[index] == item.code) {
				return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + item.label + "</a>" )
				.appendTo( ul );
			}
		});
	} else {
		if(is_area(item.value)) {
			return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( '<label class="lbl-area">' + item.label + '</label>' )
			.appendTo( ul );
		} else {
			return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( "<a>" + item.label + "</a>" )
			.appendTo( ul );
		}
	}
}

function is_area(name) {
	var status = false;
	$('#flight_origin option').each(function(){
		if($(this).val() == '-1' && name == $(this).text()) {
			status = true;
		}
	});
	
	return status;
}


/**
 * Flight Module
 */

function initSearchFlight(formId){
	
	var default_date = $('#bp_flight_default_date').val();
	var depart_date = $('#bp_flight_depart_date').val();
	var return_date = $('#bp_flight_return_date').val();
	
	var departure_day_id 	= '#departure_day';
	var departure_month_id 	= '#departure_month';
	var departure_date_id 	= '#departure_date';
	
	var returning_day_id 	= '#returning_day';
	var returning_month_id 	= '#returning_month';
	var returning_date_id 	= '#returning_date';
	
	if(formId == 'searchForm') {
		$( "#flight_origin" ).combobox();
		$( "#flight_destination" ).combobox();
	} else {
		//prefix name in search dialog
		departure_day_id 	= '#sd_departure_day';
		departure_month_id 	= '#sd_departure_month';
		departure_date_id 	= '#sd_departure_date';
		
		returning_day_id 	= '#sd_returning_day';
		returning_month_id 	= '#sd_returning_month';
		returning_date_id	= '#sd_returning_date';
	}
	
	
	initFlightDate(default_date, depart_date, departure_day_id, departure_month_id, departure_date_id);
	initFlightDate(default_date, return_date, returning_day_id, returning_month_id, returning_date_id);
	
	$(departure_day_id).add(departure_month_id).add(returning_day_id).add(returning_month_id).change(function() {
		var departure = $(departure_day_id).val() + '-' + $(departure_month_id).val();
		var returning = $(returning_day_id).val() + '-' + $(returning_month_id).val();
		if(compare_date(departure, returning)) {
			$(returning_day_id).val($(departure_day_id).val());
			$(returning_month_id).val($(departure_month_id).val());
			$(returning_date_id).val($(departure_date_id).val());
			
			return_date = $(returning_date_id).val();
			initFlightDate(default_date, return_date, returning_day_id, returning_month_id, returning_date_id);
			 
			$(returning_date_id).datepicker( "option", "minDate", $(departure_date_id).val() );
		}
	});
	
	$('#'+formId+' input[name="flight_type"]' ).click(function() {
		check_flight_type(formId);
	});
	
	check_flight_type(formId);
}

function initFlightDate(default_date, current_date, start_date_id, start_month_id, departure_date_id) {

	initOptionDay(current_date, start_date_id, '');
	initOptionMonth(default_date, current_date, start_month_id, '');
	
	var min_date = default_date;
	
	if(departure_date_id == '#returning_date') {
		min_date = $('#departure_date').val();
	}
	
	$(departure_date_id).datepicker({
		showOn: 'button',
		dateFormat: 'dd-mm-yy', 
		buttonImage: '/media/calendar.gif', 
		buttonImageOnly: true, 
		buttonText: i18n.flight_pick_a_date,
		minDate: min_date,
		onSelect: function(dateText, inst) {
			selectDate(dateText, start_date_id, start_month_id, '');
			$(start_date_id).change();
		},
		onClose: function( selectedDate ) {
			if(departure_date_id == '#departure_date' && selectedDate != '') {
				$( "#returning_date" ).datepicker( "option", "minDate", selectedDate );
			}
		}
	});	
	
	$(departure_date_id).val(current_date);
}

function check_flight_type(form_id) {
	form_id = '#' + form_id;
	if($(form_id+' input[name="flight_type"]:checked').val() == "roundway") {
		$(form_id+' .return-container').show();
	} else {
		$(form_id+' .return-container').hide();
	}
}

function search_flight(search_url, form_id) {
	
	// validate source and destination
	if(form_id == "searchForm") {
		var from = $('#'+form_id + ' select[name="From"] option:selected').val();
		var to = $('#'+form_id + ' select[name="To"] option:selected').val();
		
		if(from == '') {
			alert(i18n.flight_from_required);
			return false;
		}
		
		if(to == '') {
			alert(i18n.flight_to_required);
			return false;
		}
	}
	
	// validate departure and returning date
	var default_date = $('#bp_flight_default_date').val();
	var departure = $('#'+form_id + ' input[name="departure_date"]').val();
	// default_date > departure
	if(compare_date(default_date, departure)) {
		alert(i18n.flight_departure_required);
		return false;
	}
	
	$('.search_button').html('<span>'+i18n.flight_searching+'</span>&nbsp;<span class="icon-flight-search-loading">&nbsp;</span>');
	
	document.frmSearchForm.action = search_url + get_flight_params(form_id);
	
	document.frmSearchForm.submit();
}

function get_flight_params(form_id){
	form_id = '#' + form_id;
	
	var from = '';
	var to = '';
	
	if(form_id == '#frmSearchDialogForm') {
		from = $(form_id + ' input[name="From"]').val();
		to = $(form_id + ' input[name="To"]').val();
	} else {
		from = $(form_id + ' select[name="From"] option:selected').val();
		to = $(form_id + ' select[name="To"] option:selected').val();
	}
	
	var departure_date = $(form_id + ' input[name="departure_date"]').val().split('-');
	var returning_date = $(form_id + ' input[name="returning_date"]').val().split('-');
	
	var airline = '';
	if($(form_id + ' input[name="dg_airline_code"]').length > 0) {
		airline = $(form_id + ' input[name="dg_airline_code"]').val();
	}
	
	var params	 = 'From=' 			+ from;
	params 		+= '&DayDepart=' 	+ parseInt(departure_date[0], 10);
	params 		+= '&MonthDepart='	+ parseInt(departure_date[1], 10);
	params 		+= '&YearDepart=' 	+ departure_date[2];
	params 		+= '&To='			+ to;
	params 		+= '&DayReturn=' 	+ parseInt(returning_date[0], 10);
	params 		+= '&MonthReturn=' 	+ parseInt(returning_date[1], 10);
	params 		+= '&YearReturn=' 	+ returning_date[2];
	params 		+= '&ADT=' 			+ $(form_id + ' select[name="adults"] option:selected').val();
	params 		+= '&CHD=' 			+ $(form_id + ' select[name="children"] option:selected').val();
	params 		+= '&INF=' 			+ $(form_id + ' select[name="infants"] option:selected').val();
	params 		+= '&Type=' 		+ $(form_id + ' input[name="flight_type"]:checked').val();
	
	if(airline != ''){
		params 		+= '&Airline=' 		+ airline;
	}
	
	params = params + '/';
	
	//params = "From=HAN&DayDepart=01&MonthDepart=01&YearDepart=2014&To=SGN&DayReturn=05&MonthReturn=01&YearReturn=2014&ADT=1&CHD=1&INF=1&Type=roundway";
	
	return params; 
	
}

function change_search(){
	$('#searchOverview').hide();
	$('#searchForm').show();
}

function get_flight_data(sid, type, selected_airline){
	$("#flight_data_content").addClass('flight_loading_content');
	if(type == 'depart'){
		$("#flight_data_content").html($('#flight_loading_content').html());	
	} else {
		$("#flight_data_content").html($('#flight-search-loading').html());
	}

	disable_filters();
	$.ajax({
		url: "/get-flight-data/",
		type: "POST",
		cache: false,
		data: {
			"sid":sid,
			"flight_type":type		
		},
		success:function(value){
			$("#flight_data_content").removeClass('flight_loading_content');
			$("#flight_data_content").html(value);

			enable_filters(selected_airline);
		},
		error:function(var1, var2, var3){
			
		}
	});	
}

function disable_filters(){
	
	$('.filter-airlines').attr('disabled','disabled');
	
	$('.filter-times').attr('disabled','disabled');
	
}

function enable_filters(selected_airline){
	
	var airline_arr = new Array();
	var time_arr = new Array();
	
	$('#rows_content .bpt_item').each(function(){
		var airline = $(this).attr('airline');
		var time = $(this).attr('time');
		
		airline_arr.push(airline);
		time_arr.push(time);
	});
	
	if (airline_arr.length > 0){
		
		$('.filter-airlines').removeAttr('disabled');
		$('.filter-times').removeAttr('disabled');
		$('.filter-airlines').attr('checked', false);
		$('.filter-times').attr('checked', false);
		
		$('.filter-airlines').each(function(){
			var airline = $(this).val();
			
			if (airline_arr.indexOf(airline) == -1){
				$(this).parent().hide();
			} else {
				
				if(airline == selected_airline){
					$(this).attr('checked', true);
				}
				
			}
		});
		
		$('.filter-times').each(function(){
			var time = $(this).val();
			
			if (time_arr.indexOf(time) == -1){
				$(this).parent().hide();
			}
		});
		
		if(selected_airline != ''){
			filter_flights();
		}
	}
}


function filter_flights(){
	
	var airline_arr = new Array();
	
	var time_arr = new Array();
	
	$('.filter-airlines').each(function(){
		if($(this).attr('checked')){
			var airline = $(this).val();
			airline_arr.push(airline)
		}
	});
	
	$('.filter-times').each(function(){
		if($(this).attr('checked')){
			var time = $(this).val();
			time_arr.push(time);
		}
	});
	
	show_hide_flight_rows(airline_arr,time_arr);
}

function show_hide_flight_rows(airline_arr,time_arr){
	
	$('#rows_content .bpt_item').each(function(){
		var airline = $(this).attr('airline');
		var time = $(this).attr('time');
		
		if(is_shown(airline,airline_arr) && is_shown(time, time_arr)){
			$(this).show('slow');
		} else {
			$(this).hide('slow');
		}
		
		
	});
}

function is_shown(airline, airline_arr){
	if(airline_arr.length == 0) return true;
	
	if(airline_arr.indexOf(airline) != -1) return true;
	
	return false;
}

function sort_flight_by(sort_by){
	
	var rows = new Array();
	
	$('#rows_content .bpt_item').each(function(){
		var row_obj = $(this);
		
		rows.push(row_obj);
	});
	
	
	$.each(['sort_by_prices','sort_by_airlines','sort_by_departure'],function(index, value){
		var txt = $('#' + value).text();
		if(value == sort_by){			
			$('#'+value).addClass('selected');			
			$('#'+value).html('<span>'+txt+'</span>');
		} else {
			$('#'+value).removeClass('selected');			
			$('#'+value).html('<a href="javascript:sort_flight_by(\'' + value + '\')">'+txt+'</a>');
		}
	});
	
	for(var i = rows.length - 1; i >= 0; i--){
		
		for(var j = 1; j <= i; j++){
			
			var v1 = 0; 
			var v2 = 0;
			
			if(sort_by == 'sort_by_prices'){
				v1 = $(rows[j-1]).attr('price');
				v2 = $(rows[j]).attr('price');
				
				v1 = parseInt(v1);
				v2 = parseInt(v2);
				
			} else if(sort_by == 'sort_by_airlines'){
				v1 = $(rows[j-1]).attr('code');
				v2 = $(rows[j]).attr('code');
			} else if(sort_by == 'sort_by_departure'){
				v1 = $(rows[j-1]).attr('timefrom');
				v2 = $(rows[j]).attr('timefrom');
			}
			
			if (v1 > v2){
				var tmp = rows[j-1];
				rows[j-1] = rows[j];
				rows[j] = tmp;
			}else if(v1 == v2){
				v1 = $(rows[j-1]).attr('code');
				v2 = $(rows[j]).attr('code');
				
				if (v1 > v2){
					var tmp = rows[j-1];
					rows[j-1] = rows[j];
					rows[j] = tmp;
				}
			}
			
		}
	}
	
	var sort_html = '';
	
	for(var i = 0; i < rows.length; i++){
		
		var row_obj = $(rows[i]).clone();
		
		$(row_obj).wrap('<div>');
		
		sort_html = sort_html + $(row_obj).parent().html();
	}
	
	$('#rows_content').html(sort_html);
	
}

function show_flight_detail(sid, flight_id, flight_class, flight_stop, flight_type){
	
	var show_status =  $('#flight_detail_' + flight_id).attr('show');
	
	if(show_status == 'hide'){
		$('#flight_detail_' + flight_id).attr('show','show');
		
		$('#show_'+flight_id).html('[ - ] '+i18n.flight_hide_details);
		
		$('#flight_detail_' + flight_id).show();
		
		var loaded = $('#flight_detail_' + flight_id).attr('loaded');
		
		if(loaded == '0'){
			get_flight_detail(sid,flight_id,flight_class, flight_stop, flight_type);
		}
		
		$('#flight_row_' + flight_id).addClass('bpt-item-selected');
	} else {
		$('#flight_detail_' + flight_id).attr('show','hide');
		
		$('#show_'+flight_id).html('[ + ] '+i18n.flight_show_details);
		
		$('#flight_detail_' + flight_id).hide();
		$('#flight_row_' + flight_id).removeClass('bpt-item-selected');
	}
	
}

function get_flight_detail(sid,flight_id,flight_class, flight_stop, flight_type){
	
	$('#flight_detail_' + flight_id).html('<center><span class="flight-loading"></span></center>');
	$.ajax({
		url: "/get-flight-detail/",
		type: "POST",
		cache: false,
		data: {
			"sid":sid,
			"flight_id":flight_id,
			"flight_class":flight_class,
			"flight_stop":flight_stop,
			"flight_type":flight_type
		},
		success:function(value){
			if (value != ''){
				$('#flight_detail_' + flight_id).html(value);
				$('#flight_detail_' + flight_id).attr('loaded','1');
			} else {
				$('#flight_detail_' + flight_id).html('<center><span class="error">' + i18n.flight_failed_load_details + '</span></center>');
			}
		},
		error:function(var1, var2, var3){
			//$('#flight_detail_' + flight_id).html('<center><span class="error">Fail to load flight detail. Use search form to get the flight data again!</span></center>');			
		}
	});	
}

function get_selected_flight_info(flight_id){
	var ret = flight_id;
	
	var airline = $('#flight_row_' + flight_id).attr('airline');	
	var code = $('#flight_row_' + flight_id).attr('code');
	var timefrom = $('#flight_row_' + flight_id).attr('timefrom');
	var timeto = $('#flight_row_' + flight_id).attr('timeto');
	var flight_class = $('#flight_row_' + flight_id).attr('flightclass');
	var flight_stop = $('#flight_row_' + flight_id).attr('flightstop');
	var flight_r_class = $('#flight_row_' + flight_id).attr('flightrclass');
	
	ret = ret + ';' + airline + ';'+ code + ';' + flight_stop + ';' + timefrom + ';' + timeto + ';' + flight_class + ';' + flight_r_class;
	
	//alert(ret);
	
	return ret;
}

function show_fare_rules(id){
	txt_id = 'txt_'+id;
	id = 'fare_rules_' + id;
	
	var status = $('#' + id).attr('show');
	
	if(status == 'hide'){
		
		$('#'+id).show();
		$('#'+id).attr('show','show');
		$('#'+txt_id).html('[ - ] '+i18n.flight_hide_fare_rules);
	} else {
		$('#'+id).hide();
		$('#'+id).attr('show','hide');
		$('#' + txt_id).html('[ + ] '+i18n.flight_show_fare_rules);
	}
}

function validate_passengers(parent_id){
	
	var is_valid = true;
	
	var req_class = '.required';
	
	var non_req_class = '.non-required';
	
	if(parent_id != undefined){
		req_class = '#' + parent_id + ' ' + req_class;		
		non_req_class = '#' + parent_id + ' ' +  req_class;
	}
	
	
	$('#passenger_note').removeClass('error');
	
	$(req_class).each(function(){
		
		$(this).removeClass('red-border');
		
		var txt_val = $(this).val();
		
		if($.trim(txt_val) == '' || /^[a-zA-Z0-9- ]*$/.test(txt_val) == false){
			
			is_valid = false;
			
			$(this).addClass('red-border');
		}
	});
	
	$(non_req_class).each(function(){
		
		$(this).removeClass('red-border');
		
		var txt_val = $(this).val();
		
		if(/^[a-zA-Z0-9- ]*$/.test(txt_val) == false){
			
			is_valid = false;
			
			$(this).addClass('red-border');
		}
	});
	
	if(!is_valid){
		$('#passenger_note').addClass('error');
	}
	
	return is_valid;
}

function validate_contact_details(){
	
	var is_valid = true;
	
	$('#contact_detail_error').hide();
	
	$('.c-required').each(function(){
		
		$(this).removeClass('red-border');
		
		var txt_val = $(this).val();
		
		if($.trim(txt_val) == ''){
			
			is_valid = false;
			
			$(this).addClass('red-border');
		}
	});

	
	if(!is_valid){
		$('#contact_detail_error').show();
	}
	
	return is_valid;
}

function compare_date(from, to) {
	var d1 = from.split('-');
	var d2 = to.split('-');
	date1 = new Date(parseInt(d1[2], 10), [parseInt(d1[1], 10)-1], parseInt(d1[0], 10));
	date2 = new Date(parseInt(d2[2]), [parseInt(d2[1], 10)-1], parseInt(d2[0], 10));
	
	if(date1 > date2) {
		return true;
	}
	
	return false;
}

function select_destination_flight(ele, id, airline_id, airline_code, from, to) {
	var tip = $('#search_dialog');
	var pos = $.extend({}, $(ele).offset(), {width: $(ele).outerWidth(), height: $(ele).outerHeight()});
	var actualWidth = tip.width();
	
	var pos_top = Math.round(pos.top) + pos.height*2 - 6;
	var pos_left = Math.round(pos.left) - $("#wrapper").offset().left - actualWidth + (pos.width/2) + 40;
    tip.css({top: pos_top, left: pos_left});
    
	var img_src = $('#sl_airline_img_'+id+'_'+airline_id).attr('src');
	$('#dg_airline_img').attr('src', img_src);
	$('#dg_airline_name').html($('#sl_airline_name_'+airline_id).html());
	$('#dg_airline_code').val(airline_code);
	
	$('#dg_txt_from').html($('#sl_from_des_'+id).html());
	$('#dg_txt_to').html($('#sl_to_des_'+id).html());
	
	$('#dg_from').val(from);
	$('#dg_to').val(to);
	
	$('.search-dialog').show();
}

function flight_format_currency(rate){
	
	rate = '$'+rate.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	return rate;
}

function change_baggage(){
	
	var total_kg = 0;
	
	var total_fee = 0;
	
	$('.baggage-fees').each(function(){
		
		var kg = $(this).val();
		
		if(kg == '') kg = 0;
		kg = parseInt(kg);
		
		var fee = $(this).find('option:selected').attr('fee');
		
		fee = parseInt(fee);
		
		total_kg = total_kg + kg;
		
		total_fee = total_fee + fee;
		
	});
	
	if(total_fee > 0){
		$('#flight_baggage_fee').show();
		
		$('#total_kg').text(total_kg);
		
		$('#flight_baggage_fee .row-content').html(flight_format_currency(total_fee));
	} else {
		$('#flight_baggage_fee').hide();
	}
	
	var total_ticket_price = parseInt($('#flight_total_price').attr('ticket-price'));
	
	$('#flight_total_price').html(flight_format_currency(total_ticket_price + total_fee));
}


