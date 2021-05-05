<?php
require_once 'dbhandler.php';
require_once 'fetch-user-info.php';

function comments_on($item_id) {
    $stmt = safe_stmt_exec('SELECT * FROM reviews WHERE itemid = ? AND parentid IS NULL ORDER BY upvotes - downvotes DESC', 'i', $item_id);
    $stmt = $stmt->get_result();
    while($comment = $stmt->fetch_assoc())
        yield transform($comment);
}

function replies_to($cid) {
    $stmt = safe_stmt_exec('SELECT * FROM reviews WHERE parentid = ? ORDER BY upvotes - downvotes DESC', 'i', $cid);
    $stmt = $stmt->get_result();
    while($comment = $stmt->fetch_assoc())
        yield transform($comment);
}

function comment_with_id($cid) {
    return transform(safe_query('SELECT * FROM reviews WHERE revid = ?', 'i', $cid));
}

function comments_by($user) {
    $stmt = safe_stmt_exec('SELECT * FROM reviews WHERE uname = ? AND parentid IS NULL ORDER BY upvotes - downvotes DESC', 's', $user);
    $stmt = $stmt->get_result();
    while($comment = $stmt->fetch_assoc())
        yield transform($comment);
}

function transform($comment) {
    $vote_state = 'none';
    if(in_array($_SESSION['user']['uid'], json_decode($comment['upvoters']))) {
        $vote_state = 'upvote';
    } else if(in_array($_SESSION['user']['uid'], json_decode($comment['downvoters']))) {
        $vote_state = 'downvote';
    }

    return array(
        'cid' => $comment['revid'],
        'rating' => $comment['upvotes'] - $comment['downvotes'],
        'time' => $comment['revdate'],
        'author_image' => fetch_user_by_username($comment['uname'])['profile_picture'],
        'author_url' => "/profile.php?user={$comment['uname']}",
        'author' => $comment['uname'],
        'role' => 'resident', # PLACEHOLDER
        'text' => $comment['reviewtext'],
        'replies_permitted' => true, # PLACEHOLDER
        'vote_state' => $vote_state
    );
}