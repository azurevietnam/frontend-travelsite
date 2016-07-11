/* 
	Simple jQuery Curved Line Plugin for use with Google Maps Api 
	
	author: Daniel Nanovski
	modifications: Coen de Jong
	version: 0.0.2 (Beta)
	website: http://curved_lines.overfx.net/
	
	License:
	Copyright (c) 2012 Daniel Nanovski, http://overfx.net/
*/
(function($){
	
	var evenOdd = 0;
 
    $.fn.extend({ 
 
        curvedLine: function(options) { 
		
			var defaults = {
                LatStart: null,
                LngStart: null,
                LatEnd: null,
				LngEnd: null,
				Color: "#E53935",
				Opacity: 1,
				Weight: 1,
				GapWidth: 0,
				Horizontal: true,
				Multiplier: 1,
				Resolution: 0.1,
				Map: null,
				Icon: null
            }
                 
            var options =  $.extend(defaults, options);
 
            return this.each(function() {
                
				var o = options;
				
				var LastLat = o.LatStart;
				var LastLng = o.LngStart;
				
				var Map = o.Map;
				var Icon = o.Icon;
				
				var PartLat;
				var PartLng;
					
				var Points = new Array();
				var PointsOffset = new Array();
				
				for(point = 0; point <= 1; point += o.Resolution) {
					Points.push(point);
					offset = (0.6 * Math.sin((Math.PI * point / 1)));
					PointsOffset.push(offset);
				}
						
				var OffsetMultiplier = 0;
				
				if(o.Horizontal == true) {
				
					var OffsetLenght = (o.LngEnd - o.LngStart) * 0.1;
				
				} else {
					
					var OffsetLenght = (o.LatEnd - o.LatStart) * 0.1;
					
				}
				
				for(var i = 0; i < Points.length; i++) {
					
					// show arrow in the middle of polyline
					var isShowIcon = false;
					if(i == Math.round(Points.length/2)) {
						isShowIcon = true;
					}
					
					if(i == 4) {
						
						OffsetMultiplier = 1.5 * o.Multiplier;
						
					}
					
					if(i >= 5) {
						
						OffsetMultiplier = (OffsetLenght * PointsOffset[i]) * o.Multiplier;
						
					} else {
					
						OffsetMultiplier = (OffsetLenght * PointsOffset[i]) * o.Multiplier;
						
					}
					
					if(o.Horizontal == true) {
					
						PartLat = (o.LatStart + ((o.LatEnd - o.LatStart) * Points[i])) + OffsetMultiplier;
						PartLng = (o.LngStart + ((o.LngEnd - o.LngStart) * Points[i]));
					
					} else {
						
						PartLat = (o.LatStart + ((o.LatEnd - o.LatStart) * Points[i]));
						PartLng = (o.LngStart + ((o.LngEnd - o.LngStart) * Points[i])) + OffsetMultiplier;
						
					}
					
					curvedLineCreateSegment(LastLat,LastLng,PartLat, PartLng, o.Color, o.Opacity, o.Weight, o.GapWidth, o.Map, isShowIcon, Icon);
					
					LastLat = PartLat;
					LastLng = PartLng;
				
				}
				
				curvedLineCreateSegment(LastLat, LastLng, o.LatEnd, o.LngEnd, o.Color, o.Opacity, o.Weight, o.GapWidth, o.Map, false, Icon);
             
            });
        
		}
		
    });
	
	function curvedLineCreateSegment(LatStart, LngStart, LatEnd, LngEnd, Color, Opacity, Weight, GapWidth, Map, ShowIcon, TransportType) {
				
			evenOdd++;

			if(evenOdd % (GapWidth+1))
				return;
				
			var LineCordinates = new Array();
			
			var symbolArrow = {
				path: 'M1082 2673 c-16 -15 -300 -662 -612 -1398 -26 -60 -142 -332 -259 -603 -195 -454 -212 -496 -201 -522 10 -24 46 -50 70 -50 5 0 177 72 383 160 469 200 492 206 624 175 67 -16 72 -18 392 -197 119 -66 260 -145 313 -174 125 -70 176 -70 194 0 3 14 -29 134 -85 312 -49 159 -155 498 -234 754 -80 256 -218 701 -308 990 -119 382 -170 531 -186 548 -27 26 -63 28 -91 5z',
			    fillColor: '#E53935',
			    fillOpacity: 1,
			    scale: 1/240,
			    rotation: 180,
			    anchor : new google.maps.Point(1000, 1000),
			    clickable : false //important
			  };
			
			LineCordinates[0] = new google.maps.LatLng(LatStart, LngStart);
			LineCordinates[1] = new google.maps.LatLng(LatEnd, LngEnd);
			
			var Line = new google.maps.Polyline({
				path: LineCordinates,
				geodesic: false,
				strokeColor: Color,
				strokeOpacity: Opacity,
				strokeWeight: Weight,
			});
			
			if(ShowIcon) {
				Line.setOptions({ 
					icons: [ 
					    { icon : symbolArrow, offset : '50%'},
					   // { icon : TransportType, offset : '100%'},
					] 
				});
			}
			
			Line.setMap(Map);	
	 
		
	}	
     
})(jQuery);