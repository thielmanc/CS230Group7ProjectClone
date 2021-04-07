<?php
require 'includes/dbhandler.php';

$item = $_GET['id'];
$sql = "SELECT * FROM reviews WHERE itemid='$item'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) { 
        $uname = $row['uname'];
        $propic = "SELECT pfpurl FROM profiles WHERE uid=(SELECT uid FROM users WHERE uname='$uname');";//There is no profpic in profiles db. Along with no values for uname.
        $res = mysqli_query($conn, $propic);
        $picpath = mysqli_fetch_assoc($res);

        echo '
            <div class="card mx-auto" style="width: 30%; padding: 5px; margin-bottom: 10px;">
                <div class="media">
                    <img class="mr-3" src="'.$picpath['pfpurl'].'" style="max-width: 75px; max-height: 75px; border-radius: 50%;">
                        <div class="media-body">
                            <h4 class="mt-0">'.$row['uname'].'</h4>
                            <p>'.$row['revdate'].'</p>
                            <p>'.$row['reviewtext'].'</p>
                        </div>
                </div>
            </div>
             ';
    }
}
else {
    echo '<h5 style="text-aligh: center;">No reviews... yet! Be the First!</h5>';
}