<?php
require 'includes/header.php';
?>

<body>

    <main>
        <link rel="stylesheet" href="/css/index.css">
        <div class="background"></div>

        <div class="contentWrapper" id="homePageWrapper">

            <!-- Home Page Title Section -->
            <section class="homePage">
                <div class="mainSearchWrapper" id="mainSearchWrapper">
                    <h1 class="mainTitle" id="quickSearchMainTitle">Housing Helper</h1>
                    <p id="quickSearchSubTitle">Search for Housing Reviews</p>

                    <!-- Search Bar Section -->
                    <section class="quickSearch" id="quickSearch">
                        <div class="quickSearchWrapper">
                            <div class="searchWrapper">
                                <form method="POST" action="/index.php">
                                    <input name="address" type="text" id="quickSearchLookup" class="quickSearchLookup"
                                        placeholder="Search for a Location (by address)" />
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
                        include_once 'includes/dbhandler.php';
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
                                            <p>Sorry. That does not seem to be in our database. Would you like to <a href="/request.php">request</a> a board be made?</p>
                                        </div>
                                     ';                               
                                
                            } else {
                                $sql = "SELECT * FROM gallery";
                                $query = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($query);
                                echo '
                                    <a href="review.php?id='.$row['pid'].'">
                                        <li style="list-style-type: none;">
                                            <div class="card-wrapper">
                                                
                                                    <div class="pic-card">
                                                        <img src="'.$row['picpath'].'" style="border-radius: 25px 0px 0px 25px">
                                                    </div>
                                                    <div class="info-card">
                                                        <strong>'.$row['address'].'</strong>
                                                        Description: '.$row['descript'].'
                                                    </div>
                                            </div>
                                        </li>
                                    </a>
                                     ';
                            }
                        }
                        
                    ?>
                </ul>
            </section>

        </div>
    </main>
</body>