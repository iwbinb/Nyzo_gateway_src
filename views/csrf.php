<?php

function generateRandomString($length = 32)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (empty($_SESSION['key'])) {
    $_SESSION['key'] = bin2hex(generateRandomString());
}

$csrf = hash_hmac('sha256', 'header.php', $_SESSION['key']);

// $sql = 'INSERT INTO csrf_historic'
// echo $_SESSION['key'];
if ($login->isUserLoggedIn() === true) {
    if (!empty($_POST)) {
        if (ctype_alnum($_POST['csrf'])) {
            if ($csrf === $_POST['csrf']) {
            } else {
                // echo $_POST['csrf'];
                // echo '<br>';
                // echo $csrf;
                header('Location: /');
                exit();
            }
        } else {
            header('Location: /');
            exit();
        }
    }
}
