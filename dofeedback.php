




<?php

require 'header.php';
require_once('helpers.php');
require_once("config/db.php");

if (!empty($_POST)) {
    $payment_tag = $_POST['payment_tag'];
    $user_name_seller = $_POST['user_name_seller'];
    $email_buyer = $_POST['check_mail'];
    $rep_choice = $_POST['rep_choice'];

    if (!empty($_POST['rep_choice']) &&
      !empty($_POST['user_name_seller']) &&
      !empty($_POST['payment_tag']) &&
      !empty($_POST['check_mail']) &&
      ctype_alnum(str_replace('-', '', $payment_tag)) &&
      ctype_alnum($user_name_seller) &&
      filter_var($email_buyer, FILTER_VALIDATE_EMAIL) &&
      ctype_alnum($rep_choice)
      ) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Error 75e59 ");
        }

        $sql = 'SELECT * from payments WHERE payment_tag="' . $payment_tag . '" AND user_name_seller="' . $user_name_seller . '"';
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $db_insert_timestamp = $row["timestamp"];
                $db_real_payment_cost = $row["payment_cost"];
                $db_payment_state = $row["payment_state"];
                $db_product_id= $row["product_id"];
                $db_tx_id = $row["tx_id"];
                $db_qtrade_id = $row["qtrade_id"];
                $db_payment_tag = $row["payment_tag"];
                $db_user_name_seller = $row["user_name_seller"];
                $db_email_buyer = $row["email_buyer"];
                $db_product_delivered = $row["product_delivered"];
                $db_payment_cost = intval(intval($real_payment_cost) * 1.025876 + 2);
                $db_left_feedback = $row["left_feedback"];
            }
        } else {
            header('Location: /');
            exit();
        }


        $sql2 = 'SELECT user_positive_fb, user_negative_fb FROM users WHERE user_name="' . $user_name_seller . '"';
        $result = $conn->query($sql2);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user_positive_fb = $row['user_positive_fb'];
                $user_negative_fb = $row['user_negative_fb'];
                $new_positive_fb = intval($user_positive_fb) + 1;
                $new_negative_fb = intval($user_negative_fb) + 1;
                $sql_pos_plus = 'UPDATE users SET user_positive_fb="' . $new_positive_fb . '" WHERE user_name="' . $user_name_seller . '"';
                $sql_neg_plus = 'UPDATE users SET user_negative_fb="' . $new_negative_fb . '" WHERE user_name="' . $user_name_seller . '"';
                $sql_feedback = 'UPDATE payments SET left_feedback="1" WHERE payment_tag="' . $payment_tag . '"';
            }
        } else {
            header('Location: /');
            exit();
        }

        if ($email_buyer === $db_email_buyer &&
        $db_payment_state === '3' &&
        $db_left_feedback !== '1'
                                        ) {
            if ($rep_choice === 'positive') {
                if ($conn->query($sql_feedback) === true) {
                    if ($conn->query($sql_pos_plus) === true) {
                        header('Location: /process?tag=' . $payment_tag);
                        exit();
                    }
                }
            } elseif ($rep_choice === 'negative') {
                if ($conn->query($sql_feedback) === true) {
                    if ($conn->query($sql_neg_plus) === true) {
                        header('Location: /process?tag=' . $payment_tag);
                        exit();
                    }
                }
            }
        }
        $conn->close();
        header('Location: /');
        exit();
    }
}




 ?>
