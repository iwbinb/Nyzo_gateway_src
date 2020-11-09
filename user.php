




<?php
include 'header.php';
require_once("config/db.php");
// require_once("tx_left.php");
require_once("user_reputation.php");
$product_id_min = 1;
$product_id_max = 1000000;
$headers = "From: gateway@nyzo.net";

if (!empty($_GET['name'])) {
    $user_clean = $_GET['name'];
    if (ctype_alnum($user_clean)) {
        $user_clean = $user_clean;
    } else {
        // header('Location: /403');
        exit();
    }
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
          echo $user_clean;
          echo '</a> <a class="ml-auto" style="color: #fff;">';
          echo '</div>


          <div class="card-body">
            <form method="post" action="#';
          echo '" name="loginform">
            <div class="form-group">

';
getReputationBar($user_clean);
echo '

</div>
          </form>
          <div class="text-center">
            <a class="d-block small mt-1" href="privacy-policy">Privacy policy</a>
          </div>
        </div>';
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
