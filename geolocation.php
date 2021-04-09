<?php
require 'includes/header.php';
require 'includes/dbhandler.php';

?>

<html>
  <head>
    <title>Place Searches</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script src="js/location.js"></script>
    <link rel="stylesheet" type="text/css" href="css/map.css" />
  </head>
  <body>
    <section class="searchApp" id="searchApp">
	<header class="searchBar" id="searchBar">
		<div class="search-bar-wrapper">
			<span class="lookup">
				<input type="text" id="searchBarLookup" class="searchBarLookup" placeholder="Search Apartments">
				<button type="submit" id="search-submit" class="search-submit" name="search-submit">Search</button>
			</span>
		</div>
	</header>

    </section>

    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhVwcZXgvHpBIHpQha3K2P3EPRZ7Bmyfo&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
  </body>
</html>
