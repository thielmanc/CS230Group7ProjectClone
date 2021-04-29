<?php
    require 'includes/dbhandler.php';
    require 'includes/header.php';
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
        <form method="GET" action="includes/geolocation-helper.php">
            <input id="pac-input" name="address" class="controls" type="text" placeholder="Enter a location" />
            <button type="submit">Search</button>
        </form>
    </div>

    <section class="placards" id="placards">
        <div id="placardContainer" class="placardContainer">
            <ul>
                <?php
                    if (!isset($address)) {
                        $address = $_GET['address'];
                        if (empty($address)) {
                            $sql = "SELECT address FROM gallery";
                            $query = mysqli_query($conn,$sql);

                            while ($row = mysqli_fetch_assoc($query)) {
                                echo '
                                    <li style="list-style-type: none">
                                        <div class="card">
                                            '.$row['address'].'
                                            <div class="avg-review">
                                                Average Review
                                                <div class="comments">
                                                    Number of Comments
                                                </div>
                                            </div>
                                         </div>
                                    </li>
                                     ';
                            }
                        }
                    } else {
                        $sql = "SELECT address FROM gallery WHERE address=".$address;
                        $query = mysqli_query($conn, $sql);

                        if (empty($query)) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo '
                                    <li style="list-style-type: none">
                                        <div class="card">
                                            '.$row['address'].'
                                            <div class="avg-review">
                                                Average Review
                                                <div class="comments">
                                                    Number of Comments
                                                </div>
                                            </div>
                                         </div>
                                    </li>
                                     ';
                            }
                        } else {
                            echo '
                                    <li style="list-style-type: none">
                                        <div class="card">
                                            '.$address.'
                                            <div class="avg-review">
                                                Average Review
                                                <div class="comments">
                                                    Number of Comments
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                 ';

                        }
                    }
                ?>


            </ul>
        </div>
    </section>

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