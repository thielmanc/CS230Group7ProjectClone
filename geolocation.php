<?php
require 'includes/header.php';
require 'includes/dbhandler.php';
?>

<html>

<head>
    <title>Place ID Finder</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="css/map.css" />
    <script src="js/location.js"></script>
</head>

<body>
    <div style="display: none">
        <form method="POST" action="includes/geolocation-helper.php">
            <label for="place-name"></label>
            <input id="pac-input" class="controls" type="text" placeholder="Enter a location" />
        </form>
    </div>
    <div id="map"></div>
    <div id="infowindow-content">
        <span id="place-name" class="title"></span><br />
        <strong>Place ID:</strong> <span id="place-id"></span><br />
        <span id="place-address"></span>
    </div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhVwcZXgvHpBIHpQha3K2P3EPRZ7Bmyfo&callback=initMap&libraries=places&v=weekly"
        async></script>
</body>

</html>