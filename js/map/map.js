function InfoBox(a){a=a||{};google.maps.OverlayView.apply(this,arguments);this.content_=a.content||"";this.disableAutoPan_=a.disableAutoPan||false;this.maxWidth_=a.maxWidth||0;this.pixelOffset_=a.pixelOffset||new google.maps.Size(0,0);this.position_=a.position||new google.maps.LatLng(0,0);this.zIndex_=a.zIndex||null;this.boxClass_=a.boxClass||"infoBox";this.boxStyle_=a.boxStyle||{};this.closeBoxMargin_=a.closeBoxMargin||"2px";this.closeBoxURL_=a.closeBoxURL||"http://www.google.com/intl/en_us/mapfiles/close.gif";if(a.closeBoxURL===""){this.closeBoxURL_=""}this.infoBoxClearance_=a.infoBoxClearance||new google.maps.Size(1,1);this.isHidden_=a.isHidden||false;this.alignBottom_=a.alignBottom||false;this.pane_=a.pane||"floatPane";this.enableEventPropagation_=a.enableEventPropagation||false;this.div_=null;this.closeListener_=null;this.eventListener1_=null;this.eventListener2_=null;this.eventListener3_=null;this.moveListener_=null;this.contextListener_=null;this.fixedWidthSet_=null}InfoBox.prototype=new google.maps.OverlayView();InfoBox.prototype.createInfoBoxDiv_=function(){var d;var a=this;var b=function(f){f.cancelBubble=true;if(f.stopPropagation){f.stopPropagation()}};var c=function(f){f.returnValue=false;if(f.preventDefault){f.preventDefault()}if(!a.enableEventPropagation_){b(f)}};if(!this.div_){this.div_=document.createElement("div");this.setBoxStyle_();if(typeof this.content_.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+this.content_}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(this.content_)}this.getPanes()[this.pane_].appendChild(this.div_);this.addClickHandler_();if(this.div_.style.width){this.fixedWidthSet_=true}else{if(this.maxWidth_!==0&&this.div_.offsetWidth>this.maxWidth_){this.div_.style.width=this.maxWidth_;this.div_.style.overflow="auto";this.fixedWidthSet_=true}else{d=this.getBoxWidths_();this.div_.style.width=(this.div_.offsetWidth-d.left-d.right)+"px";this.fixedWidthSet_=false}}this.panBox_(this.disableAutoPan_);if(!this.enableEventPropagation_){this.eventListener1_=google.maps.event.addDomListener(this.div_,"mousedown",b);this.eventListener2_=google.maps.event.addDomListener(this.div_,"click",b);this.eventListener3_=google.maps.event.addDomListener(this.div_,"dblclick",b);this.eventListener4_=google.maps.event.addDomListener(this.div_,"mouseover",function(f){this.style.cursor="default"})}this.contextListener_=google.maps.event.addDomListener(this.div_,"contextmenu",c);google.maps.event.trigger(this,"domready")}};InfoBox.prototype.getCloseBoxImg_=function(){var a="";if(this.closeBoxURL_!==""){a="<img";a+=" src='"+this.closeBoxURL_+"'";a+=" align=right";a+=" style='";a+=" position: relative;";a+=" cursor: pointer;";a+=" margin: "+this.closeBoxMargin_+";";a+="'>"}return a};InfoBox.prototype.addClickHandler_=function(){var a;if(this.closeBoxURL_!==""){a=this.div_.firstChild;this.closeListener_=google.maps.event.addDomListener(a,"click",this.getCloseClickHandler_())}else{this.closeListener_=null}};InfoBox.prototype.getCloseClickHandler_=function(){var a=this;return function(b){b.cancelBubble=true;if(b.stopPropagation){b.stopPropagation()}a.close();google.maps.event.trigger(a,"closeclick")}};InfoBox.prototype.panBox_=function(o){var d;var b;var m=0,i=0;if(!o){d=this.getMap();if(d instanceof google.maps.Map){if(!d.getBounds().contains(this.position_)){d.setCenter(this.position_)}b=d.getBounds();var q=d.getDiv();var j=q.offsetWidth;var l=q.offsetHeight;var f=this.pixelOffset_.width;var e=this.pixelOffset_.height;var k=this.div_.offsetWidth;var p=this.div_.offsetHeight;var h=this.infoBoxClearance_.width;var g=this.infoBoxClearance_.height;var a=this.getProjection().fromLatLngToContainerPixel(this.position_);if(a.x<(-f+h)){m=a.x+f-h}else{if((a.x+k+f+h)>j){m=a.x+k+f+h-j}}if(this.alignBottom_){if(a.y<(-e+g+p)){i=a.y+e-g-p}else{if((a.y+e+g)>l){i=a.y+e+g-l}}}else{if(a.y<(-e+g)){i=a.y+e-g}else{if((a.y+p+e+g)>l){i=a.y+p+e+g-l}}}if(!(m===0&&i===0)){var n=d.getCenter();d.panBy(m,i)}}}};InfoBox.prototype.setBoxStyle_=function(){var a,b;if(this.div_){this.div_.className=this.boxClass_;this.div_.style.cssText="";b=this.boxStyle_;for(a in b){if(b.hasOwnProperty(a)){this.div_.style[a]=b[a]}}if(typeof this.div_.style.opacity!=="undefined"&&this.div_.style.opacity!==""){this.div_.style.filter="alpha(opacity="+(this.div_.style.opacity*100)+")"}this.div_.style.position="absolute";this.div_.style.visibility="hidden";if(this.zIndex_!==null){this.div_.style.zIndex=this.zIndex_}}};InfoBox.prototype.getBoxWidths_=function(){var a;var c={top:0,bottom:0,left:0,right:0};var b=this.div_;if(document.defaultView&&document.defaultView.getComputedStyle){a=b.ownerDocument.defaultView.getComputedStyle(b,"");if(a){c.top=parseInt(a.borderTopWidth,10)||0;c.bottom=parseInt(a.borderBottomWidth,10)||0;c.left=parseInt(a.borderLeftWidth,10)||0;c.right=parseInt(a.borderRightWidth,10)||0}}else{if(document.documentElement.currentStyle){if(b.currentStyle){c.top=parseInt(b.currentStyle.borderTopWidth,10)||0;c.bottom=parseInt(b.currentStyle.borderBottomWidth,10)||0;c.left=parseInt(b.currentStyle.borderLeftWidth,10)||0;c.right=parseInt(b.currentStyle.borderRightWidth,10)||0}}}return c};InfoBox.prototype.onRemove=function(){if(this.div_){this.div_.parentNode.removeChild(this.div_);this.div_=null}};InfoBox.prototype.draw=function(){this.createInfoBoxDiv_();var a=this.getProjection().fromLatLngToDivPixel(this.position_);this.div_.style.left=(a.x+this.pixelOffset_.width)+"px";if(this.alignBottom_){this.div_.style.bottom=-(a.y+this.pixelOffset_.height)+"px"}else{this.div_.style.top=(a.y+this.pixelOffset_.height)+"px"}if(this.isHidden_){this.div_.style.visibility="hidden"}else{this.div_.style.visibility="visible"}};InfoBox.prototype.setOptions=function(a){if(typeof a.boxClass!=="undefined"){this.boxClass_=a.boxClass;this.setBoxStyle_()}if(typeof a.boxStyle!=="undefined"){this.boxStyle_=a.boxStyle;this.setBoxStyle_()}if(typeof a.content!=="undefined"){this.setContent(a.content)}if(typeof a.disableAutoPan!=="undefined"){this.disableAutoPan_=a.disableAutoPan}if(typeof a.maxWidth!=="undefined"){this.maxWidth_=a.maxWidth}if(typeof a.pixelOffset!=="undefined"){this.pixelOffset_=a.pixelOffset}if(typeof a.alignBottom!=="undefined"){this.alignBottom_=a.alignBottom}if(typeof a.position!=="undefined"){this.setPosition(a.position)}if(typeof a.zIndex!=="undefined"){this.setZIndex(a.zIndex)}if(typeof a.closeBoxMargin!=="undefined"){this.closeBoxMargin_=a.closeBoxMargin}if(typeof a.closeBoxURL!=="undefined"){this.closeBoxURL_=a.closeBoxURL}if(typeof a.infoBoxClearance!=="undefined"){this.infoBoxClearance_=a.infoBoxClearance}if(typeof a.isHidden!=="undefined"){this.isHidden_=a.isHidden}if(typeof a.enableEventPropagation!=="undefined"){this.enableEventPropagation_=a.enableEventPropagation}if(this.div_){this.draw()}};InfoBox.prototype.setContent=function(a){this.content_=a;if(this.div_){if(this.closeListener_){google.maps.event.removeListener(this.closeListener_);this.closeListener_=null}if(!this.fixedWidthSet_){this.div_.style.width=""}if(typeof a.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+a}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(a)}if(!this.fixedWidthSet_){this.div_.style.width=this.div_.offsetWidth+"px";if(typeof a.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+a}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(a)}}this.addClickHandler_()}google.maps.event.trigger(this,"content_changed")};InfoBox.prototype.setPosition=function(a){this.position_=a;if(this.div_){this.draw()}google.maps.event.trigger(this,"position_changed")};InfoBox.prototype.setZIndex=function(a){this.zIndex_=a;if(this.div_){this.div_.style.zIndex=a}google.maps.event.trigger(this,"zindex_changed")};InfoBox.prototype.getContent=function(){return this.content_};InfoBox.prototype.getPosition=function(){return this.position_};InfoBox.prototype.getZIndex=function(){return this.zIndex_};InfoBox.prototype.show=function(){this.isHidden_=false;if(this.div_){this.div_.style.visibility="visible"}};InfoBox.prototype.hide=function(){this.isHidden_=true;if(this.div_){this.div_.style.visibility="hidden"}};InfoBox.prototype.open=function(c,a){var b=this;if(a){this.position_=a.getPosition();this.moveListener_=google.maps.event.addListener(a,"position_changed",function(){b.setPosition(this.getPosition())})}this.setMap(c);if(this.div_){this.panBox_()}};InfoBox.prototype.close=function(){if(this.closeListener_){google.maps.event.removeListener(this.closeListener_);this.closeListener_=null}if(this.eventListener1_){google.maps.event.removeListener(this.eventListener1_);google.maps.event.removeListener(this.eventListener2_);google.maps.event.removeListener(this.eventListener3_);google.maps.event.removeListener(this.eventListener4_);this.eventListener1_=null;this.eventListener2_=null;this.eventListener3_=null;this.eventListener4_=null}if(this.moveListener_){google.maps.event.removeListener(this.moveListener_);this.moveListener_=null}if(this.contextListener_){google.maps.event.removeListener(this.contextListener_);this.contextListener_=null}this.setMap(null)};

function init_route_map(map_id) {
	
	var id = $(map_id).attr('data-id');
	var bpv_map = render_map(map_id);
	console.log('Start render google map');
	
	$.ajax({
		url: "/get_route_map/",
		type: "POST",
		cache: true,
		dataType: 'json',
		data: {'id' : id},
		success:function(data){
			if(data != ''){
				bpv_map_data = data;
				render_marker(bpv_map, bpv_map_data);
			}	
		},
		error:function(){
			// do nothing
		}
	});
	
	return bpv_map;
}

function render_map(map_area_id, zoom, is_mobile) {

	var zoom_ = !zoom ? 5 : zoom;

	// set center position
	var center_position = new google.maps.LatLng(16.051752, 108.214722);

	var map_options = {
		center : center_position,
		zoom : zoom_,
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		panControl: false,
	    zoomControl: true,
	    scaleControl: true,
	    mapTypeControl: false
	};
	
	var bpv_map = new google.maps.Map(document.getElementById(map_area_id.replace('#','')), map_options);
	
	var styles = [ {
		"featureType" : "landscape",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "administrative.country",
		"elementType" : "labels",
		"stylers" : [ {
			"visibility" : "on"
		} ]
	}, {
		"featureType" : "administrative.province",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "road",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "administrative.locality",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "poi.park",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "administrative.country",
		"stylers" : [ {
			"visibility" : "on"
		}, {
			"weight" : 0.7
		} ]
	}, {
		"featureType" : "water",
		"elementType" : "labels",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, ];

	bpv_map.setOptions({styles: styles});

	return bpv_map;
}

function render_marker(bpv_map, data, is_mobile) {

	var icon = {
		//url : "/media/icon/icon-map.png",
		path: "M255,0C114.75,0,0,114.75,0,255s114.75,255,255,255s255-114.75,255-255S395.25,0,255,0z",
		fillColor: '#E53935',
		fillOpacity: 1,
		anchor : new google.maps.Point(300, 300),
		scale: 1/60,
		zIndex: -100
	};
	
	var icoAirplane = {
	    path: 'M510,255c0-20.4-17.85-38.25-38.25-38.25H331.5L204,12.75h-51l63.75,204H76.5l-38.25-51H0L25.5,255L0,344.25h38.25    l38.25-51h140.25l-63.75,204h51l127.5-204h140.25C492.15,293.25,510,275.4,510,255z',
	    fillColor: '#E53935',
	    fillOpacity: 1,
	    scale: 1/30,
	    rotation: 260,
	    anchor : new google.maps.Point(0, -200),
	    clickable : false, //important,
	    zIndex: 1000
	};
	

	var icoCar = {
		//path : 'M526.745,312.866h-15.005c-3.706-18.736-10.307-44.359-20.792-57.941c-49.022-63.573-110.574-97.697-187.945-97.697   c-50.134,0-82.787,4.902-99.789,14.981c-2.295,1.363-9.063,5.369-27.344,42.135c-26.687,0.419-97.278,5.261-131.127,43.414   c-16.99,19.143-23.746,39.719-26.352,55.096h-7.078C5.058,312.854,0,317.924,0,324.177c0,6.241,5.058,11.323,11.311,11.323h5.655   c0.048,0.61,0.096,1.076,0.108,1.219c0.598,5.739,5.464,10.115,11.239,10.115h14.252c8.752,19.968,28.66,33.981,51.831,33.981   s43.079-14.013,51.855-33.981h215.982c8.74,19.968,28.66,33.981,51.832,33.981c23.172,0,43.091-14.013,51.832-33.981h38.165   c0.084,0,0.155,0,0.215,0c6.253,0,11.335-5.07,11.335-11.323h11.131c6.241,0,11.299-5.081,11.299-11.323   C538.044,317.924,532.986,312.866,526.745,312.866z M94.397,358.169c-18.724,0-33.968-15.232-33.968-33.981   c0-18.748,15.232-33.992,33.968-33.992c18.748,0,34.004,15.245,34.004,33.992C128.402,342.937,113.145,358.169,94.397,358.169z    M295.183,226.433c0,3.133-2.523,5.667-5.667,5.667h-87.964c-1.937,0-3.742-1.016-4.783-2.666   c-1.052-1.662-1.148-3.731-0.287-5.476c4.149-8.537,11.67-23.327,15.269-26.4c11.981-7.616,36.001-11.227,72.002-11.227   c1.961,0,3.922,0.024,5.906,0.06c3.061,0.072,5.512,2.595,5.512,5.667L295.183,226.433L295.183,226.433z M306.53,226.433V193.66   c0-1.614,0.705-3.157,1.901-4.233c1.208-1.076,2.81-1.614,4.424-1.399c39.863,4.687,70.519,17.875,82.058,35.272   c1.16,1.746,1.244,3.97,0.263,5.811c-0.968,1.841-2.905,2.989-4.998,2.989h-78.004C309.077,232.1,306.53,229.565,306.53,226.433z    M414.067,358.169c-18.724,0-33.98-15.232-33.98-33.981c0-18.748,15.244-33.992,33.98-33.992c18.736,0,33.98,15.245,33.98,33.992   C448.047,342.937,432.791,358.169,414.067,358.169z',
		path: 'M43.782,17.795h-0.113L38.994,6.935C38.67,6.18,37.93,5.695,37.109,5.695H8.727c-0.82,0-1.56,0.485-1.883,1.239    L2.165,17.795H2.051C0.917,17.795,0,18.712,0,19.846v3.398v8.996c0,1.133,0.917,2.051,2.051,2.051h0.771v3.797    c0,1.134,0.916,2.053,2.051,2.053h4.93c1.132,0,2.051-0.919,2.051-2.053v-3.797H33.98v3.797c0,1.134,0.918,2.053,2.051,2.053h4.93    c1.137,0,2.053-0.919,2.053-2.053v-3.797h0.771c1.134,0,2.052-0.918,2.052-2.051v-8.996v-3.398    C45.834,18.712,44.916,17.795,43.782,17.795z M10.075,9.795h25.684l3.445,8H6.631L10.075,9.795z M8.879,30.049    c-2.213,0-4.009-1.795-4.009-4.006c0-2.213,1.796-4.008,4.009-4.008c2.214,0,4.008,1.795,4.008,4.008    C12.887,28.254,11.093,30.049,8.879,30.049z M36.91,30.049c-2.213,0-4.01-1.795-4.01-4.006c0-2.213,1.797-4.008,4.01-4.008    c2.214,0,4.008,1.795,4.008,4.008C40.918,28.254,39.124,30.049,36.91,30.049z',
		fillColor : '#E53935',
		fillOpacity : 1,
		scale : 1/3,
		rotation : 0,
		anchor : new google.maps.Point(-50, -50),
		clickable : false // important
	};

	var markers = [];
	var routes = [];
	var bounds = new google.maps.LatLngBounds();

	for (var i = 0; i < data.length; i++) {

		var marker_pos = new google.maps.LatLng(parseFloat(data[i].latitude), parseFloat(data[i].longitude));

		var marker = new google.maps.Marker({
			//animation : google.maps.Animation.DROP,
			position : marker_pos,
			map : bpv_map,
			draggable : false,
			icon : icon,
		});
		
		// destination label
		var mapLabel = new MapLabel({
	        text: data[i].name,
	        position: new google.maps.LatLng(data[i].latitude, data[i].longitude),
	        map: bpv_map,
	        align: 'bottom'
	    });
		
		// add infobox
		// The problem is that the variable info_box is getting overwritten for each iteration of the loop
		// Normally this wouldn't be a problem, except that the part inside addListener is an asynchronous callback, and by the time each gets invoked, 
		// the reference to infoWindow is no longer correct.
		// You can get around this by creating a closure for info_box, so that each callback function gets its own copy
		var info_box = build_info_box(data[i], is_mobile);
		
		google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
	        return function() {
	        	var infobox_content = render_info_box_html(data[i], is_mobile);
	        	info_box.setContent(infobox_content);
	        	info_box.open(bpv_map, marker);
	        }
	    })(marker, i));
		
		google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
	        return function() {
	        	info_box.close();
	        }
	    })(marker, i));
	
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
	        return function() {
	        	window.open(data[i].full_url);
	        }
	    })(marker, i));

		// To add the marker to the map, call setMap();
		marker.setMap(bpv_map);
		
		bounds.extend(marker_pos);
		
		/* Add you'r curved lines here */
		if( typeof data[i+1] != 'undefined' ) {
			
			var point1 = new google.maps.LatLng(data[i].latitude, data[i].longitude);
			var point2 = new google.maps.LatLng(data[i+1].latitude, data[i+1].longitude);
			var heading = google.maps.geometry.spherical.computeHeading(point1,point2);
			
			var is_horizontal = (heading > 160 && heading < 200) ? true : false;
			
			var transport = icoAirplane;
			if(i==1) transport = icoCar;
			
			$(bpv_map).curvedLine({
				LatStart: Number(data[i].latitude), 
		        LngStart: Number(data[i].longitude), 
		        LatEnd: Number(data[i+1].latitude), 
		        LngEnd: Number(data[i+1].longitude),
		        Map: bpv_map,
		        Horizontal: is_horizontal,
		        Multiplier: 3,
		        //Icon: transport
		    });
		}

		//routes.push(marker_pos);
	}
	
	// set route
	/*var routePath = new google.maps.Polyline({
		path : routes,
		geodesic : true,
		strokeColor : '#FB7802',
		strokeOpacity : 1.0,
		strokeWeight : 3
	});

	routePath.setMap(bpv_map);*/
	
	// set bounds
	bpv_map.fitBounds(bounds);
	var listener = google.maps.event.addListener(bpv_map, "idle", function() { 
	  if (bpv_map.getZoom() > 6) bpv_map.setZoom(6); 
	  google.maps.event.removeListener(listener); 
	});
}

function build_info_box(data, is_mobile){
	
	var closeBoxMargin_mobile = "";
	var closeBoxURL_mobile = "";
	
	var xOffset = -100;
	var yOffset = -100;
	
	if(is_mobile != undefined && is_mobile == true){
		// mobile version
	}
	
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
    
    return info_box;
}

function render_info_box_html(data, is_mobile) {

	var data_html = '<div class="info-box" >';

	if (is_mobile != undefined && is_mobile == true) {
		// do nothing
	} else {
		data_html += '<h4 class="text-highlight margin-bottom-5">' + data.name + '</h4>';
		data_html += '<table><tr>';
		data_html += '<td><img src="' + data.picture + '" width="120" height="80"></td>';
		data_html += '<td valign="top" style="padding-left:10px">' + data.description + '</td>';
		data_html += '</tr></table>';
	}

	data_html += '</div>';
	
	return data_html;
}