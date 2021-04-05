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

$sql = "SELECT * FROM users WHERE uname=? OR email=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ss", $uname, $uname);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

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