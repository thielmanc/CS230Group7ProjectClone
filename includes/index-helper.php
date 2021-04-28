<?php

$address = $_POST['address'];

if (empty($address)) {
	header("Loaction: /index.php?error=EmptyField");
	exit();
}

header("Location: /geolocation.php?search=".$address);

$data = safe_query("SELECT * FROM gallery WHERE address=?","s",$address);

