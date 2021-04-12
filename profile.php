<?php
require 'includes/header.php';
require 'includes/dbhandler.php';

?>

<main>

    <link rel="stylesheet" href="css/profile.css">
    <div class="backdrop-filter"></div>
    <script>
    function triggered() {
        document.querySelector("#prof-image").click(); // Wait for click event. # means its looking for an id
    }

    function preview(e) {
        if (e.files[0]) { // Action that will happen when clicked
            var reader = new FileReader(); // Open new file reader object
            reader.onload = function(e) { // preview image
                document.querySelector('#prof-display').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }
    </script>

    <?php
if (isset($_SESSION['uname'])) {
    // username after login
    $prof_user = $_SESSION['uname'];
    $sqlpro = "SELECT * FROM users WHERE uname='$prof_user'";
    $res = mysqli_query($conn,$sqlpro);
    $row = mysqli_fetch_array($res);
    $photo = $row['pfpurl']; // path to the profile picture

    ?>
    <div class="bg-cover">
        <div class="h-50 center-me text-center">
            <div class="my-auto">
                <h1>Welcome <?php echo $prof_user?></h1>
                <form action="includes/upload-helper.php" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <img src="<?php echo $photo ?>" alt="profile pic" onclick="triggered();" id="prof-display">
                        <label for="prof-image" id="uname-style"><?php echo $prof_user?></label>
                        <input type="file" name="prof-image" id="prof-image" onchange="preview(this)"
                            class="form-control" style="display: none;">
                    </div>


                    <div class="form-group">
                        <textarea name="bio" id="bio" cols="30" rows="10" placeholder="bio..."
                            style="text-align: center;"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="prof-submit"
                            class="btn btn-outline-success btn-lg btn-block">upload</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <?php
    

}
?>

</main>