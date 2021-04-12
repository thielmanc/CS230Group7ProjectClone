
function initMap() {
	// map stuff
	const map = new google.maps.Map(document.getElementById("map"), {
	  center: { lat: 39.6295, lng: -79.9558 },
	  zoom: 13,
	});
	const input = document.getElementById("pac-input");
	const autocomplete = new google.maps.places.Autocomplete(input);
	autocomplete.bindTo("bounds", map);

	// Specify just the place data fields that you need.
	autocomplete.setFields(["place_id", "geometry", "name"]);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	// input
	const infowindow = new google.maps.InfoWindow();
	const infowindowContent = document.getElementById("infowindow-content");
	infowindow.setContent(infowindowContent);
	const marker = new google.maps.Marker({ map: map });

	marker.addListener("click", () => {
	  infowindow.open(map, marker);
	});
	autocomplete.addListener("place_changed", () => {
	  infowindow.close();
	  const place = autocomplete.getPlace();
  
	  if (!place.geometry || !place.geometry.location) {
		return;
	  }
  
	  if (place.geometry.viewport) {
		map.fitBounds(place.geometry.viewport);
	  } else {
		map.setCenter(place.geometry.location);
		map.setZoom(17);
	  }
	  // Set the position of the marker using the place ID and location.
	  marker.setPlace({
		placeId: place.place_id,
		location: place.geometry.location,
	  });
	  // Display 
	  marker.setVisible(true);
	  infowindowContent.children.namedItem("place-name").textContent = place.name;
	  infowindowContent.children.namedItem("place-id").textContent =
		place.place_id;
	  infowindowContent.children.namedItem("place-address").textContent =
		place.formatted_address;
	  infowindow.open(map, marker);
	});
  }