<?php

require_once "recaptchalib.php";
include 'header.php';
require_once("config/db.php");
require_once("tx_delay.php");

$secret = "";
$respons1e = null;
$reCaptcha = new ReCaptcha($secret);
$product_id_min = 1;
$product_id_max = 1000000;
$headers = "From: gateway@nyzo.net";

// function random_code($limit) // not used, payment tag is derived from g-captcha response and cut off [bad practice but not an issue, the page will 403 if the insert fails -- payment_tag is expected to be unique]
// {
//     return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
// }


if (!empty($_GET['id'])) {
    $product_id = $_GET['id'];
    if (filter_var($product_id, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$product_id_min, "max_range"=>$product_id_max)))) {
        $product_id = $product_id;
    } else {
        header('Location: /403');
        exit();
    }
} else {
    header('Location: /403');
    exit();
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Error 877 ");
}

$sql = 'SELECT * from products WHERE product_id=' . $product_id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_name = $row["product_name"];
        $product_description = $row["product_description"];
        $product_price = $row["product_price"];
        $product_price_insert = $row["product_price"];
        $list_on_marketplace = $row["list_on_marketplace"];
        $payment_type = $row["payment_type"];
        $product_type = $row["product_type"];
        $amount_sold = $row["amount_sold"];
        $amount_left = $row["amount_left"];
        $user_name = $row["user_name"];
        $product_delivery = $row["product_delivery"];
        $product_price = intval(intval($product_price) * 1.025876 + 2);
        if ($product_type === '1' && strlen($product_delivery) < 2) {
            echo 'The seller has entered an invalid URL therefore you can not buy this product.';
            exit();
        }
    }
} else {
    header('Location: /404');
    exit();
}

if ($login->isUserLoggedIn() == true) {
    if ($user_name === $_SESSION['user_name']) {
        echo 'You can not buy your own product.';
        exit();
    }
}

if ($product_type == 2) {
    if ($amount_left <= 5) {
        echo "This product is low on stock and can therefore not be purchased.<br>Check back at a later time.";
        exit();
    }
}

$form_append = '';
if ($list_on_marketplace === '0') {
    if (!empty($_GET['seller'])) {
        if ($_GET['seller'] !== $user_name) {
            header('Location: /403');
            exit();
        }
        $form_append = '&seller=' . $user_name;
    } else {
        echo 'This product is not listed on the marketplace. Please provide the username of the seller in the URL. (&seller=)';
        exit();
    }
}

$conn->close();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['delivery_email'])) {
          $delivery_email = $_POST['delivery_email'];

          if (filter_var($delivery_email, FILTER_VALIDATE_EMAIL)) {
              if (!empty($_POST['g-recaptcha-response']) || $_POST['g-recaptcha-response'] != null) {

          // echo $_POST['g-recaptcha-response'];

                  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                  if ($conn->connect_error) {
                      die("Error 878 ");
                  }

                  // $payment_tag = random_code(32);
                  $payment_tag = substr(sha1($_POST['g-recaptcha-response']), 0, 16);
                  $payment_tag = 'd8ee97d182d64532' . $payment_tag;
                  $sql = "INSERT INTO payments (message_type, payment_state, payment_cost, product_id, payment_tag, tx_id, qtrade_id, user_name_seller, email_buyer, left_feedback) VALUES ('2', '1', '$product_price_insert', '$product_id', '$payment_tag', '$payment_tag', '$payment_tag', '$user_name', '$delivery_email', '0')";

                  // echo $sql;

                  $sql_alert = "INSERT INTO payment_alerts (user_name, alert_active, message_type, alert_state, arg) VALUES ('$user_name', '1', '1', '1', '$payment_tag')";

                  // echo $sql_alert;


                  if ($conn->query($sql) === true) {
                  } else {
                      header('Location: /403');
                      exit();
                  }

                  if ($conn->query($sql_alert) === true) {
                  } else {
                      header('Location: /403');
                      exit();
                  }

                  $msg_mail = "Product: $product_name\r\nAmount: $product_price nyzo\r\nTo 1419b9d57f3da984-f66b595dbd15455c-5ed9679a1dee156f-6149a63357ee038d\r\nTag: $payment_tag\r\nhttps://gateway.nyzo.net/process?tag=$payment_tag\r\nThis invoice is valid for 30 minutes\r\nYOUR FUNDS WILL BE LOST FOREVER IF YOU DO NOT USE THE PAYMENT TAG.";
                  $msg_mail = wordwrap($msg_mail, 70, "\r\n");
                  mail($delivery_email, "Open invoice", "$msg_mail", $headers);
              } else {
                  echo 'Invalid captcha';
                  exit();
              }
          } else {
              echo 'Invalid email';
              exit();
          }
      } else {
          echo 'Invalid email or captcha';
          exit();
      }
  }

 ?>
  <script src='https://www.google.com/recaptcha/api.js?hl=en-GB'></script>
  <body class="bg-light">

    <div class="container">
      <div class="row">
        <?php if ($_SERVER["REQUEST_METHOD"] !== "POST") {
     echo '<div class="col-sm-12"><!-- 4 -->
          <div class="card card-login mx-auto mt-5">
          <div class="card-header bg-success d-flex" style="color: #fff;"><a>';
     echo $product_name;
     echo '</a> <a href="user?name=';
     echo $user_name;
     echo '" class="ml-auto" style="color: #fff;">Seller: <i>';
     echo $user_name;
     echo '</i></a></div>
          <div class="card-header bg d-flex" style="color: #000000;"><a>';
     echo $product_description;
     echo '</a> <a class="ml-auto" style="color: #000;">';
     echo $product_price;
     echo ' ∩</a></div>
          ';
     // timeDelayProgressbar($percentage_tx_delay, $mins_tx_delay_float, $percentage_tx_confirm, $mins_after_delay);
     echo '
          <div class="card-body">
            <form method="post" action="purchase?id=';

     echo $product_id;
     echo $form_append;
     echo '" name="loginform">';
     echo '
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="delivery_email" name="delivery_email" class="form-control" placeholder="" autofocus="autofocus" required>
                <label for="delivery_email">Email address</label>
              </div>
            </div>';
     if ($login->isUserLoggedIn() === true) {
         echo '<input type="hidden" name="csrf" value="';
         echo $csrf;
         echo '">';
     }
     echo '

            <div class="col-md-4">
              <div class="form-label-group">
    <div class="g-recaptcha" style="margin-top:13px; margin-bottom: 13px;" data-sitekey=""></div></div></div>
            <input type="submit" class="btn btn-success btn-block bg-success" style="color: #fff;" value="Purchase" name="purchase">
          </form>
          <div class="text-center">
          <span class="d-block small mt-3">No escrow</span>
            <a class="d-block small" href="privacy-policy">Privacy policy</a>';
     // timeDelayProgressbar($percentage_tx_delay, $mins_tx_delay_float, $percentage_tx_confirm, $mins_after_delay);
     echo '
          </div>
        </div>';
     timeDelayProgressbar($percentage_tx_delay, $mins_tx_delay_float, $percentage_tx_confirm, $mins_after_delay);
     echo '
      </div>
    </div>';
 }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //extra check if properly inserted pending payment
            echo '<div class="col-sm-12"><!-- 4 -->
          <div class="card mx-auto mt-5" style="max-width: 44rem;">
          <div class="card-header bg-success d-flex" style="color: #fff;"><a>Your purchase';

            echo '</a> <a href="process?tag=';
            echo $payment_tag;
            echo '" class="ml-auto" style="color: #fff;">Time left: <b>30 min</b>';
            echo '</a>';
            echo '</div>
          <div class="card-header bg d-flex" style="color: #000000;"><a>';
            echo $product_name;
            echo '</a> <a class="ml-auto" style="color: #000;"><b>Total:</b> ';
            echo $product_price; //add payment id below
            echo ' ∩</a></div>

          <div class="card-body">
            <form method="post" action="process?tag=';

            echo $payment_tag;
            echo '" name="loginform">
            <div class="form-group">
            <a><b>YOUR FUNDS WILL BE LOST <u>FOREVER</u> IF YOU DO NOT USE THE PAYMENT TAG.</b></a><br>
                <a><b>Do not pay this invoice by sending from qtrade directly.</b></a><br>
            <a>A copy of this information has been sent to you by mail. (Check your SPAM folder).</a>
              <div class="form-label-group">
                <input type="text" id="payment_address" name="payment_address" class="form-control mt-2" value="1419b9d57f3da984-f66b595dbd15455c-5ed9679a1dee156f-6149a63357ee038d" autofocus="autofocus" readonly>
                <label for="payment_address">Payment address</label>
              </div>
              <div class="form-label-group mt-2">
                <input type="text" id="payment_address" name="payment_address" class="form-control danger" value="';
            echo $payment_tag;
            echo '" autofocus="autofocus" readonly>
                <label for="payment_address"><b>Payment Tag</b></label>
              </div>
            </div>';
            if ($login->isUserLoggedIn() === true) {
                echo '<input type="hidden" name="csrf" value="';
                echo $csrf;
                echo '">';
            }
            echo '

            <div class="col-md-4">
              </div>

            <input type="submit" class="btn btn-success btn-block bg-success" style="color: #fff;" value="Check for payment" name="check">
          </form>
          <div class="text-center">
          <span class="d-block small mt-3">No escrow</span>
            <a class="d-block small" href="privacy-policy">Privacy policy</a>
          </div>
        </div>
      </div>
    </div>';
        }






        ?>
  <!-- <div class="col-sm-12">

    <div class="card card-login mx-auto mt-5">
      <div class="card-header bg-success d-flex" style="color: #fff;"><a><?php echo $product_name; ?></a> <a href="user?name=<?php echo $user_name; ?>" class="ml-auto" style="color: #fff;">Seller: <i><?php echo $user_name; ?></i></a></div>
      <div class="card-header bg d-flex" style="color: #000000;"><a><?php echo $product_description; ?></a> <a class="ml-auto" style="color: #000;"><?php echo $product_price; ?> ∩</a></div>

      <div class="card-body">
        <form method="post" action="purchase?id=<?php echo $product_id; ?>" name="loginform">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="delivery_email" name="delivery_email" class="form-control" placeholder="" autofocus="autofocus" required>
              <label for="delivery_email">Email address</label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-label-group">
  <div class="g-recaptcha" style="margin-top:13px; margin-bottom: 13px;" data-sitekey=""></div></div></div>
          <input type="submit" class="btn btn-success btn-block bg-success" style="color: #fff;" value="Purchase" name="purchase">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="privacy-policy">Privacy policy</a>
        </div>
      </div>
    </div>
  </div> -->

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
