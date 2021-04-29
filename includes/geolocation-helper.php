<?php

$address = $_GET['address'];

$address = urlencode($address);
header("Location: /geolocation.php?address=".$address);