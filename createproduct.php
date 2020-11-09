<?php require 'header.php'; ?>
<?php require_once("alerts.php");
require_once('helpers.php');
require_once("config/db.php");
 ?>
<head>

  <?php
  if ($login->isUserLoggedIn() !== true) {
      header('Location: /');
      exit();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && $login->isUserLoggedIn() == true) {
      if (!empty($_POST['product-name']) && !empty($_POST['product-price']) && !empty($_POST['product-delivery']) &&
  !empty($_POST['product-type']) && !empty($_POST['list-marketplace']) && !empty($_POST['payment-type']) && !empty($_POST['product-description'])) {
          $user = $_SESSION['user_name'];
          $productpricemin = '10';
          $productpricemax = '100000';

          $productname = $_POST['product-name'];
          $product_description = $_POST['product-description'];

          $productprice = $_POST['product-price'];

          $producttype = $_POST['product-type'];
          $productdata = $_POST['product-delivery'];

          $listmarketplace = $_POST['list-marketplace'];
          $paymenttype = $_POST['payment-type'];

          if (ctype_alnum(trim(str_replace(' ', '', $productname)))) {
              $productname = $productname;
          } else {
              $productname = 'Product';
          }

          if (ctype_alnum(trim(str_replace(' ', '', $product_description)))) {
              $product_description = $product_description;
          } else {
              $product_description = 'Product description';
          }

          if (filter_var($productprice, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$productpricemin, "max_range"=>$productpricemax)))) {
              $productprice = $productprice;
          } else {
              echo 'ERROR: Invalid product price';
              die();
          }

          if ($producttype === 'type-url') {
              $producttype = $producttype;
          } elseif ($producttype === 'type-list') {
              $producttype = $producttype;
          } else {
              $producttype = 'type-list';
          }

          if ($producttype === 'type-url' && filter_var($productdata, FILTER_VALIDATE_URL)) {
              $producttype = 1;
              $productdata = $productdata;
          } elseif ($producttype === 'type-url' && filter_var($productdata, FILTER_VALIDATE_URL) == false) {
              echo 'ERROR: Invalid URL.';
              die();
          } elseif ($producttype === 'type-list') {
              $producttype = 2;
          } else {
              die();
          }

          if ($producttype !== 1) {
              $producttype = 2;
          }

          if ($producttype === 1) {
              $product_data_clean = rawurlencode($productdata);
              $amount_left = '500';
          } elseif ($producttype === 2) {
              $amount_left = 0;
              $productdata_array = explode("\n", $productdata);
              foreach ($productdata_array as $entry) {
                  if (ctype_alnum(trim(str_replace(' ', '', $entry)))) {
                      $entry = trim($entry);
                      if ($amount_left === 0) {
                          $product_data_clean = $entry;
                      } elseif ($amount_left > 0) {
                          $product_data_clean = $product_data_clean . '\n' . $entry;
                      }
                      $amount_left += 1;
                  } else {
                      echo 'ERROR: Illegal entry in your product list. Only alphanumeric characters, spaces and newline delimiters are allowed.';
                      die();
                  }
              }
          } else {
              die();
          }

          // echo $product_data_clean;

          if ($listmarketplace === 'list-marketplace-yes') {
              $listmarketplace = 1;
          } elseif ($listmarketplace === 'list-marketplace-no') {
              $listmarketplace = 0;
          } else {
              echo 'ERROR: invalid marketplace argument';
              die();
          }

          if ($paymenttype === 'type-nyzo') {
              $paymenttype = 1;
          } else {
              echo 'Invalid payment type';
              die();
          }
      } else {
          echo 'ERROR: Empty fields';
          die();
      }

      $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      // Check connection
      if ($conn->connect_error) {
          die("Error 832 ");
      }

      $sql = "INSERT INTO products (message_type, product_name, product_description, product_price, product_delivery, list_on_marketplace, payment_type, product_type, amount_sold, amount_left, user_name)
VALUES ('3', '$productname', '$product_description', '$productprice', '$product_data_clean', '$listmarketplace', '$paymenttype', '$producttype', '0', '$amount_left', '$user')";

      if ($conn->query($sql) === true) {
          header('Location: /');
          exit();
      } else {
          die("Error. Please check for duplicate entries or missing data.");
      }
  }
   ?>

</head><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><script>
  google.charts.load('current', {packages:["orgchart"]});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'Name');
  data.addColumn('string', 'Manager');
  data.addColumn('string', 'ToolTip');

  // For each orgchart box, provide the name, manager, and tooltip to show.
  data.addRows([
    []
  ]);


  // Create the chart.
  var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
  // Draw the chart, setting the allowHtml option to true for the tooltips.
  function getBrowserSize(){
       var w, h;

         if(typeof window.innerWidth != 'undefined')
         {
          w = window.innerWidth; //other browsers
          h = window.innerHeight;
         }
         else if(typeof document.documentElement != 'undefined' && typeof      document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0)
         {
          w =  document.documentElement.clientWidth; //IE
          h = document.documentElement.clientHeight;
         }
         else{
          w = document.body.clientWidth; //IE
          h = document.body.clientHeight;
         }
       return {'width':w, 'height': h};
}


if(parseInt(getBrowserSize().width) < 600){
 document.getElementById("chart_div").style.display = "none";
} else {chart.draw(data, {allowHtml:true});}
}

$(window).resize(function(){
  drawChart();
});</script>
</head><body>
      <div id="content-wrapper">
        <style>.pricing-header {
  max-width: 700px;
}

.card-deck .card {
  min-width: 220px;
}
.container2 {
  max-width: 960px;
}

table {
  border-collapse: inherit;
  }

.mb-3 {
  margin-top: 2rem!important;
  }

.btn-lg {
  position: absolute;
  bottom: 0;
  right: 0;
  }

.card-body {
  padding: 2.5rem;
  position: relative;
  }

  .chart {
    width: 100%;
    min-height: 450px;
  }
  /* .row {
    margin:0 !important;
  } */

  .google-visualization-orgchart-table * {
    padding: 3px;
  }

  @media only screen and (min-width: 1500px) {
    .google-visualization-orgchart-node-medium {
      font-size: 1.4em;
    }
  }
  .google-visualization-orgchart-node-medium {
    font-size: 1.1em;
  }

  .card {
    border: 0px;
  }
  .card-login {
    max-width: 100%;
  }
  .custom-select {
    max-width: 60%;
  }
</style>
<div class="container">

<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#createproduct">Create a product</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/">→ Go back to the dashboard</a>
</li>
</ul>

<div class="tab-content">
<div class="tab-pane container active" id="createproduct" style="overflow:hidden;">

<!----->
<div class="card card-login mx-auto">
  <!-- <div class="card-header bg-primary" style="color: #fff;">C</div> -->
  <div class="card-body">
<form method="post" action="createproduct" name="loginform">
  <div class="form-group row mb-2">
    <label class="col-4 col-form-label" for="product-name">Product name</label>
    <div class="col-8">
      <input type="hidden" name="csrf" value="<?php echo $csrf; ?>">
      <input id="product-name" name="product-name" type="text" class="form-control" required="required">
      <span id="product-nameHelpBlock" class="form-text text-muted mb-2">Max 20 char - a-Z0-9</span>
    </div>
  </div>
  <div class="form-group row mb-2">
    <label class="col-4 col-form-label" for="product-description">Product description</label>
    <div class="col-8">
      <input id="product-description" name="product-description" type="text" class="form-control" required="required">
      <span id="product-descHelpBlock" class="form-text text-muted mb-2">Max 28 char - a-Z0-9</span>
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="product-price" class="col-4 col-form-label">Product price (∩)</label>
    <div class="col-8">
      <input id="product-price" name="product-price" type="text" class="form-control" required="required">
      <span id="product-priceHelpBlock" class="form-text text-muted mb-2">Minimum of 10 nyzo, without decimals.</span>
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="product-delivery" class="col-4 col-form-label">Product</label>
    <div class="col-8">
      <textarea id="product-delivery" name="product-delivery" cols="40" rows="5" class="form-control" aria-describedby="product-deliveryHelpBlock" required="required"></textarea>
      <span id="product-deliveryHelpBlock" class="form-text text-muted mb-5">If type is URL: Enter a Single URL where the product is located at.<br> If type is Serial List: One line = one product. a-Z0-9<br><b>If you are using the list your product needs at least 5 items in stock at all times.</b></span>
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="list-marketplace" class="col-4 col-form-label">List on marketplace</label>
    <div class="col-8">
      <select id="list-marketplace" name="list-marketplace" class="custom-select" required="required">
        <option value="list-marketplace-yes">Yes</option>
        <option value="list-marketplace-no">No</option>
      </select>
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="payment-type" class="col-4 col-form-label">Payment type</label>
    <div class="col-8">
      <select id="payment-type" name="payment-type" class="custom-select" required="required">
        <option value="type-nyzo">Nyzo</option>
      </select>
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="product-type" class="col-4 col-form-label">Product type</label>
    <div class="col-8">
      <select id="product-type" name="product-type" class="custom-select" required="required">
        <option value="type-url">URL</option>
        <option value="type-list">Serial list</option>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary mt-3">Create</button>
      <span id="createHelpBlock" class="form-text text-muted mb-5"><br>Your account details will be reported to the authorities if you are selling highly inappropiate content. Please use common sense when using our marketplace.<br><br>DO NOT SELL CREDITCARDS.<br>DO NOT SELL PERSONAL INFORMATION.<br>DO NOT SELL CHILD PORNOGRAPHY.</span>

    </div>
  </div>
</form>
</div></div>
<!----->


</div>

</div>


<?php include 'footer.php'; ?>


  </body>

</html>
