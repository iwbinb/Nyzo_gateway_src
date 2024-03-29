<?php include 'header.php' ?>

  <body class="bg-light">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header bg-primary" style="color: #fff;">Reset password</div>
        <div class="card-body">
          <div class="text-center mb-4">
            <h4>Forgot your password?</h4>
            <p>Enter your email address and we will send you instructions on how to reset your password.</p>
          </div>
          <form>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Enter email address" required="required" autofocus="autofocus">
                <label for="inputEmail">Enter email address</label>
              </div>
            </div>
            <a class="btn btn-primary btn-block" href="#" onclick="alert('Please contact . [@] gmail.com')">Reset password</a>
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="register.php">Register an account</a>
            <a class="d-block small" href="login.php">Login page</a>
          </div>
        </div>
      </div>
    </div>

    <?php include 'footer.php'; ?>

  </body>

</html>
