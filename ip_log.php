<?php
require_once("config/db.php");

if(!isset($_COOKIE['origin_ref']))
{
    setcookie('origin_ref', $_SERVER['HTTP_REFERER']);
}
try {
  $var = $_COOKIE['origin_ref'];
} catch(Exception $e) {
  $var = 'NOREF';
}
date_default_timezone_set("Europe/Berlin");
$ip = "$_SERVER[REMOTE_ADDR]" . " - " . date('Y-m-d H:i:s') . " URL:" . "$_SERVER[REQUEST_URI]" . " REQUEST_METHOD:" . "$_SERVER[REQUEST_METHOD]" . " T:" . "$_SERVER[REQUEST_TIME]" . " REF:" . $var;
file_put_contents('views/ips.txt', $ip . PHP_EOL, FILE_APPEND);

if ($login->isUserLoggedIn() == true) {
  $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($db_connection->connect_error) {
    die("Something went wrong. Error code: 16.");
}
  try {
    $usernameforip = $_SESSION['user_name'];
    $sql = "UPDATE users SET last_ip='$_SERVER[REMOTE_ADDR]' WHERE user_name='$usernameforip'";
    $query_new_user_insert = $db_connection->query($sql);

    if ($query_new_user_insert) { } else {
      echo "Something went wrong. Error code: 17";
      die();
    }
  } catch(Exception $e) {
    echo "Something went wrong. Error code: 18";
    die();
  }
}
