<?php
require 'includes/header.php';
require 'includes/dbhandler.php';
?>

<body>

    <main>
        <link rel="stylesheet" href="/css/index.css">
        <div class="background"></div>

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
                                <form method="POST" action="/index.php">
                                    <input name="address" type="text" id="quickSearchLookup" class="quickSearchLookup"
                                        placeholder="Search for a Location" />
                                    <button type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </section>

            <section class="cards">
                <ul>
                    <?php
                        if (isset($_POST['address'])) {

                            $address = $_POST['address'];
                            if (empty($address)) {
                                header("Location: /index.php?error=EmptySearch");
                                exit();
                            }

                            $data = safe_query("SELECT address FROM gallery WHERE address=?","s",$address);
                           
                            if (empty($data)) {
                                echo '
                                        <div class="error-message">
                                            <p>Sorry. That does not seem to be in our database. Would you like to <a>request</a> a board be made?</p>
                                        </div>
                                     ';                                
                                
                            } else {
                                echo '
                                    <li style="list-style-type: none;">
                                        <div class="card-wrapper">
                                            <div class="pic-card">
                                                Pic Card Section
                                            </div>
                                            <div class="info-card">
                                                <p>'.$address.'</p>
                                            </div>
                                        </div>
                                    </li>
                                     ';
                            }
                        }
                        
                    ?>
                </ul>
            </section>

        </div>
    </main>
</body>