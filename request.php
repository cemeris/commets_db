<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include 'DB.php';
$db = new DB();

if (array_key_exists('name', $_POST) && array_key_exists('comment', $_POST)) {
    //TODO: add validation for sql values
    $db->add($_POST['name'], $_POST['comment']);
    echo "success";
}


header('location: /FD-7/comments/');