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
    <main>
        <div class="backdrop-filter"></div>

        <!-- Search Bar. More preferences maybe? -->
        <section class="searchApp" id="searchApp">
            <header class="searchBar" id="searchBar">
                <div class="search-bar-wrapper">
                    <span class="lookup">
                        <input id="pac-input" class="controls" type="text" placeholder="Location" />
                    </span>
                </div>
            </header>
        </section>

        <!-- Place Cards. Displays options -->
        <section class="placardContainer" class="placardContainer">
            
        </section>
    </main>
    
    <div id="map"></div>

    <!-- https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=Museum%20of%20Contemporary%20Art%20Australia&inputtype=textquery&fields=photos,formatted_address,name,rating,opening_hours,geometry&key=YOUR_API_KEY -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhVwcZXgvHpBIHpQha3K2P3EPRZ7Bmyfo&callback=initAutocomplete&libraries=places&v=weekly"
        async>
    </script>

</body>

</html>