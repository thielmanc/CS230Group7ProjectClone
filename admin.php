<?php
require 'includes/header.php';
require 'includes/dbhandler.php';
?>

<main>

    <link rel="stylesheet" href="css/profile.css">

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

    <?php
if (isset($_SESSION['uname'])) {
    $prof_user = $_SESSION['uname'];
    $sqlpro = "SELECT * FROM users WHERE uid='$prof_user';";
    $res = mysqli_query($cnn,$sqlpro);
    $row = mysqli_fetch_array($res);
    $photo = $row['pfpurl']; // path to the profile picture
?>

    <html>
    <title>Admin Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <img src="<?php echo $photo ?>" class="w3-circle w3-margin-right" style="width:46px">
                </div>
                <div class="w3-col s8 w3-bar">
                    <span>Welcome, <strong><?php echo $prof_user?></strong></span><br>
                </div>
            </div>
            <hr>
            <div class="w3-bar-block">
                <a href="#overview" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i> 
                    Overview</a>
                <a href="#reports" class="w3-bar-item w3-button w3-padding"><i
                        class="fas fa-exclamation-circle fa-fw"></i>  Reports</a>
                <a href="#uploader" class="w3-bar-item w3-button w3-padding"><i class="fas fa-upload fa-fw"></i> 
                    Gallery Uploader</a>
                <a href="#preview" class="w3-bar-item w3-button w3-padding"><i class="fas fa-laptop-house fa-fw"></i> 
                    Gallery Preview</a>
                <a href="#wip" class="w3-bar-item w3-button w3-padding"><i class="	fas fa-question-circle fa-fw"></i> 
                    Anything else...</a>
            </div>
        </nav>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px;margin-top:43px;">

            <a name="overview">
                <div class="w3-row-padding w3-margin-bottom">
            </a>

            <?php 
            $result=mysqli_query($conn,"SELECT count(*) as total from users");
            $data=mysqli_fetch_assoc($result);
            ?>
            <div class="w3-third">
                <div class="w3-container w3-blue w3-padding-16">
                    <div class="w3-left"><i class="fas fa-address-book w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3><?php echo $data['total'] ?></h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Users</h4>
                </div>
            </div>

            <?php 
            $result=mysqli_query($conn,"SELECT count(*) as total from reviews");
            $data=mysqli_fetch_assoc($result);
            ?>
            <div class="w3-third">
                <div class="w3-container w3-orange w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fas fa-newspaper w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3><?php echo $data['total'] ?></h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Comments</h4>
                </div>
            </div>

            <?php 
            $result=mysqli_query($conn,"SELECT count(*) as total from reviews where status='1'");
            $data=mysqli_fetch_assoc($result);
            ?>
            <div class="w3-third">
                <div class="w3-container w3-red w3-padding-16">
                    <div class="w3-left"><i class="fas fa-exclamation-circle w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3><?php echo $data['total'] ?></h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Reports</h4>
                </div>
            </div>
        </div>

        <hr>

        <a name="reports">
            <div class="w3-container">
        </a>
        <h3 class="w3-light-green w3-padding">Reports</h3>

        <div>
            <?php require 'display-reports.php' ?>
        </div>
        </div>

        <hr>

        <a name="uploader">
            <div class="w3-container">
        </a>
        <h3 class="w3-light-green w3-padding">Gallery Uploader</h3>

        <div class="h-50 center-me text-center">
            <div class="my-auto">

                <form action="includes/gallery-helper.php" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <img src="images/doge.jpg" alt="Image Upload" onclick="triggered();" id="gallery-display">
                        <input type="text" name="title" class="form-control" placeholder="title">
                        <input type="file" name="gallery-image" id="gallery-image" onchange="preview(this)"
                            class="form-control" style="display: none;">
                    </div>

                    <div class="form-group">
                        <textarea name="descript" id="bio" cols="30" rows="10" placeholder="Description"
                            style="text-align: center;"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="gallery-submit"
                            class="btn btn-outline-success btn-lg btn-block">upload</button>
                    </div>

                </form>

            </div>
        </div>
        </div>

        <hr>

        <a name="preview">
            <div class="w3-container">
        </a>
        <h3 class="w3-light-green w3-padding">Gallery Preview</h3>

        <div style="height: 300px">
            Work in progress...
        </div>
        </div>

        <hr>

        <a name="wip">
            <div class="w3-container">
        </a>
        <h3 class="w3-light-green w3-padding">Any Other Admin Controls</h3>

        <div style="height: 300px">
            Work in progress...
        </div>
        </div>
        </div>



    </body>

    </html>

    <?php
}
?>
</main>