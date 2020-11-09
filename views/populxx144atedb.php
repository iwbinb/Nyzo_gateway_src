<?php
// $conn = new mysqli(---);
//
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
//     echo "error";
// }
// else{
//     echo "conn successful";
// }
// $sql = "CREATE TABLE IF NOT EXISTS users (
//   user_id int(11) NOT NULL AUTO_INCREMENT,
//   user_name varchar(64) COLLATE utf8_unicode_ci NOT NULL,
//   user_password_hash varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//   user_email varchar(64) COLLATE utf8_unicode_ci NOT NULL,
//   PRIMARY KEY (user_id),
//   UNIQUE KEY user_name (user_name),
//   UNIQUE KEY user_email (user_email)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
//
// $sql2 = "CREATE TABLE IF NOT EXISTS order_alerts (
//   alert_id int(11) NOT NULL AUTO_INCREMENT,
//   user_id int(11) NOT NULL,
//   alert_active int(11) NOT NULL,
//   alert_message varchar(512) COLLATE utf8_unicode_ci NOT NULL,
//   PRIMARY KEY (alert_id)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
//
// $sql3 = "INSERT INTO order_alerts (alert_id, user_id, alert_active, alert_message)
// VALUES (NULL, '1', '1', 'Your order 45d8f4w6f1g is now in the queue and pending execution.');"
//
// # $result = $conn->query($sql);
// $result = $conn->query($sql2);
// $conn-> close();
?>
