<?php 
require_once 'require-session-start.php';
require_once 'censorfunction.php';
date_default_timezone_set('UTC');
header('Content-Type: application/json');

if(!check_csrf_token()) {
    echo json_encode([
        'success' => false,
        'error' => 'request not same site'
    ]);
    exit();
}

if (!isset($_POST[$param = 'review-submit']) || !isset($_POST[$param = 'review']) || !isset($_POST[$param = 'item_id'])) {
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
// UNFINISHED: remove title field
$sql = "INSERT INTO reviews (itemid, uname, title, reviewtext, revdate, parentid, upvotes, downvotes, upvoters, downvoters, status) VALUES (?, ?, '', ?, ?, ?, 0, 0, '[]', '[]', 0)";
safe_query($sql, 'isssi', $item_id, $uname, $censoredReview, $date, $parentid);
$cid = unsafe_query('SELECT LAST_INSERT_ID() AS cid')['cid']; // automatically generated cid of previously inserted comment

// insert any tags into mentions table
// UNFINISHED: check for nonexistant users
preg_match_all('/@\{ ([\S]+) \}/', $censoredReview, $matches);
foreach($matches[1] as $taggedUser) {
    safe_query("INSERT INTO mentions (uid, cid) VALUES ((SELECT uid FROM users WHERE uname = ?), ?)", 'si', $taggedUser, $cid);
}

require_once 'fetch-comment-helper.php';
require_once '../view-components/comment.php';
ob_start(); // buffer output from comment.php
echo_comment(iterator_to_array(comment_with_id($cid))[0]); // UNFINISHED: remove dirty quick-fix for ->next() not working 
$commentHTML = ob_get_clean();

echo json_encode([
    'success' => true,
    'parent' => $parentid,
    'html' => $commentHTML
]);