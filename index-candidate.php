<?php
require 'includes/header.php';
require 'includes/dbhandler.php';
?>



<body>

    <main>
        <link rel="stylesheet" href="/css/index-candidate.css">
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
                                <input type="text" id="quickSearchLookup" class="quickSearchLookup"
                                    placeholder="Search for a Location" />
                                <a href="geolocation.php" class="search" title="Search for Reviews">
                                    <span>Search</span>
                                </a>
                            </div>
                            <p class="errorMessage">You must choose a place to review</p>
                        </div>
                    </section>

                </div>
            </section>

        </div>


    </main>
</body>