<!-- This code handles the admin page of the site. It displays useful information for an admin to monitor and manage the website. 
Main functions being, comment monitoring-->
<?php
    require_once 'includes/require-admin-privileges.php';
    require 'includes/header.php';
    require_once 'includes/dbhandler.php';
?>

<main>
    <script>
        function triggered() {
            document.querySelector("#gallery-image").click(); // Wait for click event. # means its looking for an id
        }

        function preview(e) {
            if (e.files[0]) { // Action that will happen when clicked
                var reader = new FileReader(); // Open new file reader object
                reader.onload = function(e) { // preview image
                    document.querySelector('#gallery-display').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }
    </script>



    <?php //session check for the user that is currently logged in
        if (isset($_SESSION['uname'])) {
            $photo = $_SESSION['user']['profile_picture']; // path to the profile picture
    ?>

    <!DOCTYPE html>
    <html lang="en">
        <title>Admin Page</title>
        <!-- Links to free open source designs-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <!-- sets the font for all wording on page-->
        <style>
            html,
            body,
            h1,
            h2,
            h3,
            h4,
            h5 {
                font-family: "Raleway", sans-serif
            }
        </style>

        <body class="w3-light-grey">

            <!-- Sidebar/menu -->
            <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
                <div class="w3-container w3-row">
                    <div class="w3-col s4">
                        <!-- grabs users photo to display-->
                        <img src="<?php echo htmlspecialchars($photo) ?>" class="w3-circle w3-margin-right" alt="photo" style="width:46px">
                    </div>
                    <div class="w3-col s8 w3-bar">
                        <!-- grabs users name to display-->
                        <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user']['username'])?></strong></span><br>
                    </div>
                </div>
                <hr>
                <!-- display and internal linking for side bar nav for admin-->
                <div class="w3-bar-block">
                    <a href="#overview" class="w3-bar-item w3-button w3-padding"><em class="fa fa-users fa-fw"></em> 
                        Overview</a>
                    <a href="#reports" class="w3-bar-item w3-button w3-padding"><em class="fas fa-exclamation-circle fa-fw"></em> 
                        Reports</a>
                    <a href="#requests" class="w3-bar-item w3-button w3-padding"><em class="fas fa-question-circle fa-fw"></em> 
                        Requests</a>
                    <a href="#uploader" class="w3-bar-item w3-button w3-padding"><em class="fas fa-upload fa-fw"></em> 
                        Gallery Uploader</a>
                    <a href="#preview" class="w3-bar-item w3-button w3-padding"><em class="fas fa-laptop-house fa-fw"></em> 
                        Gallery Preview</a>
                </div>
            </nav>

            <!-- !PAGE CONTENT! -->
            <div class="w3-main" style="margin-left:300px;margin-top:43px;">

                <a id="overview"> <!-- Internal link destination def-->
                    <div class="w3-row-padding w3-margin-bottom">
                </a>

                <?php //script that counts how many users are in the db 
                $result=mysqli_query($conn,"SELECT count(*) as total from users");
                $data=mysqli_fetch_assoc($result);
                ?>
                <div class="w3-third"><!-- Top Overview element that displays Users-->
                    <div class="w3-container w3-blue w3-padding-16">
                        <div class="w3-left"><em class="fas fa-address-book w3-xxxlarge"></em></div>
                        <div class="w3-right">
                            <!-- display data pulled form previous php script-->
                            <h3><?php echo $data['total'] ?></h3>
                        </div>
                        <div class="w3-clear"></div>
                        <h4>Users</h4>
                    </div>
                </div>

                <?php //script that counts how many reviews are in the db 
                $result=mysqli_query($conn,"SELECT count(*) as total from reviews");
                $data=mysqli_fetch_assoc($result);
                ?>
                <div class="w3-third"><!-- Top Overview element that displays Review-->
                    <div class="w3-container w3-orange w3-text-white w3-padding-16">
                        <div class="w3-left"><em class="fas fa-newspaper w3-xxxlarge"></em></div>
                        <div class="w3-right">
                            <!-- display data pulled form previous php script-->
                            <h3><?php echo $data['total'] ?></h3>
                        </div>
                        <div class="w3-clear"></div>
                        <h4>Comments</h4>
                    </div>
                </div>

                <?php //script that counts how many reported reviews are in the db 
                $result=mysqli_query($conn,"SELECT count(*) as total from reviews where status >= 1");
                $data=mysqli_fetch_assoc($result);
                ?>
                <div class="w3-third"><!-- Top Overview element that displays Report-->
                    <div class="w3-container w3-red w3-padding-16">
                        <div class="w3-left"><em class="fas fa-exclamation-circle w3-xxxlarge"></em></div>
                        <div class="w3-right">
                            <!-- display data pulled form previous php script-->
                            <h3><?php echo $data['total'] ?></h3>
                        </div>
                        <div class="w3-clear"></div>
                        <h4>Reports</h4>
                    </div>
                </div>
            </div>


            <a id="reports"><!-- Internal link destination def-->
                <div class="w3-container">
            </a>
            <h3 class="w3-light-green w3-padding">Reports</h3>
                    
                    <!-- Call on other file to display reviews that were flagged for review-->
                     <div class="gallery-container">
                        <?php require 'display-reports.php' ?>
                    </div>
                    
                </div>


            <div class="w3-container">
                <a id="requests"></a><!-- Internal link destination def-->
                <h3 class="w3-light-green w3-padding">Requests</h3>
                <div class="gallery-container">
                    <?php
                    $stmt = mysqli_query($conn, 'SELECT * FROM requests');
                    $count = 0;
                    while($row = $stmt->fetch_assoc()): ?>
                    <div class="card mx-auto" data-rid="<?= $row['rid'] ?>" data-address="<?= htmlspecialchars($row['address']) ?>" data-descript="<?= htmlspecialchars($row['descript']) ?>" style="width: 30%; padding: 5px; margin-bottom: 10px;">
                        <div class="media">
                            <div class="media-body">
                                <h4 class="mt-0"><?= htmlspecialchars($row['address']) ?></h4>
                                <p><?= htmlspecialchars($row['descript']) ?></p>
                            </div>
                        </div>
                        <button class="btn btn-outline-success mx-auto" style="width: 100%;" onclick="fillGalleryUploader(<?= $row['rid'] ?>)">Send to Gallery Uploader</button>
                        <button class="btn btn-outline-danger mx-auto" style="width: 100%;" onclick="discardRequest(<?= $row['rid'] ?>)">Discard</button>
                    </div>
                    <?php
                    $count++;
                    endwhile;
                    
                    if($count == 0): ?>
                        <h5 style="text-aligh: center;">No requests for places</h5>
                    <?php endif ?>

                </div>
                <script src="/js/admin.js"></script>
            </div>

            <a id="uploader"><!-- Internal link destination def-->
                <div class="w3-container">
            </a>
            <h3 class="w3-light-green w3-padding">Gallery Uploader</h3>

            <div class="w3-display-container" style="width: 100%; height: 750px">
                       <div class="w3-display-middle">
                            <!-- Form for gallery upload on admin page-->
                            <form action="includes/gallery-helper.php" method="POST" enctype="multipart/form-data">

                                <!--Image to be used-->
                                <div class="form-group">
                                    <img class="galUpImg" src="images/doge.jpg" alt="Image Upload" onclick="triggered();" id="gallery-display">
                                    
                                    <input type="file" name="gallery-image" id="gallery-image" onchange="preview(this)"
                                        class="form-control" style="display: none;">
                                </div>

                                <!-- Title of Image-->
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control" placeholder="title">
                                </div>
                                <div class="form-group">
                                    <input id="gallery-upload-address-input" type="text" name="address" class="form-control" placeholder="address">
                                 </div>
                                <!-- Descrip of Image-->
                                <div class="form-group">
                                    <textarea id="gallery-upload-descript-input" name="descript" id="bio" cols="30" rows="10" placeholder="Description"
                                    class="form-control" style="text-align: center;"></textarea>
                                </div>

                                <!--Submit button-->
                                <div class="form-group">
                                    <button type="submit" name="gallery-submit"
                                         class="form-control">upload</button>
                                </div>

                            </form>
                        </div>
        </div>
                </div>


            <a id="preview"><!-- Internal link destination def-->
                <div class="w3-container">
            </a>
             <h3 class="w3-light-green w3-padding">Gallery Preview</h3>

            
             <link rel="stylesheet" href="css/admin.css">
                    <div class="backdrop-filter"></div>
                            <div class="gallery-container">
                                <?php 
                                    include_once 'includes/dbhandler.php';
                                    $sql = "SELECT * FROM gallery ORDER BY upload_date DESC";
                                    $query = mysqli_query($conn, $sql);  // Execute sql statement 

                                    while ($row = mysqli_fetch_assoc($query)) { // While there is still a row in our gallery, keep displaying
                                        echo '<div class="card">
                                                <a href="review.php?id='.$row['pid'].'">
                                                    <img class="galpre" src="'.$row["picpath"].'">
                                                    <h3>'.htmlspecialchars($row["title"]).'</h3>
                                                    <p>'.htmlspecialchars($row["descript"]).'</p>
                                                </a>
                                            </div>';
                                    }
                                ?>
                    </div>
                </div>
        </body>
    </html>
<!--Needed for final php script to be closed for everything to display-->
<?php
}
?>
</main>