<?php
require_once 'dbhandler.php';
session_start();

function comments_on($item_id) {
    $stmt = safe_stmt_exec('SELECT * FROM reviews WHERE itemid = ? AND parentid IS NULL ORDER BY upvotes - downvotes DESC', 'i', $item_id);
    yield from transform($stmt);
}

function replies_to($cid) {
    $stmt = safe_stmt_exec('SELECT * FROM reviews WHERE parentid = ? ORDER BY upvotes - downvotes DESC', 'i', $cid);
    yield from transform($stmt);
}

function transform($stmt) {
    $stmt = $stmt->get_result();
    while($comment = $stmt->fetch_assoc()) {
        yield array(
            'cid' => $comment['revid'],
            'rating' => $comment['upvotes'] - $comment['downvotes'],
            'time' => $comment['revdate'],
            'author_image' => safe_query('SELECT pfpurl FROM users WHERE uname = ?', 's', $comment['uname'])['pfpurl'],
            'author_url' => 'javascript:alert("doesnt_do_anything_yet_should_eventually_go_to_profile_page")', # PLACEHOLDER
            'author' => $comment['uname'],
            'role' => 'resident', # PLACEHOLDER
            'text' => $comment['reviewtext'],
            'replies_permitted' => true, # PLACEHOLDER
            'vote_state' => in_array($_SESSION['uid'], json_decode($comment['upvoters'])) ? 'upvote' : 
                            (in_array($_SESSION['uid'], json_decode($comment['downvoters'])) ? 'downvote' : 'none')
        );
    }
}