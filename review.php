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
    <span id="review_list"></span>
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