<?php

$merchant_id = 'Your_Merchant_ID';
$secret = 'Your_IPN_Secret';

if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
  die("No HMAC signature sent");
}

$merchant = isset($_POST['merchant']) ? $_POST['merchant']:'';
if (empty($merchant)) {
  die("No Merchant ID passed");
}

if ($merchant != $merchant_id) {
  die("Invalid Merchant ID");
}

$request = file_get_contents('php://input');
if ($request === FALSE || empty($request)) {
  die("Error reading POST data");
}

$hmac = hash_hmac("sha512", $request, $secret);
if ($hmac != $_SERVER['HTTP_HMAC']) {
  die("HMAC signature does not match");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $website = test_input($_POST["website"]);
  $comment = test_input($_POST["comment"]);
  $gender = test_input($_POST["gender"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
