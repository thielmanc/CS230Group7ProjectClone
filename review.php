<?php require 'includes/header.php' ?>
<main>
    <link rel="stylesheet" href="/css/comments.css">
    <div class="backdrop-filter"></div>

    <?php 
            include_once 'includes/dbhandler.php';
            //get place info from database and display title card
            $stmt = safe_stmt_exec('SELECT * FROM gallery WHERE pid = ?', 'i', $_GET['id']);
            $result = $stmt->get_result();            
            $row = mysqli_fetch_assoc($result);
            
            echo'
                <div class="header-card">
                    <div class="media-body">
                        <div class="inner-div">
                            <img class="mr-3" alt="Picture" src="'.htmlspecialchars($row['picpath']).'">
                            <h3 class="mt-0">'.htmlspecialchars($row['title']).'</h3>
                            <p style="font-size:larger; text-align: center; color:rgb(70, 120, 80);";>Address: '.htmlspecialchars($row['address']).'</p>  
                            <p>'.htmlspecialchars($row['descript']).'</p>  
                        </div>
                    </div>
                </div>
            ';

        ?>
    <!--styling for comment pannel, sets up buttons and fields-->
    <div class="comment-section">
        <div class="comment-reply-panel" id="main-comment-panel" action="includes/review-helper.php" method="POST">
            <div class="comment-reply-field" id="main-comment-field" contenteditable></div>
            <div class="comment-reply-panel-controls hide-until-enabled" id="main-comment-panel-controls">
                <input type="checkbox" id="allow-replies" class="allow-replies-input" checked><label for="allow-replies">Allow replies</label>
                <button onclick="commentCallback(null)">POST</button>
            </div>
        </div>
        <div class="comment-tray">
        <!--lists all comments-->
        <?php
            require_once 'includes/fetch-comment-helper.php';
            require_once 'view-components/comment.php';
            foreach(comments_on($_GET['id']) as $comment) {
                echo_comment($comment);
            }
        ?>
        </div>
        <script src="/js/comments.js"></script>
    </div>
    <!-- script and stylesheetfor options-tray already loaded in header for notification tray, do not need to load again --> 
    <div class="options-tray user-mention-autocomplete-tray hide-until-enabled"></div>
</main>