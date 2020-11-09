<?php
require_once "recaptchalib.php";
include 'header.php';

$secret = "";
$response = null;
$reCaptcha = new ReCaptcha($secret);
?>

<?php
header("Connection: close");
 ?>
  <body class="bg-light">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header bg-primary" style="color: #fff;">Register an account</div>
        <div class="card-body">

          <form method="post" action="register" name="registerform">

            <div class="form-group">
                  <div class="form-label-group">

                    <input type="text" id="login_input_username" class="form-control" placeholder="Username" pattern="[a-zA-Z0-9]{2,64}" name="user_name" autofocus="autofocus" required>
                    <label for="login_input_username">Username (publicly visible)</label>

                  </div>
            </div>

            <div class="form-group">
              <div class="form-label-group">

                <input type="email" id="login_input_email" class="form-control" name="user_email" placeholder="Email address" required>
                <label for="login_input_email">Email address (private)</label>

              </div>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">

                    <input type="password" id="login_input_password_new" class="form-control" name="user_password_new" pattern=".{6,}" placeholder="Password" autocomplete="off" required>
                    <label for="login_input_password_new">Password</label>

                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-label-group">

                    <input type="password" id="login_input_password_repeat" class="form-control" name="user_password_repeat" pattern=".{6,}" placeholder="Confirm password" autocomplete="off" required>
                    <label for="login_input_password_repeat">Confirm password</label>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
    <div class="g-recaptcha" style="margin-top:13px;" data-sitekey=""></div></div></div>
              </div>
            </div>

            <input type="submit" name="register" value="Register" class="btn btn-primary btn-block">

          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="login">Login page</a>
            <a class="d-block small" href="forgot-password">Forgot password?</a>
          </div>
        </div>
      </div>
    </div>
    <script src='https://www.google.com/recaptcha/api.js?hl=en-GB'></script>
        <?php include 'footer.php'; ?>
    <?php
    // show potential errors / feedback (from registration object)
    if (isset($registration)) {
        if ($registration->errors) {
            foreach ($registration->errors as $error) {
                echo $error;
            }
        }
        if ($registration->messages) {
            foreach ($registration->messages as $message) {
                echo $message;
            }
        }
    }
     ?>
  </body>

</html>
