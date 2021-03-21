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

$conn = new DBConnection;
$sql = "SELECT * FROM users WHERE uname=? OR email=?";
$data = $conn->safe_query($sql, "ss", $uname, $uname);

if (empty($data)) {
  header("Location: /login.php?error=UserDNE");
  exit();
}

if (!password_verify($passwd, $data['password'])) {       //note: this compares encrypted password. you can use !$passwd == $data['password'] to check against the actual stored password
  header("Location: /login.php?error=WrongPass");
  exit();
}

session_start();
$_SESSION['user'] = new User($data['fname'], $data['lname'], $data['uname'], $data['email'], FALSE);
$_SESSION['uid'] = $data['uid'];

header("Location: /profile.php?success=login");