<?php
session_start();

if (!isset($_POST['prof-submit'])) {
    header("Location: ../profile.php");
    exit();
}

require 'file-validator.php';

$file = $_FILES['prof-image'];

$check = check_file($file);
if($check !== UPLOAD_ERR_OK) {
    switch($check) {
        case UPLOAD_ERR_INVALID_NAME:
            header("Location: /profile.php?error=BadFileName");
            exit();
        case UPLOAD_ERR_INVALID_TYPE:
            header("Location: /profile.php?error=BadFileType");
            exit();
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
        case UPLOAD_ERR_CUST_SIZE:
            header("Location: /profile.php?error=MaxSizeExceeded");
            exit();
        case UPLOAD_ERR_PHP_CODE_DETECTED:
            header("Location: /profile.php?error=BadFile");
            exit();
        default:
            header("Location: /profile.php?error=UnknownError");
            exit();
    }
}

require 'dbhandler.php';

$new_name = safe_file_name_gen($file);
$destination = '../profiles/'.$new_name;
$uname = $_SESSION['uname'];

$sql = "UPDATE users SET pfpurl=? WHERE uname=?";
safe_query($sql, 'ss', $destination, $uname);

move_uploaded_file($file['tmp_name'], $destination);

header("Location: /profile.php?success=UploadWin");
exit();
