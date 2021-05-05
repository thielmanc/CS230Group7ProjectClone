<?php
    require 'includes/header.php';
?>

<main>
    <link rel="stylesheet" href="css/gallery.css">
    <div class="backdrop-filter"></div>

    <h1>Places</h1>

    <div class="gallery-container">
        <?php 
            //get every gallery item from the database in descending upload date order
            include_once 'includes/dbhandler.php';
            $sql = "SELECT * FROM gallery ORDER BY upload_date DESC";
            $query = mysqli_query($conn, $sql);  
            
            //display each item in the gallery database
            while ($row = mysqli_fetch_assoc($query)) { 
                echo '<div class="card">
                        <a href="review.php?id='.$row['pid'].'">
                            <img src="'.$row["picpath"].'">
                            <h3>'.$row["title"].'</h3>
                            <p style="font-size:larger; color:rgb(70, 120, 80);";>'.$row["address"].'</p>
                            <p>'.$row["descript"].'</p>
                        </a>
                      </div>';
            }
        ?>
    </div>
</main>