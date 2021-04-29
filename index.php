<?php
require 'includes/header.php';
require 'includes/dbhandler.php';
?>

<body>

    <main>
        <link rel="stylesheet" href="/css/index.css">
        <div class="backdrop-filter"></div>

        <div class="contentWrapper" id="homePageWrapper">

            <!-- Home Page Title Section -->
            <section class="homePage">
                <div class="mainSearchWrapper" id="mainSearchWrapper">
                    <h1 class="mainTitle" id="quickSearchMainTitle">Search for Apartment Reviews</h1>
                    <p id="quickSearchSubTitle">Or Review your Own Apartments!</p>

                    <!-- Search Bar Section -->
                    <section class="quickSearch" id="quickSearch">
                        <div class="quickSearchWrapper">
                            <div class="searchWrapper">
                                <form method="GET" action="includes/geolocation-helper.php">
                                    <input name="address"   type="text" id="quickSearchLookup" class="quickSearchLookup"  placeholder="Search for a Location" />
                                    <button type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                    </section>

                </div>
            </section>
        </div>
    </main>
</body>
