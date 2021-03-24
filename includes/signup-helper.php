<?php

if (!isset($_POST['signup'])) {
	header("Location: /signup.php");
	exit();
}

$username = $_POST['username'];
$email = $_POST['email'];
$passw = $_POST['password'];
$passw_rep = $_POST['password-confirm'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];

if ($passw !== $passw_rep) {
	header("Location: /signup.php?error=PassMismatch");
	exit();
}

require 'dbhandler.php';

$sql = "SELECT 1 FROM users WHERE uname=? OR email=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ss", $uname, $uname);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$check = mysqli_stmt_num_rows($stmt);
mysqli_stmt_close($stmt);

if ($check > 0) {
	header("Location: /signup.php?error=UsernameOrEmailTaken");
	exit();
}

$hashed = password_hash($passw, PASSWORD_BCRYPT);

$sql = "INSERT INTO users (lname, fname, email, uname, password, privileged) VALUES (?, ?, ?, ?, ?, FALSE)";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $lname, $fname, $email, $username, $hashed);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$sql = "INSERT INTO profiles (uid) VALUES ((SELECT uid FROM users WHERE uname=?))";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: /signup.php?signup=success");
