<?php 

if (!isset($_POST['login'])) {
  header("Location: /login.php");
	exit();
}

require 'dbhandler.php';
require '../models/user.php';

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

session_start();
// $_SESSION['user'] = new User($data['fname'], $data['lname'], $data['uname'], $data['email'], FALSE);
$_SESSION['fname'] = $data['fname'];
$_SESSION['lname'] = $data['lname'];
$_SESSION['uname'] = $data['uname'];
$_SESSION['email'] = $data['email'];
$_SESSION['uid'] = $data['uid'];
$_SESSION['privileged'] = $data['privileged'];


header("Location: /profile.php?success=login");