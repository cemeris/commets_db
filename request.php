<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include 'DB.php';
$db = new DB();

if (
    array_key_exists('name', $_POST) &&
    array_key_exists('comment', $_POST) &&
    is_string($_POST['name']) &&
    is_string($_POST['comment']) &&
    $_POST['name'] !== '' &&
    $_POST['comment'] !== ''
) {
    if (
        array_key_exists('id', $_POST) &&
        is_string($_POST['id']) &&
        $_POST['id'] !== ''
    ) {
        echo $db->update($_POST['id'], $_POST['name'], $_POST['comment']);
        echo "success";
    }
    else {
        echo $db->add($_POST['name'], $_POST['comment']);
        echo "success";
    }
}
elseif (
    array_key_exists('delete', $_GET) &&
    is_string($_GET['delete']) &&
    $_GET['delete'] !== ''
) {
    $db->delete($_GET['delete']);
}


header('location: /');