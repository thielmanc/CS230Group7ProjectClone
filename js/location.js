
let map;
let service;
let infowindow;
function initAutocomplete() {
	// const coord = new google.maps.LatLng(39.6295, -79.9559);
	const map = new google.maps.Map(document.getElementById("map"), {
		center: { lat: 39.6295, lng: -79.9559 },
		zoom: 13,
		mapTypeId: "roadmap",
	});
	
	const input = document.getElementById("search-submit");
	const searchBox = new google.maps.places.SearchBox("searchBarLookup");
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	
	map.addListener("bounds_change", () => {
		searchBox.setBounds(map.getBounds())
	});
	let markers = [];

	searchBox.addListener("places_changed", () => {
		const places = searchBox.getPlaces();

		if (plaes.length == 0) {
			return;
		}

		markers.forEach((marker) => {
			marker.setMap(null);
		});
		markers = [];

		const bounds = new google.maps.LatLngBounds();
		place.forEach((place) => {
			if (!place.geometry || !place.geometry.location) {
				console.log("Returned place contains no geometry");
				return;
			}
			const icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25),
			};
			
			if (place.geometry.viewport) {
				bounds.union(place.geometry.viewport);
			} else {
				bounds.extend(place.geometry.location);
			}
		});
		map.fitBounds(bounds);
	});
}

function createMarker(place) {
	if (!place.geometry || !place.geometry.location) return;
	const marker = new google.maps.Marker({
		map,
		position: place.geometry.location,
	});
	google.maps.event.addListener(marker, "click", () => {
		infowindow.setContent(place.name || "");
		infowindow.open(map);
	});
}

