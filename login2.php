<?php

require_once "recaptchalib.php";
include 'header.php';

$secret = "";
$respons1e = null;
$reCaptcha = new ReCaptcha($secret);

 ?>
 <style>
 /* .container {
   max-width: 77%;!important
 }

 .card-login {
   max-width: 100%;
 } */
 </style>
  <script src='https://www.google.com/recaptcha/api.js?hl=en-GB'></script>
  <body class="bg-light">

    <div class="container">

      <div class="row">
  <div class="col-sm-12">
    <!-- 4 -->
    <div class="card card-login mx-auto mt-5">
      <div class="card-header bg-primary" style="color: #fff;">Login</div>
      <div class="card-body">
        <form method="post" action="/" name="loginform">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="login_input_username" name="user_name" class="form-control" placeholder="Username" autofocus="autofocus" required>
              <label for="login_input_username">Username</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="login_input_password" name="user_password" class="form-control" placeholder="Password" required autocomplete="off">
              <label for="login_input_password">Password</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-label-group">
  <div class="g-recaptcha" style="margin-top:13px; margin-bottom: 13px;" data-sitekey=""></div></div></div>
          <input type="submit" class="btn btn-primary btn-block bg-primary" style="color: #fff;" value="Login" name="login">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register">Register an account</a>
          <a class="d-block small" href="forgot-password">Forgot password?</a>
        </div>
      </div>
    </div>
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
