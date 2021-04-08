<?php 
require 'includes/dbhandler.php';
require 'includes/header.php'; 
require 'includes/review-helper.php';
?>

<main>
    <span id="testAvg"></span>
    <div class="container" aligne="center" style="max-width: 800px;">

        <div class="my-auto">

            <form id="review-form" action="includes/review-helper.php" method="post">

                <div class="form-group" style="margin-top: 15px;">
                    <label class="title-label" for="review-title" style="font-size: 16px; font-weight: bold;">Title</label>
                    <input type="text" name="review-title" id="review-title" style="width: 100%; margin-bottom: 10px;">
                    <textarea name="review" id="review-text" cols="80" rows="3" placeholder="Enter a Comment..."></textarea>
                    <input type="hidden" name="item_id" value="<?php echo $_GET['id']; ?>"> 
                </div>

                <div class="form-group">
                    <button class="btn btn-outline-danger" type="submit" name="review-submit" id="review-submit" style="width: 100%;">Review</button>
                </div>

            </form>

        </div>

    </div>
    
    <h5 style="text-align:center">todo: change this from dark mode to not dark mode</h5>
    <link rel="stylesheet" href="/css/comments.css">
    <div style="width: 1000px; margin-left: calc(50vw - 500px); background-color: #121212; padding: 16px;">
        <div class="comment-tray">
        <?php
            require 'includes/comment-helper.php';
            foreach(comments_on($_GET['id']) as $comment) {
                echo_comment($comment);
            }
        ?>
        </div>
        <div class="comment-reply-panel">
            <textarea class="comment-reply-field" placeholder="Post a comment..."></textarea>
            <div class="comment-reply-panel-controls hide-until-enabled">
                <input type="checkbox" id="allow-replies" name="allow-replies" checked><label for="allow-replies">Allow replies</label>
                <button>POST</button>
            </div>
        </div>
        <script src="/js/comments.js"></script>
    </div>

</main>

<script type="text/javascript">
var rateIndex = -1;
var id = <?php echo $_GET['id'];?>;


$(document).ready(function() {
    //reset_star();

    // get reviews
    xhr_getter('display-reviews.php?id=', "review_list");
    


    //Used to interchangeably send GET requests for review display data. 
    function xhr_getter(prefix, element) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            // If the GET request was successful, fill in the span element with the review_list id with reviews
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(element).innerHTML = this.responseText;
            }
        };
        url = prefix + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }
});
</script>