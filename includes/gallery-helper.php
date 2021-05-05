<?php
require_once 'dbhandler.php';
require_once 'censorfunction.php';
require_once 'require-admin-privileges.php';

define('KB', 1024);
define('MB', 1048576);

if (isset($_POST['gallery-submit'])) {
    $file = $_FILES['gallery-image'];
    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
    $file_error = $file['error'];
    $file_size = $file['size'];
    $address = $_POST['address'];
    $title = $_POST['title'];
    $censoredDescript = censor($_POST['descript']);

    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed = array('jpg', 'jpeg', 'png', 'svg');
    
    if ($file_error !== 0) {
        header("Location: ../admin.php?error=UploadError");
        exit();
    }

    if (!in_array($ext, $allowed)) {
        header("Location: ../admin.php?error=InvalidType");
        exit();
    }

    if ($file_size > 4 * MB) {
        header("Location: ../admin.php?error=FileSizeExceeded");
    } else {
        $new_name = uniqid('', true).".".$ext;          // random prefix. extra "." adds entropy, more unique
        $destination = '../gallery/'.$new_name;
        $sqldest = "/gallery/$new_name";
        $sql = "INSERT INTO gallery (title, descript, picpath, address) VALUES (?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../admin.php?error=SQLInjection");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ssss", $title, $censoredDescript, $sqldest, $address);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            move_uploaded_file($file_tmp_name, $destination);
            header("Location: ../admin.php?Success=GalleryUpload");
            exit();
        }
    }
} else {
    header("Location: ../admin.php");
    exit();
}