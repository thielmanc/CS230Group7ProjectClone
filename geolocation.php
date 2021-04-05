<?php
require 'includes/header.php';
require 'includes/dbhandler.php';

?>

<html>

    <head>
        <title>Geolocation</title>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <link rel="stylesheet" type="text/css" href="css/map.css" />
        <script src="js/location.js"></script> 
    </head>
    
    <body>

        <!-- information gathering -->
        <div class="info">
            <label for="username" style="text-align: center">What are you looking for?</label>
            <div id="input">
                <input id="pac-input" class="controls" type="text" placeholder="Search Box"/>
            </div>
        </div>

        <!-- Map container -->
        <div id="map"></div>

        <!-- Places will change depending on the key-value pairs in the url -->
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhVwcZXgvHpBIHpQha3K2P3EPRZ7Bmyfo&callback=initAutocomplete&libraries=places&v=weekly"
            async
        ></script>
    </body>

</html>