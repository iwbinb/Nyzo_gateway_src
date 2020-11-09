<?php
require 'header.php';
require_once("config/db.php");
require_once("tx_left.php");
$product_id_min = 1;
$product_id_max = 1000000;
$headers = "From: gateway@nyzo.net";

if (!empty($_GET['tag'])) {
    $payment_tag = $_GET['tag'];
    if (ctype_alnum($payment_tag)) {
        $payment_tag = $payment_tag;
    } else {
        // header('Location: /403');
        exit();
    }
}

function showFeedbackForm($login, $csrf, $user_name_seller, $email_buyer, $payment_tag)
{
    echo '<hr><form method="post" action="dofeedback">';
    echo '<div class="card-body" style="max-width:75%; margin-left:auto; margin-right:auto;"> <div class="form-group"><div class="form-group text"><span class="small">Share your experience</span>
    <div class="form-label-group mt-1">
      <input type="text" id="check_mail" name="check_mail" class="form-control" placeholder="" autofocus="autofocus" required>
      <label for="check_mail">Buyer\'s email address</label>
    </div>
    <div class="form-label-group mt-2 text-center">
    <div class="form-check-inline">';

    echo '
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="rep_choice" value="positive">Positive
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="rep_choice" value="negative">Negative
  </label>
</div>

    </div>';
    if ($login->isUserLoggedIn() === true) {
        echo '<input type="hidden" name="csrf" value="';
        echo $csrf;
        echo '">';
    }
    echo '<input type="hidden" name="user_name_seller" value="';
    echo $user_name_seller;
    echo '">
    <input type="hidden" name="payment_tag" value="';
    echo $payment_tag;
    echo '">';
    echo '
    <div class="form-label-group text-center">
<div class="g-recaptcha" style="margin-top:13px; margin-bottom: 13px;" data-sitekey="6Ld_7pUUAAAAAIRd1J90810w7FZsMLU5ULQ__Vsp"></div></div>
<input type="submit" class="btn btn-success btn-block bg-success" style="color: #fff;" value="Submit feedback" name="submit">
  </div></div></div>';
    echo '</form>';
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Error 877 ");
}

$sql = 'SELECT * from payments WHERE payment_tag="' . $payment_tag . '"';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $insert_timestamp = $row["timestamp"];
        $real_payment_cost = $row["payment_cost"];
        $payment_state = $row["payment_state"];
        $product_id= $row["product_id"];
        $tx_id = $row["tx_id"];
        $qtrade_id = $row["qtrade_id"];
        $payment_tag = $row["payment_tag"];
        $submit_payment_tag = $row["payment_tag"];
        $user_name_seller = $row["user_name_seller"];
        $email_buyer = $row["email_buyer"];
        $product_delivered = $row["product_delivered"];
        $payment_cost = intval(intval($real_payment_cost) * 1.025876 + 2);
        $left_feedback = $row["left_feedback"];
    }
} else {
    echo "Unknown tag";
    exit();
}
$conn->close();
if ($login->isUserLoggedIn() == true) {
    if ($user_name_seller === $_SESSION['user_name']) {
        $payment_cost = $real_payment_cost;
    }
}

$mins_until_expire = '0';

$invoice_validity = '1';
// $format = '%Y-%m-%d %H:%M:%S';
// echo $insert_timestamp;
$insert_timestamp = strtotime($insert_timestamp);
// echo date_default_timezone_get();
// echo '<br>';
$valid_until_timestamp = $insert_timestamp + 1800;
// echo $valid_until_timestamp;
$now_timestamp = time();
// echo '<br>';
// echo $now_timestamp;
if ($now_timestamp > $valid_until_timestamp) {
    $invoice_validity = '0';
} elseif ($now_timestamp < $valid_until_timestamp) {
    $mins_until_expire = ($valid_until_timestamp - $now_timestamp)/60;
    // echo $mins_until_expire;
    $mins_until_expire = round($mins_until_expire, 2);
    // echo $mins_until_expire;
    $mins_until_expire = $mins_until_expire . " min";
    // echo $mins_until_expire;
}

if ($payment_state === '1' || $payment_state === '6') {
    $pay_address = "1419b9d57f3da984-f66b595dbd15455c-5ed9679a1dee156f-6149a63357ee038d";
    $title_pay_address = "Payment address";
    $title_pay_tag = "Payment Tag";
    $card_header = "Payment pending";
    if ($invoice_validity === '0' || $payment_state === '6') {
        // echo '<br>';
        // echo $invoice_validity;
        $card_header = 'Payment ' . $payment_tag;
        $payment_tag = 'INVOICE EXPIRED';
        $mins_until_expire = 'EXPIRED';
    }
} elseif ($payment_state === '3') {
    $mins_until_expire = 'CONFIRMED';
    $card_header = "Payment confirmed";
    $pay_address = $tx_id;
    $title_pay_address = "Transaction ID";
    $title_pay_tag = "Your product";
    $payment_tag = $product_delivered;
} else {
    echo "Something went wrong. Please contact . in the Nyzo discord.";
    exit();
}


 ?>
  <script src='https://www.google.com/recaptcha/api.js?hl=en-GB'></script>
  <body class="bg-light">

    <div class="container">
      <div class="row">
        <?php
          echo '<div class="col-sm-12"><!-- 4 -->
          <div class="card card-login mx-auto mt-5" style="max-width: 44rem;">
          <div class="card-header bg-success d-flex" style="color: #fff;"><a>';
          echo $card_header;
          echo '</a> <a class="ml-auto" style="color: #fff;">Time left: <b>';
          echo $mins_until_expire;
          echo '</b></a></div>
          <div class="card-header bg d-flex" style="color: #000000;"><a>';
          echo $product_description;
          echo '</a> <a class="ml-auto mr-auto" style="color: #000;">';
          echo $payment_cost;
          echo ' ∩</a></div>

          <div class="card-body">
            <form method="post" action="#';
          echo '" name="loginform">
            <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="payment_address" name="payment_address" class="form-control mt-2" value="';
              echo $pay_address;
              echo '" autofocus="autofocus" readonly>
              <label for="payment_address">';
              echo $title_pay_address;
              echo '</label>
            </div>

            <div class="form-label-group mt-1">
              <input type="text" id="payment_address" name="payment_address" class="form-control danger" value="';
              echo $payment_tag;
              echo '" autofocus="autofocus" readonly>
              <label for="payment_address"><b>';
              echo $title_pay_tag;
              echo '</b></label>
            </div>
</div>
          </form>
          <div class="text-center">
          <a class="d-block small mt-3" href="https://www.urldecoder.org">URL decoder</a>
            <a class="d-block small mt-1" href="privacy-policy">Privacy policy</a>
            <a class="d-block small mt-1" href="https://discordapp.com/invite/REzrUZG">Payment undetected?</a>
          </div>
        </div>';
        if ($payment_state === '3') {
            if ($left_feedback !== '1') {
                showFeedbackForm($login, $csrf, $user_name_seller, $email_buyer, $submit_payment_tag);
            }
        } else {
            timeLeftProgressbar($percentage_tx_delay, $mins_tx_delay_float, $percentage_tx_confirm, $mins_after_delay, $mins_until_expire);
        }
        echo '
      </div>
    </div>';
?>


    </div>
    </div>

  <?php include 'footer.php'; ?>
  <?php
  // show potential errors / feedback (from login object)
  if (isset($login)) {
      if ($login->errors) {
          foreach ($login->errors as $error) {
              echo $error;
          }
      }
      if ($login->messages) {
          foreach ($login->messages as $message) {
              echo $message;
          }
      }
  }
  ?>
  </body>

</html>
