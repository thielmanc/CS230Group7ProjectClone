<?php
require_once 'dbhandler.php';
require_once 'fetch-user-info.php';
//input: id of gallery item to get comments on
//output: all comments on the item using transform function
function comments_on($item_id) {
    $stmt = safe_stmt_exec('SELECT * FROM reviews WHERE itemid = ? AND parentid IS NULL ORDER BY upvotes - downvotes DESC', 'i', $item_id);
    $stmt = $stmt->get_result();
    while($comment = $stmt->fetch_assoc())
        yield transform($comment);
}

//input: id of comment to get replies to
//output: all replies to this item (using transform function)
function replies_to($cid) {
    $stmt = safe_stmt_exec('SELECT * FROM reviews WHERE parentid = ? ORDER BY upvotes - downvotes DESC', 'i', $cid);
    $stmt = $stmt->get_result();
    while($comment = $stmt->fetch_assoc())
        yield transform($comment);
}
//input: comment id to get
//output: array of comment fields using transform
function comment_with_id($cid) {
    return transform(safe_query('SELECT * FROM reviews WHERE revid = ?', 'i', $cid));
}

//input: user to get comments from
//output: all comments this user made (using transform function)
function comments_by($user) {
    $stmt = safe_stmt_exec('SELECT * FROM reviews WHERE uname = ? AND parentid IS NULL ORDER BY upvotes - downvotes DESC', 's', $user);
    $stmt = $stmt->get_result();
    while($comment = $stmt->fetch_assoc())
        yield transform($comment);
}

//input: comment from the database
//output: array of important information on comment using information from comment from database
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