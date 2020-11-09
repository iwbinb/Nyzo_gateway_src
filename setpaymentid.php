




<?php
require 'header.php';
require_once('helpers.php');
require_once("config/db.php");
$user = $_SESSION['user_name'];

if (!empty($_POST['pubID'])) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Error 75e99 ");
    }

    $pub_id_to_insert = $_POST['pubID'];

    if (ctype_alnum(trim(str_replace('-', '', $pub_id_to_insert))) && strlen($pub_id_to_insert) === 67) {
        $sql = 'UPDATE users SET public_id="' . $pub_id_to_insert . '" WHERE user_name=' . '"' . $user . '"';
        if ($conn->query($sql) === true) {
            header('Location: /?tab=balance');
            exit();
        } else {
            header('Location: /?tab=balance');
            exit();
        }

        $conn->close();
    } else {
        echo 'Invalid payment ID - <a href="/?tab=balance"> Go back</a>';
        exit();
    }
} else {
    header('Location: /');
    exit();
}

 ?>
