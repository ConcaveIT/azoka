// var myCenter=new google.maps.LatLng(23.7851578,90.4112255);
//     function initialize()
//     {
//         var mapProp = {
//             center:myCenter,
//             scrollwheel: false,
//             zoom:11,
//             mapTypeId:google.maps.MapTypeId.ROADMAP
//         };
//         var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
//         var marker=new google.maps.Marker({
//             position:myCenter,
//             map: map,
//         });
//
// 		var styles =  [
// 			{
// 				"stylers": [
// 					{
// 						"hue": "#C70909"
// 					},
// 					{
// 						"saturation": 10
// 					}
// 				]
// 			},
// 			{
// 				"featureType": "water",
// 				"stylers": [
// 					{
// 						"color": "#effefd"
// 					}
// 				]
// 			},
// 			{
// 				"featureType": "all",
// 				"elementType": "labels",
// 				"stylers": [
// 					{
// 						"visibility": "off"
// 					}
// 				]
// 			},
// 			{
// 				"featureType": "administrative",
// 				"elementType": "labels",
// 				"stylers": [
// 					{
// 						"visibility": "on"
// 					}
// 				]
// 			},
// 			{
// 				"featureType": "road",
// 				"elementType": "all",
// 				"stylers": [
// 					{
// 						"visibility": "off"
// 					}
// 				]
// 			},
// 			{
// 				"featureType": "transit",
// 				"elementType": "all",
// 				"stylers": [
// 					{
// 						"visibility": "off"
// 					}
// 				]
// 			}
// 		];
//
//
//
//
//
//
//         map.setOptions({styles: styles});
//         marker.setMap(map);
//     }
// google.maps.event.addDomListener(window, 'load', initialize);

// Initialize and add the map
// function initMap() {
// 	// The location of Uluru
// 	const uluru = { lat: -25.344, lng: 131.036 };
// 	// The map, centered at Uluru
// 	const map = new google.maps.Map(document.getElementById("map"), {
// 		zoom: 4,
// 		center: uluru,
// 	});
// 	// The marker, positioned at Uluru
// 	const marker = new google.maps.Marker({
// 		position: uluru,
// 		map: map,
// 	});
// }

// Initialize and add the map
function initMap() {
	// The location of Uluru
	const uluru = { lat: -25.344, lng: 131.036 };
	// The map, centered at Uluru
	const map = new google.maps.Map(document.getElementById("map"), {
		zoom: 4,
		center: uluru,
	});
	// The marker, positioned at Uluru
	const marker = new google.maps.Marker({
		position: uluru,
		map: map,
	});
}
