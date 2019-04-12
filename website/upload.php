<?php
// Start the session
session_start();
$_SESSION["uploadCompleted"] = TRUE;
$target_dir = "static/images/";
$target_file = $target_dir.time()."_".basename($_FILES["fileToUpload"]["name"]);
//$target_file = $target_dir . "input.png";
$target_file =  str_replace(' ', '_', $target_file);
$_SESSION["target_file"] = $target_file;
$_SESSION["uploaded_file_name"] = time()."_".basename($_FILES["fileToUpload"]["name"]);
$_SESSION["uploaded_file_name"] =  str_replace(' ', '_', $_SESSION["uploaded_file_name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //echo "The file ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
    $_SESSION["uploadCompleted"] = TRUE;
    $_SESSION["uploadError"] = FALSE;
} else {
    $_SESSION["uploadError"] = TRUE;
    $_SESSION["uploadCompleted"] = FALSE;
    //echo "Sorry, there was an error uploading your file.";
}
include("encrypt-preview.php");
// There should be no echo's before the header redirect
header("Location: .././index.php", true, 301);
