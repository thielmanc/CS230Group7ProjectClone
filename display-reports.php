<?php

require_once 'includes/display-report-helper.php';
require_once 'includes/dbhandler.php';


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
        $propic = "SELECT pfpurl FROM profiles WHERE uid=(SELECT uid FROM users WHERE uname='$uname');";//There is no profpic in profiles db. Along with no values for uname.
        $res = mysqli_query($conn, $propic);
        $picpath = mysqli_fetch_assoc($res);

        //top half - displays a comment along with the data and the profile picture
        //bottom half - approve (set status to 0 - normal) and remove buttons(delete the comment)
        echo '
            <div class="card mx-auto" style="width: 30%; padding: 5px; margin-bottom: 10px;">
                <div class="media">
                    <img class="mr-3" src="'.$picpath['pfpurl'].'" style="max-width: 75px; max-height: 75px; border-radius: 50%;">
                        <div class="media-body">
                            <h4 class="mt-0">'.$row['uname'].'</h4>
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