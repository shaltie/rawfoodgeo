"use strict";
(function(A) {
"use strict";
	if (!Array.prototype.forEach)
		A.forEach = A.forEach || function(action, that) {
			for (var i = 0, l = this.length; i < l; i++)
				if (i in this)
					action.call(that, this[i], i, this);
		};

})(Array.prototype);

var global_scrollwheel = true;

function initialize () {
			"use strict";
			var bounds  = new google.maps.LatLngBounds();
			var mapOptions = {
				zoom: 13,
				center: new google.maps.LatLng(40.7834300 , -73.9662500),
				mapTypeId: google.maps.MapTypeId.ROADMAP,

				mapTypeControl: false,
				mapTypeControlOptions: {
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
					position: google.maps.ControlPosition.LEFT_CENTER
				},
				panControl: false,
				panControlOptions: {
					position: google.maps.ControlPosition.TOP_RIGHT
				},
				zoomControl: false,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.LARGE,
					position: google.maps.ControlPosition.TOP_RIGHT
				},
				scaleControl: false,
				scaleControlOptions: {
					position: google.maps.ControlPosition.TOP_LEFT
				},
				streetViewControl: false,
				streetViewControlOptions: {
					position: google.maps.ControlPosition.LEFT_TOP
				},
				styles: global_map_styles,
				scrollwheel: global_scrollwheel
			};
			var
			marker,loc;
			
			mapObject = new google.maps.Map(document.getElementById('map'), mapOptions);
			for (var key in markersData) {
				markersData[key].forEach(function (item) {
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
						map: mapObject,
						icon: item.fa_icon //,
					});
					loc = new google.maps.LatLng(item.location_latitude, item.location_longitude);
					bounds.extend(loc);
					
					if ('undefined' === typeof markers[key])
						markers[key] = [];
					markers[key].push(marker);
					google.maps.event.addListener(marker, 'mouseover', (function () {
					  closeInfoBox();
					  getInfoBox(item).open(mapObject, this);
					
					 }));
					
					
				});
			}
				mapObject.fitBounds(bounds);       
				mapObject.panToBounds(bounds);    
				
		};

		function hideAllMarkers () {
			for (var key in markers)
				markers[key].forEach(function (marker) {
					marker.setMap(null);
				});
		};

		function toggleMarkers (category) {
			hideAllMarkers();
			closeInfoBox();

			if ('undefined' === typeof markers[category])
				return false;
			markers[category].forEach(function (marker) {
				marker.setMap(mapObject);
				marker.setAnimation(google.maps.Animation.DROP);

			});
		};
		
		function closeInfoBox() {
			jQuery('div.infoBox').remove();
		};

		function getInfoBox(item) {
			return new InfoBox({
				content:
			'<div class="marker_visit" id="marker_info">' +
			'<div class="info" id="info">'+
			'<a href="'+ item.url_point + '" class="">'+ item.name_point +'</a>' +
			'<span></span>' +
			'</div>' +
			'</div>',
		disableAutoPan: true,
		maxWidth: 0,
		pixelOffset: new google.maps.Size(40, -50),
		closeBoxMargin: '50px 0px',
		closeBoxURL: '',
		isHidden: false,
		pane: 'floatPane',
		enableEventPropagation: true
			});


		};