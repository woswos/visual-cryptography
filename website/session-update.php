<?php

// Start the session
session_start();

$varName = $_GET['clickedButtonId'];
$_SESSION[$varName] = $_GET['status'];

?>
