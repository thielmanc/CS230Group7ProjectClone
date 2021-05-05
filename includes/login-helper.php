<?php 

if (!isset($_POST['login'])) {
  header("Location: /login.php");
	exit();
}

require 'dbhandler.php';

$uname = $_POST['username'];
$passwd = $_POST['password'];

if (empty($uname) || empty($passwd)) {
  header("Location: /login.php?error=EmptyField");
  exit();
}

$data = safe_query("SELECT * FROM users WHERE uname=? OR email=?", "ss", $uname, $uname);

if (empty($data)) {
  header("Location: /login.php?error=UserDNE");
  exit();
}

if (!password_verify($passwd, $data['password'])) {
  header("Location: /login.php?error=WrongPass");
  exit();
}

require 'fetch-user-info.php';
session_start();
$_SESSION['user'] = fetch_user_by_username($data['uname']);
$_SESSION['fname'] = $data['fname'];
$_SESSION['lname'] = $data['lname'];
$_SESSION['uname'] = $data['uname'];
$_SESSION['email'] = $data['email'];
$_SESSION['uid'] = $data['uid'];
$_SESSION['pfpurl'] = $data['pfpurl'];
$_SESSION['privileged'] = $data['privileged'];

// set up csrf token for form security
$csrftoken = bin2hex(random_bytes(16));
$_SESSION['csrftoken'] = $csrftoken;
header("Set-Cookie: csrftoken=$csrftoken; Path=/; SameSite=Strict; HttpOnly");

// redirect the user to the site they were trying to go to if specified
// note: this might be an open redirect but i don't think so
if(isset($_POST['redirect']))
  header("Location: http://{$_SERVER['HTTP_HOST']}{$_POST['redirect']}");
else
  header("Location: /profile.php?success=login");