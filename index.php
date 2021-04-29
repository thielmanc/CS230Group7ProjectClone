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
                                <form method="POST" action="/includes/index-helper.php">
                                    <input type="text" id="quickSearchLookup" class="quickSearchLookup" name="address" placeholder="Search for a Location" />
                                    <a href="geolocation.php" class="search" title="Search for Reviews">
                                        <span>Search</span>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </section>



                </div>
            </section>
        </div>
    </main>
</body>
