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

$stmt = safe_stmt_exec("SELECT 1 FROM users WHERE uname=? OR email=?", "ss", $username, $username);
$stmt->store_result();
$check = $stmt->num_rows();
$stmt->close();

if ($check > 0) {
	header("Location: /signup.php?error=UsernameOrEmailTaken");
	exit();
}

$hashed = password_hash($passw, PASSWORD_BCRYPT);

safe_query("INSERT INTO users (lname, fname, email, uname, password, privileged) VALUES (?, ?, ?, ?, ?, FALSE)", "sssss", $lname, $fname, $email, $username, $hashed);

header("Location: /signup.php?signup=success");
