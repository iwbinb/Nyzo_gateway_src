









<?php

require 'header.php';
require_once('helpers.php');
require_once("config/db.php");
$user = $_SESSION['user_name'];

if (!empty($_POST['product_id'])) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Error 7599 ");
    }

    $product_id_to_delete = $_POST['product_id'];

    if (ctype_alnum($product_id_to_delete) && strlen($product_id) < 6) {
        $sql = "DELETE FROM products WHERE product_id='" . $product_id_to_delete . "' AND user_name='" . $user . "'";
        // echo $sql;
        if ($conn->query($sql) === true) {
            header('Location: /');
            exit();
        } else {
            header('Location: /');
            exit();
            // echo $conn->error;
        }

        $conn->close();
    } else {
        echo 'Invalid product ID - <a href="/"> Go back</a>';
        exit();
    }
} else {
    header('Location: /');
    exit();
}


 ?>
