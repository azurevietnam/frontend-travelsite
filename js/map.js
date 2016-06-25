/**
 * Khuyenpv: 18.06.2014
 * Infobox.js to Map.js for performance loading
 */

function InfoBox(a){a=a||{};google.maps.OverlayView.apply(this,arguments);this.content_=a.content||"";this.disableAutoPan_=a.disableAutoPan||false;this.maxWidth_=a.maxWidth||0;this.pixelOffset_=a.pixelOffset||new google.maps.Size(0,0);this.position_=a.position||new google.maps.LatLng(0,0);this.zIndex_=a.zIndex||null;this.boxClass_=a.boxClass||"infoBox";this.boxStyle_=a.boxStyle||{};this.closeBoxMargin_=a.closeBoxMargin||"2px";this.closeBoxURL_=a.closeBoxURL||"http://www.google.com/intl/en_us/mapfiles/close.gif";if(a.closeBoxURL===""){this.closeBoxURL_=""}this.infoBoxClearance_=a.infoBoxClearance||new google.maps.Size(1,1);this.isHidden_=a.isHidden||false;this.alignBottom_=a.alignBottom||false;this.pane_=a.pane||"floatPane";this.enableEventPropagation_=a.enableEventPropagation||false;this.div_=null;this.closeListener_=null;this.eventListener1_=null;this.eventListener2_=null;this.eventListener3_=null;this.moveListener_=null;this.contextListener_=null;this.fixedWidthSet_=null}InfoBox.prototype=new google.maps.OverlayView();InfoBox.prototype.createInfoBoxDiv_=function(){var d;var a=this;var b=function(f){f.cancelBubble=true;if(f.stopPropagation){f.stopPropagation()}};var c=function(f){f.returnValue=false;if(f.preventDefault){f.preventDefault()}if(!a.enableEventPropagation_){b(f)}};if(!this.div_){this.div_=document.createElement("div");this.setBoxStyle_();if(typeof this.content_.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+this.content_}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(this.content_)}this.getPanes()[this.pane_].appendChild(this.div_);this.addClickHandler_();if(this.div_.style.width){this.fixedWidthSet_=true}else{if(this.maxWidth_!==0&&this.div_.offsetWidth>this.maxWidth_){this.div_.style.width=this.maxWidth_;this.div_.style.overflow="auto";this.fixedWidthSet_=true}else{d=this.getBoxWidths_();this.div_.style.width=(this.div_.offsetWidth-d.left-d.right)+"px";this.fixedWidthSet_=false}}this.panBox_(this.disableAutoPan_);if(!this.enableEventPropagation_){this.eventListener1_=google.maps.event.addDomListener(this.div_,"mousedown",b);this.eventListener2_=google.maps.event.addDomListener(this.div_,"click",b);this.eventListener3_=google.maps.event.addDomListener(this.div_,"dblclick",b);this.eventListener4_=google.maps.event.addDomListener(this.div_,"mouseover",function(f){this.style.cursor="default"})}this.contextListener_=google.maps.event.addDomListener(this.div_,"contextmenu",c);google.maps.event.trigger(this,"domready")}};InfoBox.prototype.getCloseBoxImg_=function(){var a="";if(this.closeBoxURL_!==""){a="<img";a+=" src='"+this.closeBoxURL_+"'";a+=" align=right";a+=" style='";a+=" position: relative;";a+=" cursor: pointer;";a+=" margin: "+this.closeBoxMargin_+";";a+="'>"}return a};InfoBox.prototype.addClickHandler_=function(){var a;if(this.closeBoxURL_!==""){a=this.div_.firstChild;this.closeListener_=google.maps.event.addDomListener(a,"click",this.getCloseClickHandler_())}else{this.closeListener_=null}};InfoBox.prototype.getCloseClickHandler_=function(){var a=this;return function(b){b.cancelBubble=true;if(b.stopPropagation){b.stopPropagation()}a.close();google.maps.event.trigger(a,"closeclick")}};InfoBox.prototype.panBox_=function(o){var d;var b;var m=0,i=0;if(!o){d=this.getMap();if(d instanceof google.maps.Map){if(!d.getBounds().contains(this.position_)){d.setCenter(this.position_)}b=d.getBounds();var q=d.getDiv();var j=q.offsetWidth;var l=q.offsetHeight;var f=this.pixelOffset_.width;var e=this.pixelOffset_.height;var k=this.div_.offsetWidth;var p=this.div_.offsetHeight;var h=this.infoBoxClearance_.width;var g=this.infoBoxClearance_.height;var a=this.getProjection().fromLatLngToContainerPixel(this.position_);if(a.x<(-f+h)){m=a.x+f-h}else{if((a.x+k+f+h)>j){m=a.x+k+f+h-j}}if(this.alignBottom_){if(a.y<(-e+g+p)){i=a.y+e-g-p}else{if((a.y+e+g)>l){i=a.y+e+g-l}}}else{if(a.y<(-e+g)){i=a.y+e-g}else{if((a.y+p+e+g)>l){i=a.y+p+e+g-l}}}if(!(m===0&&i===0)){var n=d.getCenter();d.panBy(m,i)}}}};InfoBox.prototype.setBoxStyle_=function(){var a,b;if(this.div_){this.div_.className=this.boxClass_;this.div_.style.cssText="";b=this.boxStyle_;for(a in b){if(b.hasOwnProperty(a)){this.div_.style[a]=b[a]}}if(typeof this.div_.style.opacity!=="undefined"&&this.div_.style.opacity!==""){this.div_.style.filter="alpha(opacity="+(this.div_.style.opacity*100)+")"}this.div_.style.position="absolute";this.div_.style.visibility="hidden";if(this.zIndex_!==null){this.div_.style.zIndex=this.zIndex_}}};InfoBox.prototype.getBoxWidths_=function(){var a;var c={top:0,bottom:0,left:0,right:0};var b=this.div_;if(document.defaultView&&document.defaultView.getComputedStyle){a=b.ownerDocument.defaultView.getComputedStyle(b,"");if(a){c.top=parseInt(a.borderTopWidth,10)||0;c.bottom=parseInt(a.borderBottomWidth,10)||0;c.left=parseInt(a.borderLeftWidth,10)||0;c.right=parseInt(a.borderRightWidth,10)||0}}else{if(document.documentElement.currentStyle){if(b.currentStyle){c.top=parseInt(b.currentStyle.borderTopWidth,10)||0;c.bottom=parseInt(b.currentStyle.borderBottomWidth,10)||0;c.left=parseInt(b.currentStyle.borderLeftWidth,10)||0;c.right=parseInt(b.currentStyle.borderRightWidth,10)||0}}}return c};InfoBox.prototype.onRemove=function(){if(this.div_){this.div_.parentNode.removeChild(this.div_);this.div_=null}};InfoBox.prototype.draw=function(){this.createInfoBoxDiv_();var a=this.getProjection().fromLatLngToDivPixel(this.position_);this.div_.style.left=(a.x+this.pixelOffset_.width)+"px";if(this.alignBottom_){this.div_.style.bottom=-(a.y+this.pixelOffset_.height)+"px"}else{this.div_.style.top=(a.y+this.pixelOffset_.height)+"px"}if(this.isHidden_){this.div_.style.visibility="hidden"}else{this.div_.style.visibility="visible"}};InfoBox.prototype.setOptions=function(a){if(typeof a.boxClass!=="undefined"){this.boxClass_=a.boxClass;this.setBoxStyle_()}if(typeof a.boxStyle!=="undefined"){this.boxStyle_=a.boxStyle;this.setBoxStyle_()}if(typeof a.content!=="undefined"){this.setContent(a.content)}if(typeof a.disableAutoPan!=="undefined"){this.disableAutoPan_=a.disableAutoPan}if(typeof a.maxWidth!=="undefined"){this.maxWidth_=a.maxWidth}if(typeof a.pixelOffset!=="undefined"){this.pixelOffset_=a.pixelOffset}if(typeof a.alignBottom!=="undefined"){this.alignBottom_=a.alignBottom}if(typeof a.position!=="undefined"){this.setPosition(a.position)}if(typeof a.zIndex!=="undefined"){this.setZIndex(a.zIndex)}if(typeof a.closeBoxMargin!=="undefined"){this.closeBoxMargin_=a.closeBoxMargin}if(typeof a.closeBoxURL!=="undefined"){this.closeBoxURL_=a.closeBoxURL}if(typeof a.infoBoxClearance!=="undefined"){this.infoBoxClearance_=a.infoBoxClearance}if(typeof a.isHidden!=="undefined"){this.isHidden_=a.isHidden}if(typeof a.enableEventPropagation!=="undefined"){this.enableEventPropagation_=a.enableEventPropagation}if(this.div_){this.draw()}};InfoBox.prototype.setContent=function(a){this.content_=a;if(this.div_){if(this.closeListener_){google.maps.event.removeListener(this.closeListener_);this.closeListener_=null}if(!this.fixedWidthSet_){this.div_.style.width=""}if(typeof a.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+a}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(a)}if(!this.fixedWidthSet_){this.div_.style.width=this.div_.offsetWidth+"px";if(typeof a.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+a}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(a)}}this.addClickHandler_()}google.maps.event.trigger(this,"content_changed")};InfoBox.prototype.setPosition=function(a){this.position_=a;if(this.div_){this.draw()}google.maps.event.trigger(this,"position_changed")};InfoBox.prototype.setZIndex=function(a){this.zIndex_=a;if(this.div_){this.div_.style.zIndex=a}google.maps.event.trigger(this,"zindex_changed")};InfoBox.prototype.getContent=function(){return this.content_};InfoBox.prototype.getPosition=function(){return this.position_};InfoBox.prototype.getZIndex=function(){return this.zIndex_};InfoBox.prototype.show=function(){this.isHidden_=false;if(this.div_){this.div_.style.visibility="visible"}};InfoBox.prototype.hide=function(){this.isHidden_=true;if(this.div_){this.div_.style.visibility="hidden"}};InfoBox.prototype.open=function(c,a){var b=this;if(a){this.position_=a.getPosition();this.moveListener_=google.maps.event.addListener(a,"position_changed",function(){b.setPosition(this.getPosition())})}this.setMap(c);if(this.div_){this.panBox_()}};InfoBox.prototype.close=function(){if(this.closeListener_){google.maps.event.removeListener(this.closeListener_);this.closeListener_=null}if(this.eventListener1_){google.maps.event.removeListener(this.eventListener1_);google.maps.event.removeListener(this.eventListener2_);google.maps.event.removeListener(this.eventListener3_);google.maps.event.removeListener(this.eventListener4_);this.eventListener1_=null;this.eventListener2_=null;this.eventListener3_=null;this.eventListener4_=null}if(this.moveListener_){google.maps.event.removeListener(this.moveListener_);this.moveListener_=null}if(this.contextListener_){google.maps.event.removeListener(this.contextListener_);this.contextListener_=null}this.setMap(null)};

/**
 *  Store all the markers information on the map
 */
var markers = new Array();
var main_hotel_info_box = '';
var current_hotel_map = '';

/*
 * Create Hotel Destination Map on hotel-destination page
 */
function create_hotel_destination_map(des_info){
	
	// reset the global variable
	markers = new Array();
	main_hotel_info_box = '';
	current_hotel_map = '';
	
	var lat = des_info.lat;
	
	var lng = des_info.lng; 
	
	var des_id = des_info.des_id;
	
	var hotel_map = create_hotel_map('hotel_des_map', lat, lng);

	
	get_hotels_in_city('', des_id, hotel_map, 1, 1);
	
}

function create_hotel_mobile_map(hotel_info){
	
	// reset the global variable
	markers = new Array();
	main_hotel_info_box = '';
	current_hotel_map = '';
	
	// get hotel basic info from 'view-map' link attribute
	var hotel_id = hotel_info.data_hotel_id;
	var des_id = hotel_info.data_des_id;
	var lat = hotel_info.data_lat;
	var lng = hotel_info.data_lng;
	var name = hotel_info.data_place_name;
	var star = hotel_info.data_star;
	
	// init filter status for each hotel map
	init_filter_status();
	
	// get center map from the hotel position
	var hotel_map = create_hotel_map('hotel_des_map', lat, lng);
	var currentCenter = new google.maps.LatLng(lat, lng);
		
	hotel_map.setCenter(currentCenter);

	// generate main hotel marker
	var main_hotel_marker = render_main_hotel_marker(lat, lng, hotel_map);
	main_hotel_marker.setZIndex(999999);
	
	// get information of the main hotel
	get_hotel_main(hotel_id, hotel_map, main_hotel_marker, true);
	
	
	// get other hotels in the city of the hotel
	get_hotels_in_city(hotel_id, des_id, hotel_map, '','',true);
	
	
	// get destination in the city of the hotel
	get_destinations_in_city(des_id, hotel_map, true);
	
	
}

/**
 * View Hotel Destination Map on the large size
 * @param dom_area
 */
function view_hotel_destination_map(dom_area){
	
	// reset the global variable
	markers = new Array();
	main_hotel_info_box = '';
	current_hotel_map = '';
	
	// init filter status for each hotel map
	init_filter_status();
	
	var des_id = $(dom_area).attr('data-des-id');
	var lat = $(dom_area).attr('data-lat');
	var lng = $(dom_area).attr('data-lng');
	var name = $(dom_area).attr('data-place-name');
	
	var hotel_map = create_hotel_map('hotel_map', lat, lng);
	
	// show map 
	$('#mapModalLabel').html('Khách sạn ở '+name);
	
	$('#mapModal').on("shown.bs.modal", function () {
		google.maps.event.trigger(hotel_map, "resize");
		
		var currentCenter = new google.maps.LatLng(lat, lng);
		
		hotel_map.setCenter(currentCenter);
	});
	
	$('#mapModal').modal('show');
	
	// get other hotels in the city of the hotel
	get_hotels_in_city('', des_id, hotel_map, 1, 1);
	
	// get destination in the city of the hotel
	get_destinations_in_city(des_id, hotel_map);
}

/**
 * Create vietnam top destination map on Home page & Hotel-Home page
 * @param des_info
 */
function create_vietnam_top_des_map(des_info){
	
	// reset the global variable
	markers = new Array();
	main_hotel_info_box = '';
	current_hotel_map = '';
	
	var des_id = des_info.des_id;
	var lat = des_info.lat;
	var lng = des_info.lng; 
	var des_name = des_info.des_name;
	var zm = des_info.zoom;
	
	var hotel_map = create_hotel_map('vietnam_map', lat, lng, zm);
	
	get_hotel_top_destination(hotel_map);
	
}

function get_hotel_top_destination(hotel_map){
	$.ajax({
		url: "/hotel_on_map/get_hotel_top_destination/",
		type: "POST",
		cache: true,
		dataType: 'json',
		data: {
		},
		success:function(value){
			if(value != ''){
				
				for(var i = 0; i < value.length; i++){
					render_destination_map_data(value[i], hotel_map, 1);
				}
				
			}	
		},
		error:function(var1, var2, var3){
			//
		}
	});
}

/**
 * 
 * Khuyenpv: New version of View_Map()
 * 
 */
function view_hotel_map(dom_obj){
	
	// get hotel basic info from 'view-map' link attribute
	var hotel_id = $(dom_obj).attr('data-hotel-id');
	var des_id = $(dom_obj).attr('data-des-id');
	var lat = $(dom_obj).attr('data-lat');
	var lng = $(dom_obj).attr('data-lng');
	var name = $(dom_obj).attr('data-place-name');
	var star = $(dom_obj).attr('data-star');
	var is_mobile = $(dom_obj).attr('is-mobile');
	
	// reset the global variable
	markers = new Array();
	main_hotel_info_box = '';
	current_hotel_map = '';
	
	// init filter status for each hotel map
	init_filter_status();
	
	// get center map from the hotel position
	var hotel_map = create_hotel_map('hotel_map', lat, lng);
	
	// show map 
	$('#mapModalLabel').html(name+'  <span class="icon star-'+star+'"></span>');
	
	$('#mapModal').on("shown.bs.modal", function () {
		google.maps.event.trigger(hotel_map, "resize");
		
		var currentCenter = new google.maps.LatLng(lat, lng);
		
		hotel_map.setCenter(currentCenter);
	});
	
	$('#mapModal').modal('show');
	
	// generate main hotel marker
	var main_hotel_marker = render_main_hotel_marker(lat, lng, hotel_map);
	main_hotel_marker.setZIndex(999999);
	
	// get information of the main hotel
	get_hotel_main(hotel_id, hotel_map, main_hotel_marker);
	
	
	// get other hotels in the city of the hotel
	get_hotels_in_city(hotel_id, des_id, hotel_map);
	
	
	// get destination in the city of the hotel
	get_destinations_in_city(des_id, hotel_map);
	
}
/*
 * Crate Google Map Object based on map_options
 */
function create_hotel_map(map_area_id, lat, lng, zm){
	var zoom_ =15;
	if(zm != undefined && zm != ''){
		zoom_ = zm;
	}
	// get center map from the hotel position
	var myLatlng = new google.maps.LatLng(lat , lng);
	
	var map_options = {
	    center: myLatlng,
	    zoom: zoom_,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var hotel_map = new google.maps.Map(document.getElementById(map_area_id), map_options);
	return hotel_map;
	
}

function get_hotel_main(hotel_id, hotel_map, main_hotel_marker, is_mobile){
	
	$.ajax({
		url: "/hotel_on_map/get_hotel_main/",
		type: "POST",
		cache: true,
		dataType: 'json',
		data: {
			id:hotel_id
		},
		success:function(value){
			if(is_mobile != undefined && is_mobile == true){
				render_hotel_map_mobile(value, hotel_map, main_hotel_marker);
			}else{
				render_hotel_map_data(value, hotel_map, main_hotel_marker);
			}
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
	
}

/**
 * 
 * @param hotel_id: get from attribute data-hotel-id
 * @param des_id: get from attribute data-des-id
 */

function get_hotels_in_city(hotel_id, des_id, hotel_map, is_bounded, is_from_des, is_mobile){
	
	var h_in_city = 1; // default get all hotels in the city  (that contains the destinations)
	if(is_from_des != undefined && is_from_des == 1){
		h_in_city = 0; // get the hotels in the destination (area, districe, ...)
	}
	
	$.ajax({
		url: "/hotel_on_map/get_hotels_in_city/",
		type: "POST",
		cache: true,
		dataType: 'json',
		data: {
			hotel_id: hotel_id,
			des_id: des_id,
			hotel_in_city: h_in_city
		},
		success:function(value){
			if(value != ''){
				var bounds = new google.maps.LatLngBounds();
				for(var i = 0; i < value.length; i++){
					if(is_mobile != undefined && is_mobile == true){
						render_hotel_map_mobile(value[i], hotel_map);
					}else{
						render_hotel_map_data(value[i], hotel_map);
					}
					var latlng = new google.maps.LatLng(value[i].latitude, value[i].longitude);
					bounds.extend(latlng);
				}
				
				if(is_bounded != undefined && is_bounded == 1){
					hotel_map.fitBounds(bounds);
				}
				
			}	
		},
		error:function(var1, var2, var3){
			// do nothing
		}
	});
}


/**
 * 
 * @param des_id: get from attribute data-des-id
 */
function get_destinations_in_city(des_id, hotel_map, is_mobile){
	
	$.ajax({
		url: "/hotel_on_map/get_destinations_in_city/",
		type: "POST",
		cache: true,
		dataType: 'json',
		data: {
			des_id:des_id
		},
		success:function(value){
			if(value != ''){
				
				for(var i = 0; i < value.length; i++){
					if(is_mobile != undefined && is_mobile == true){
						render_destination_map_data_mobile(value[i], hotel_map);
					}else{
						render_destination_map_data(value[i], hotel_map);
					}
				}
				
				show_hotel_area_selections(value, hotel_map);
				
			}	
		},
		error:function(var1, var2, var3){
			//
		}
	});
}

// render the main hotel marker 
function render_main_hotel_marker(lat, lng, hotel_map){
	
	var hotel_img_marker = new google.maps.MarkerImage("/media/icon/icon-hotel.png");
	   
    var marker_options = {
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(lat, lng),
        icon: hotel_img_marker,
        map: hotel_map
	};
	        
	var marker = new google.maps.Marker(marker_options);
	
	return marker;
}


/**
 * Show hotel marker on the map
 * Show Infobox on the map
 */
function render_hotel_map_data(h_data, hotel_map, marker){
	var is_show_main_hotel_info = false;
	if(marker == '' || marker == undefined){
		// create hotel marker
		var hotel_img_marker = new google.maps.MarkerImage("/media/icon/hotel-marker.png");
	    var marker_options = {
	        animation: google.maps.Animation.DROP,
	        position: new google.maps.LatLng(parseFloat(h_data.latitude), parseFloat(h_data.longitude)),
	        icon: hotel_img_marker,
	        map: hotel_map
		};
	    
		var marker = new google.maps.Marker(marker_options);
	} else {
		is_show_main_hotel_info = true;
	}

	
	// create infobox for the hotel marker
	var hotel_info_box = build_hotel_info_box(h_data);
	
	
	if(is_show_main_hotel_info){
		hotel_info_box.open(hotel_map, marker);
		main_hotel_info_box = hotel_info_box;
	}
	
	
	google.maps.event.addListener(marker, 'mouseover', function(e) {
		
		if(main_hotel_info_box != ''){
			main_hotel_info_box.close();
		}
		
		hotel_info_box.open(hotel_map, marker);
	});
	
	google.maps.event.addListener(marker, 'mouseout', function(e) {
		
		hotel_info_box.close();
	});
	google.maps.event.addListener(marker, 'click', function(e) {
		window.open(h_data.full_url);
	});
	
	var tmp_marker_info = {marker: marker, map_type: 1, obj_data: h_data, info_box: hotel_info_box}; // map_type = 1 for Hotel, 2 for destination
	markers.push(tmp_marker_info);
	
	return tmp_marker_info;
}

/**
 * Show hotel marker on the map mobile
 * Show Infobox on the map mobile
 */

function render_hotel_map_mobile(h_data, hotel_map, marker){
	
	var is_mobile = true;
	var is_show_main_hotel_info = false;
	if(marker == '' || marker == undefined){
		// create hotel marker
		var hotel_img_marker = new google.maps.MarkerImage("/media/icon/hotel-marker.png");
	    var marker_options = {
	        animation: google.maps.Animation.DROP,
	        position: new google.maps.LatLng(parseFloat(h_data.latitude), parseFloat(h_data.longitude)),
	        icon: hotel_img_marker,
	        map: hotel_map
		};
	    
		var marker = new google.maps.Marker(marker_options);
	} else {
		is_show_main_hotel_info = true;
	}

	
	// create infobox for the hotel marker
	var hotel_info_box = build_hotel_info_box(h_data, is_mobile);
	
	
	if(is_show_main_hotel_info){
		hotel_info_box.open(hotel_map, marker);
		main_hotel_info_box = hotel_info_box;
	}
	
	
	google.maps.event.addListener(marker, 'click', function(e) {
		
		if(main_hotel_info_box != ''){
			main_hotel_info_box.close();
		}
		$('.infoBox').hide();
		hotel_info_box.open(hotel_map, marker);
	});
	
	var tmp_marker_info = {marker: marker, map_type: 1, obj_data: h_data, info_box: hotel_info_box}; // map_type = 1 for Hotel, 2 for destination
	markers.push(tmp_marker_info);
	
	return tmp_marker_info;
}

/**
 * Show destination marker on the map
 * Show Infobox on the map
 */
function render_destination_map_data(d_data, hotel_map, show_marker){
	var visible_ = false;
	if(show_marker != undefined && show_marker == 1){
		visible_ = true;
	}
	var des_img_marker = new google.maps.MarkerImage("/media/icon/des_icon.png");
	
	var marker_options = {
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(parseFloat(d_data.latitude), parseFloat(d_data.longitude)),
        icon: des_img_marker,
        map: hotel_map,
        visible: visible_
	};
	var marker = new google.maps.Marker(marker_options);
	
	// create infobox for the hotel marker
	var des_info_box = build_des_info_box(d_data);
	google.maps.event.addListener(marker, 'mouseover', function(e) {
		
		des_info_box.open(hotel_map, marker);
		
	});
	google.maps.event.addListener(marker, 'mouseout', function(e) {
		
		des_info_box.close();
	});
	if(d_data.number_of_hotels >0){
	
		google.maps.event.addListener(marker, 'click', function(e) {
			 window.open(d_data.full_url);
		});
	}
	
	var tmp_marker_info = {marker: marker, map_type: 2, obj_data: d_data, info_box: des_info_box}; // map_type = 1 for Hotel, 2 for destination
	markers.push(tmp_marker_info);
	
	return tmp_marker_info;
}

/*
 * 	Show destination marker on the mobile
 * 	Show Infobox on the mobile
 */

function render_destination_map_data_mobile(d_data, hotel_map, show_marker){
	var is_mobile = true;
	var visible_ = false;
	if(show_marker != undefined && show_marker == 1){
		visible_ = true;
	}
	var des_img_marker = new google.maps.MarkerImage("/media/icon/des_icon.png");
	
	var marker_options = {
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(parseFloat(d_data.latitude), parseFloat(d_data.longitude)),
        icon: des_img_marker,
        map: hotel_map,
        visible: visible_
	};
	var marker = new google.maps.Marker(marker_options);
	
	// create infobox for the hotel marker
	var des_info_box = build_des_info_box(d_data, is_mobile);
	
	
	google.maps.event.addListener(marker, 'click', function(e) {
		
		$('.infoBox').hide();
		des_info_box.open(hotel_map, marker);
		
	});
	
	/*
	if(d_data.number_of_hotels >0){
	
		google.maps.event.addListener(marker, 'click', function(e) {
			 window.open(d_data.full_url);
		});
	}
	*/
	
	var tmp_marker_info = {marker: marker, map_type: 2, obj_data: d_data, info_box: des_info_box}; // map_type = 1 for Hotel, 2 for destination
	markers.push(tmp_marker_info);
	
	return tmp_marker_info;
}


function create_hotel_popup_html(h_data, is_mobile){
	
	// create info-box 
	var data_html	= 
			'<div class="info-box">'
				+'<div class="title bpv-color-title" style="font-size:14px"><b>'+h_data.name+'</b> <span class="icon star-'+h_data.star+'"></span></div>'
				+'<table class="details"><tr>'
						+'<td><img width="90" height="68" src="'+h_data.img_url+'"></td>'
						+'<td style="font-size:12px;">'+h_data.address+'';
	if(h_data.price_origin != undefined && h_data.price_from != undefined && h_data.price_origin >0 && h_data.price_from >0){
		
		var data_ = '';
		if(is_mobile != undefined && is_mobile == true){
			data_ = '<div><div class="margin-left-10"> <div class="bpv-price-origin">'+bpv_format_currency(h_data.price_origin, ' đ')+'</div>'
							+'<div class="bpv-price-from">'+bpv_format_currency(h_data.price_from,' đ')+'</div></div>'
						+'</td>'
				+'</tr>'
				+'</table>'
				+'<div class="text-center margin-top-5"><a href="'+h_data.full_url+'"><button type="button" class="btn btn-default" style="white-space:normal;width:70%">Xem chi tiết</button></a></div></div>';
		}else{
			data_ = '<div><div class="margin-left-10"> <div class="bpv-price-origin">'+bpv_format_currency(h_data.price_origin, ' đ')+'</div>'
							+'<div class="bpv-price-from">'+bpv_format_currency(h_data.price_from,' đ')+'</div></div>'
						+'</td>'
					+'</tr></table>'
					+'</div>';
		}
		data_html = data_html + data_;
	}else{
		var data_not_price = '';
		
		if(is_mobile !=undefined && is_mobile == true){
			data_not_price = '</td>'
							+'</tr>'
							+'</table>'
							+'<div class="text-center margin-top-10"><a href="'+h_data.full_url+'"><button type="button" class="btn btn-default" style="white-space:normal;width:70%">Xem chi tiết</button></a></div></div>';
		}else{
			data_not_price = '</td>'
				+'</tr>'
				+'</table>'
				+'</div>';
		}
		data_html = data_html + data_not_price;
	}

	return data_html ;
}

function build_hotel_info_box(h_data, is_mobile){
	var closeBoxMargin_mobile = "";
	var closeBoxURL_mobile = "";
	
	var xOffset = -180;
	var yOffset = -100;
	
	if(is_mobile != undefined && is_mobile == true){
		closeBoxMargin_mobile = "-5px -5px 0 0";
		closeBoxURL_mobile = "/media/icon/hotel_detail/close.gif";
		xOffset = -140;
		yOffset = 0;
	}
	var infobox_content = create_hotel_popup_html(h_data, is_mobile);

	var infobox_options = {
       disableAutoPan: false
       ,maxWidth: 0
       ,pixelOffset: new google.maps.Size(xOffset, yOffset)
       ,zIndex: null
       ,boxStyle: { opacity: 1 ,width: "auto"}
       ,infoBoxClearance: new google.maps.Size(1, 1)
       ,isHidden: false
       ,pane: "floatPane"
       ,enableEventPropagation: true
       ,closeBoxMargin: closeBoxMargin_mobile
       ,closeBoxURL: closeBoxURL_mobile
    };
	
    var info_box = new InfoBox(infobox_options);
    
    info_box.setContent(infobox_content);
  
    
    return info_box;
	
}

function create_des_popup_html(d_data, is_mobile){
	
	var data_html	= 	'<div class="info-box text-center" ><label class="bpv-color-title">' + d_data.name + '</label>';

	if(d_data.number_of_hotels >0){
		if(is_mobile != undefined && is_mobile == true){
			data_html += ' <label class="note">('+d_data.number_of_hotels+') khách sạn </label>'+'<br/><a href="'+d_data.full_url+'"><button type="button" class="btn btn-default" style="white-space:normal;width:85%">Xem các khách sạn tại '+d_data.name+'</button></a>';
		}else{
			data_html += ' <label class="note">('+d_data.number_of_hotels+') khách sạn </label>'+'<br/><div class="note">Click để xem các khách sạn tại '+d_data.name+'</div>';
		}
	}
	data_html += '</div>';
	return data_html;
}

function build_des_info_box(d_data, is_mobile){
	
	var closeBoxMargin_mobile = "";
	var closeBoxURL_mobile = "";
	
	var xOffset = -100;
	var yOffset = -100;
	
	if(is_mobile != undefined && is_mobile == true){
		
		closeBoxMargin_mobile = "-5px -5px 0 0";
		closeBoxURL_mobile = "/media/icon/hotel_detail/close.gif";
		xOffset = -140;
		yOffset = 0;
		
	}
	
	var infobox_content = create_des_popup_html(d_data, is_mobile);
	
	var infobox_options = {
       disableAutoPan: false
       ,maxWidth: 0
       ,pixelOffset: new google.maps.Size(xOffset, yOffset)
       ,zIndex: null
       ,boxStyle: { opacity: 1 ,width: "auto"}
	   ,closeBoxMargin: closeBoxMargin_mobile
	   ,closeBoxURL: closeBoxURL_mobile
       ,infoBoxClearance: new google.maps.Size(1, 1)
       ,isHidden: false
       ,pane: "floatPane"
       ,enableEventPropagation: true
    };
	
    var info_box = new InfoBox(infobox_options);
    
    info_box.setContent(infobox_content);
  
    
    return info_box;
	
}



/**
 * Filter maps functions
 */

function init_filter_status(){
	$('#hm_show_hotel').prop('checked', true);
	$('#hm_show_des').prop('checked', false);
	$('.hm-filter-stars').each(function(){
		
		$(this).prop('checked', true);
		
	});
}

function filter_map_data(){
	
	var is_show_hotel = $('#hm_show_hotel').is(':checked');	
	var is_show_des = $('#hm_show_des').is(':checked');
	
	
	var stars = new Array();
	
	$('.hm-filter-stars').each(function(){
		
		var star = $(this).val();
		if($(this).is(':checked')){
			stars.push(star);
		}
	});
	
	for(var i = 0; i < markers.length; i++){
		
		var marker_info = markers[i];
		
		if(marker_info.map_type == 1){ // hotel
			
			var h_star = marker_info.obj_data.star;
			
			var is_contain_star = false;
			for(var j=0; j< stars.length;j++){
				if(h_star == stars[j]){
					is_contain_star = true;
					break;
				}
			}
			
			var marker_visible = is_contain_star && is_show_hotel;
			
			marker_info.marker.setVisible(marker_visible);
			
			if(!marker_visible){
				marker_info.info_box.close();
			}
			
			
		} else { // destination
			
			marker_info.marker.setVisible(is_show_des);
			
			if(!is_show_des){
				
				marker_info.info_box.close();
				
			}
			
		}
		
	}
}

function show_hotel_area_selections(destinations, hotel_map){
	
	if(destinations.length > 0){
		
		current_hotel_map = hotel_map;
		
		var districts = new Array();
		var areas = new Array();
		var attractions = new Array();
		var others = new Array();
		
		for(var i = 0; i < destinations.length; i++){
			
			if(destinations[i].type == 5){ // district
				
				districts.push(destinations[i]);
				
			} else if(destinations[i].type == 6){ //area
				
				areas.push(destinations[i]);
				
			} else if(destinations[i].type == 7){ //attraction
				
				attractions.push(destinations[i]);
				
			} else {
				
				others.push(destinations[i]);
			}
			
		}
			
		var select_html = '<select class="form-control input-sm" id="hm_select_area" onchange="select_hm_area()">';
		
		select_html = select_html + '<option value="">----Chọn khu vực---</option>';
		
		if(attractions.length > 0){
			select_html = select_html + '<optgroup label="Điểm đến hấp dẫn">';
			
			for(var i = 0; i < attractions.length; i++){
				select_html = select_html + '<option lat="' + attractions[i].latitude + '" lng="' + attractions[i].longitude + '" value="' + attractions[i].id + '">' + attractions[i].name + '</option>';
			}
			
			select_html = select_html + '</optgroup>';
		}
		
		if(areas.length > 0){
			select_html = select_html + '<optgroup label="Khu vực">';
			
			for(var i = 0; i < areas.length; i++){
				select_html = select_html + '<option lat="' + areas[i].latitude + '" lng="' + areas[i].longitude + '" value="' + areas[i].id + '">' + areas[i].name + '</option>';
			}
			
			select_html = select_html + '</optgroup>';
		}
		
		if(districts.length > 0){
			select_html = select_html + '<optgroup label="Quận/Huyện">';
			
			for(var i = 0; i < districts.length; i++){
				select_html = select_html + '<option lat="' + districts[i].latitude + '" lng="' + districts[i].longitude + '" value="' + districts[i].id + '">' + districts[i].name + '</option>';
			}
			
			select_html = select_html + '</optgroup>';
		}
		
		if(others.length > 0){
			select_html = select_html + '<optgroup label="Địa danh khác">';
			
			for(var i = 0; i < others.length; i++){
				select_html = select_html + '<option lat="' + others[i].latitude + '" lng="' + others[i].longitude + '" value="' + others[i].id + '">' + others[i].name + '</option>';
			}
			
			select_html = select_html + '</optgroup>';
		}
		
		
		
		select_html = select_html + '</select>';
		
		$('#hm_area').html(select_html);
		
		// show the area of select destination
		$('.hm-area-info').css('visibility','visible');
		
	}
}

function select_hm_area(hotel_map){
	//alert('hotel_map = ' + hotel_map);
	
	var lat = $("#hm_select_area option:selected").attr('lat');
	
	var lng = $("#hm_select_area option:selected").attr('lng');
	
	var des_id = $("#hm_select_area option:selected").attr('value');
	
	if(des_id != ''){
		
	
		var myLatlng = new google.maps.LatLng(lat , lng);
		
		current_hotel_map.setCenter(myLatlng);
		
		for(var i=0; i < markers.length; i++){
			
			if(markers[i].map_type == 2){ // destination
				
				if(markers[i].obj_data.id == des_id){
					
					markers[i].marker.setVisible(true);
					
					markers[i].info_box.open(current_hotel_map, markers[i].marker);
				
				} else {
					
					markers[i].marker.setVisible(false);
					
					markers[i].info_box.close();
				}
				
			}
			
		}
	
	}
}

