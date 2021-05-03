<?php
// handles upvoting/downvoting
// probably vulnerable to race conditions but oh well

require_once '../../includes/require-session-start.php';
header('Content-Type: application/json');

function error($reason) {
    echo json_encode([
        'success' => false,
        'error' => $reason
    ]);
    exit();
}

if(!check_csrf_token()) {
    error('request not same site');
    exit();
}

$vote = $_POST['vote'];
$cid = $_POST['cid'];

if(!isset($cid)) {
    error('comment id not set');
}
require_once '../../includes/dbhandler.php';

$data = safe_query('SELECT upvoters, downvoters, upvotes, downvotes FROM reviews WHERE revid=?', 'i', $cid);
$upvoters = json_decode($data['upvoters']);
$downvoters = json_decode($data['downvoters']);
$upvotes = $data['upvotes'];
$downvotes = $data['downvotes'];

$uid = safe_query('SELECT uid FROM users WHERE uname=?', 's', $_SESSION['uname'])['uid'];

if($vote == 'upvote') {
    if(in_array($uid, $upvoters)) {
        error('you already upvoted');
    }
    if(($i = array_search($uid, $downvoters)) !== false) {
        array_splice($downvoters, $i, 1); // remove user from downvoters
        $downvotes--;
    }
    array_push($upvoters, $uid);
    $upvotes++;

} else if ($vote == 'downvote') {
    if(in_array($uid, $downvoters)) {
        error('you already downvoted');
    }
    if(($i = array_search($uid, $upvoters)) !== false) {
        array_splice($upvoters, $i, 1); // remove user from upvoters
        $upvotes--;
    }
    array_push($downvoters, $uid);
    $downvotes++;

} else if($vote == 'none') {
    if(($i = array_search($uid, $downvoters)) !== false) {
        array_splice($downvoters, $i, 1); // remove user from downvoters
        $downvotes--;
    } else if(($i = array_search($uid, $upvoters)) !== false) {
        array_splice($upvoters, $i, 1); // remove user from upvoters
        $upvotes--;
    }

} else {
    error('unknown vote');
}

$upvoters = json_encode($upvoters);
$downvoters = json_encode($downvoters);
safe_query('UPDATE reviews SET upvoters = ?, downvoters = ?, upvotes = ?, downvotes = ? WHERE revid = ?', 'ssiii', $upvoters, $downvoters, $upvotes, $downvotes, $cid);

echo json_encode([
    'success' => true,
    'vote' => $vote,
    'rating' => $upvotes - $downvotes
]);