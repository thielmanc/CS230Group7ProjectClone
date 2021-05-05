<?php
require_once 'includes/display-report-helper.php';
require_once 'includes/dbhandler.php';
require_once 'includes/require-admin-privileges.php';

$conn = mysqli_connect($servename, $DBuname, $DBPass, $DBname);

if (!$conn) {
    die("Connection failed...".mysqli_connect_error());
    
}

$item = $_GET['id'];
//Gets all reviews that have been reported (status is not 0 if reported)
$sql = "SELECT * FROM reviews WHERE status >= 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) { //while there is a comment to show
        $uname = $row['uname'];
        require_once 'includes/fetch-user-info.php';
        $picpath = fetch_user_by_username($uname)['profile_picture'];

        //top half - displays a comment along with the data and the profile picture
        //bottom half - approve (set status to 0 - normal) and remove buttons(delete the comment)
        echo '
            <div class="card mx-auto" style="width: 30%; padding: 5px; margin-bottom: 10px;">
                <div class="media">
                    <img class="mr-3" src="'.htmlspecialchars($picpath).'" style="max-width: 75px; max-height: 75px; border-radius: 50%;">
                        <div class="media-body">
                            <h4 class="mt-0">'.htmlspecialchars($row['uname']).'</h4>
                            <p>'.htmlspecialchars($row['title']).'</p>
                            <p>'.htmlspecialchars($row['revdate']).'</p>
                            <p>'.htmlspecialchars($row['reviewtext']).'</p>
                        </div>
                </div>
                <form action="includes/display-report-helper.php" method="POST">
                    <input type="hidden" name="id" value='.$row['revid'].'>
                    
                    <div class="mx-auto">
                        <div class="form-group">
                            <button class="btn btn-outline-success mx-auto" type="submit" name="approve-submit" id="approve-submit" style="width: 100%;" >Approve Comment</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-outline-danger mx-auto" type="submit" name="remove-submit" id="remove-submit" style="width: 100%;" >Remove Comment</button>
                        </div>
                    </div>
                </form>
            </div>
             ';
    }
}
else {
    echo '<h5 style="text-aligh: center;">No reported comments</h5>';
}