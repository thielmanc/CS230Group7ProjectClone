<?php 
require_once 'require-session-start.php';
require_once 'censorfunction.php';
date_default_timezone_set('UTC');
header('Content-Type: application/json');

//fail is csrf token is invalid
if(!check_csrf_token()) {
    echo json_encode([
        'success' => false,
        'error' => 'request not same site'
    ]);
    exit();
}
//fail if important parameters are not set when submiting 
if (!isset($_POST[$param = 'review-submit']) || !isset($_POST[$param = 'review']) || strlen($_POST[$param = 'review']) == 0 || !isset($_POST[$param = 'item_id'])) {
    echo json_encode([
        'success' => false,
        'error' => "required parameter $param not set"
    ]);
    exit();
}

require_once 'dbhandler.php';

$uname = $_SESSION['uname'];
$date = date('Y-m-d H:i:s');
$censoredReview = censor($_POST['review']);
$item_id = $_POST['item_id'];
$parentid = $_POST['parentid'];

// insert comment into comments table
$sql = "INSERT INTO reviews (itemid, uname, title, reviewtext, revdate, parentid, upvotes, downvotes, upvoters, downvoters, status) VALUES (?, ?, '', ?, ?, ?, 0, 0, '[]', '[]', 0)";
safe_query($sql, 'isssi', $item_id, $uname, $censoredReview, $date, $parentid);
$cid = unsafe_query('SELECT LAST_INSERT_ID() AS cid')['cid']; // automatically generated cid of previously inserted comment

// insert any tags into mentions table
preg_match_all('/@\{ ([\S]+) \}/', $censoredReview, $matches);
foreach($matches[1] as $taggedUser) {
    safe_query("INSERT INTO mentions (uid, cid) VALUES ((SELECT uid FROM users WHERE uname = ?), ?)", 'si', $taggedUser, $cid);
}

require_once 'fetch-comment-helper.php';
require_once '../view-components/comment.php';
ob_start(); // buffer output from comment.php
echo_comment(comment_with_id($cid));
$commentHTML = ob_get_clean();

echo json_encode([
    'success' => true,
    'parent' => $parentid,
    'html' => $commentHTML
]);