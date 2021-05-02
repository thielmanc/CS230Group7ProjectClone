<?php

const DEFAULT_PROFILE_PICTURE = '/images/default-silhouette.svg';

require_once 'dbhandler.php';

function fetch_user_by_id($id) {
    $data = safe_query('SELECT * FROM users WHERE uid = ?', 'i', $id);
    return array(
        'uid' => $data['uid'],
        'first_name' => $data['fname'],
        'last_name' => $data['lname'],
        'username' => $data['uname'],
        'email' => $data['email'],
        'profile_picture' => ($data['pfpurl'] && file_exists(__DIR__."/..{$data['pfpurl']}")) ? $data['pfpurl'] : DEFAULT_PROFILE_PICTURE,
        'privileged' => $data['privileged'],
        'bio' => $data['bio']
    );
}

function fetch_user_by_username($username) {
    $data = safe_query('SELECT * FROM users WHERE uname = ?', 's', $username);
    return array(
        'uid' => $data['uid'],
        'first_name' => $data['fname'],
        'last_name' => $data['lname'],
        'username' => $data['uname'],
        'email' => $data['email'],
        'profile_picture' => ($data['pfpurl'] && file_exists(__DIR__."/..{$data['pfpurl']}")) ? $data['pfpurl'] : DEFAULT_PROFILE_PICTURE,
        'privileged' => $data['privileged'],
        'bio' => $data['bio']
    );
}
