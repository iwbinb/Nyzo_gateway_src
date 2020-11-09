<?php include 'header.php'; ?>
<?php
require_once("config/db.php");
require_once("alerts.php");
?>

<script>$(function(){
  var hash = window.location.hash;
  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

  $('.nav-tabs nav-item a').click(function (e) {
    $(this).tab('show');
    var scrollmem = $('body').scrollTop() || $('html').scrollTop();
    window.location.hash = this.hash;
    $('html,body').scrollTop(scrollmem);
  });
});</script>

<?php

if (!empty($_GET['tab'])) {
    $tab = $_GET['tab'];
    if (ctype_alnum(trim(str_replace(' ', '', $tab)))) {
        $tab = $tab;
    } else {
        $tab = 'NONE';
    }
} else {
    $tab = 'NONE';
}

if (strpos($tab, 'script') !== false) {
    header('Location: /z.jpg');
    exit();
}

function set_default($type)
{
    if ($type === 'alerts') {
        global $alertSort, $alertAmount;
        $alertAmount = '5';
        $alertSort = 'DESC';
    }
    if ($type === 'products') {
        global $productSort, $productAmount;
        $productSort = 'DESC';
        $productAmount = '9';
    }
    if ($type === 'payments') {
        global $orderSort, $orderAmount;
        $orderSort = 'DESC';
        $orderAmount = '50';
    }
    if ($type === 'balancehistory') {
        global $balanceSort, $balanceAmount;
        $balanceSort = 'DESC';
        $balanceAmount = '50';
    }
    if ($type === 'searchUser') {
        global $searchUser, $userSort, $userAmount;
        $searchUser = 'NONE';
        $userSort = 'DESC';
        $userAmount = '5';
    }
    if ($type === 'searchProduct') {
        global $searchProduct, $searchProductSort, $searchProductAmount;
        $searchProduct = 'NONE';
        $searchProductSort = 'DESC';
        $searchProductAmount = '5';
    }
}

function test_input($data)
{
    if (filter_var($data, FILTER_VALIDATE_INT) === false) {
        $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

  set_default('products');
  set_default('alerts');
  set_default('payments');
  set_default('balancehistory');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ((test_input($_POST["productAmount"]) && test_input($_POST["productSort"])) !== null) {
        try {
            $productAmount = test_input($_POST["productAmount"]);
            $productSort = test_input($_POST["productSort"]);
            if (filter_var($productAmount, FILTER_VALIDATE_INT) === false) {
                throw new Exception('Not an INT');
            }
            if ($productAmount > 100 | $productAmount < 0) {
                throw new Exception('Out of range');
            } else {
                $productAmount = $productAmount;
            }
            if ($productSort === 'DESC' | $productSort === 'ASC') {
                $productSort = $productSort;
            } else {
                throw new Exception('Invalid sort method');
            }
        } catch (Exception $e) {
            // echo $e;
            set_default('products');
        }
    } else {
        set_default('products');
    }

    if ((test_input($_POST["alertAmount"]) && test_input($_POST["alertSort"])) !== null) {
        try {
            $alertAmount = test_input($_POST["alertAmount"]);
            $alertSort = test_input($_POST["alertSort"]);
            if (filter_var($alertAmount, FILTER_VALIDATE_INT) === false) {
                throw new Exception('Invalid');
            }
            if ($alertAmount > 500 | $alertAmount < 0) {
                throw new Exception('Invalid');
            }
        } catch (Exception $e) {
            set_default('alerts');
        }
    } else {
        set_default('alerts');
    }

    if ((test_input($_POST["orderAmount"]) && test_input($_POST["orderSort"])) !== null) {
        try {
            $orderAmount = test_input($_POST["orderAmount"]);
            $orderSort = test_input($_POST["orderSort"]);
            if (filter_var($orderAmount, FILTER_VALIDATE_INT) === false) {
                throw new Exception('Invalid');
            }
            if ($orderAmount > 500 | $orderAmount < 0) {
                throw new Exception('Invalid');
            }
        } catch (Exception $e) {
            set_default('payments');
        }
    } else {
        set_default('payments');
    }

    if ((test_input($_POST["userAmount"]) && test_input($_POST["userSort"])) !== null) {
        try {
            $userAmount = test_input($_POST["userAmount"]);
            $userSort = test_input($_POST["userSort"]);
            if (filter_var($userAmount, FILTER_VALIDATE_INT) === false) {
                throw new Exception('Invalid');
            }
            if ($userAmount > 50 | $userAmount < 0) {
                throw new Exception('Invalid');
            }
        } catch (Exception $e) {
            set_default('searchUser');
        }
    } else {
        set_default('searchUser');
    }

    if ((test_input($_POST["searchProductAmount"]) && test_input($_POST["searchProductSort"])) !== null) {
        try {
            $searchProductAmount = test_input($_POST["searchProductAmount"]);
            $searchProductSort = test_input($_POST["searchProductSort"]);
            if (filter_var($searchProductAmount, FILTER_VALIDATE_INT) === false) {
                throw new Exception('Invalid');
            }
            if ($searchProductAmount > 500 | $searchProductAmount < 0) {
                throw new Exception('Invalid');
            }
        } catch (Exception $e) {
            set_default('searchProduct');
        }
    } else {
        set_default('searchProduct');
    }

    if (test_input($_POST["searchUser"]) !== null) {
        try {
            $searchUser = test_input($_POST["searchUser"]);
            if (ctype_alnum(trim(str_replace(' ', '', $searchUser)))) {
                $searchUser = $searchUser;
            }
            if (strlen($searchUser) > 0) {
                $tab = "searchuser";
            } else {
                throw new Exception('Invalid');
            }
        } catch (Exception $e) {
            set_default('searchUser');
        }
    } else {
        set_default('searchUser');
    }

    if (test_input($_POST["searchProduct"]) !== null) {
        try {
            $searchProduct = test_input($_POST["searchProduct"]);
            if (ctype_alnum(trim(str_replace(' ', '', $searchProduct)))) {
                $searchProduct = $searchProduct;
            }
            if (strlen($searchProduct) > 0) {
                $tab = "searchproduct";
            } else {
                throw new Exception('Invalid');
            }
        } catch (Exception $e) {
            set_default('searchProduct');
        }
    } else {
        set_default('searchProduct');
    }
}

 ?>
<head>

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
  .row {
    margin:0 !important;
  }

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

  .btn {
    width: -webkit-fill-available;
  }
</style>
<div class="container">

<ul class="nav nav-tabs">
  <li class="nav-item">
  <a class="nav-link <?php if ($tab === 'NONE') {
     echo 'active';
 } ?>" data-toggle="tab" href="#marketplace">Marketplace</a>
  </li>
<li class="nav-item">
<a class="nav-link <?php if ($tab === 'dashboard') {
     echo 'active';
 } ?>" data-toggle="tab" href="#dashboard">Dashboard</a>
</li>
<li class="nav-item">
<a class="nav-link <?php if ($tab === 'alerts') {
     echo 'active';
 } ?>" data-toggle="tab" href="#alerts">Alerts</a>
</li>
<li class="nav-item">
<a class="nav-link <?php if ($tab === 'payments') {
     echo 'active';
 } ?>" data-toggle="tab" href="#payments">Payments</a>
</li>
<li class="nav-item">
<a class="nav-link <?php if ($tab === 'products') {
     echo 'active';
 } ?>" data-toggle="tab" href="#products">Your products</a>
</li>
<li class="nav-item">
<a class="nav-link <?php if ($tab === 'balance') {
     echo 'active';
 } ?>" data-toggle="tab" href="#balance">Balance</a>
</li>
</ul>

<div class="tab-content" style="border: 1px solid #dee2e6;">
  <div class="tab-pane container <?php if ($tab === 'NONE') {
     echo 'active';
 } ?>" id="marketplace" style="overflow:hidden;">
  <div class="row">
  <div class="col-lg-12" style="">
  <div class="card mx-left mt-2 mb-2" style="width: auto;">
    <div class="card mt-2">
      <div class="row mb-2">
    <div class="col-lg-3 ml-0 mr-0 px-1" style="">
    <form class method="post" action='/'>
      <select class= "custom-select mr-1" name='productAmount' onchange='this.form.submit();'>
      <option value='9'<?php if ($productAmount === '9') {
     echo " selected='selected'";
 } ?>>Amount of results</option>
      <option value='10'<?php if ($productAmount === '10') {
     echo " selected='selected'";
 } ?>>Last 10</option>
      <option value='20'<?php if ($productAmount === '20') {
     echo " selected='selected'";
 } ?>>Last 20</option>
      <option value='50'<?php if ($productAmount === '50') {
     echo " selected='selected'";
 } ?>>Last 50</option>
      <option value='75'<?php if ($productAmount === '75') {
     echo " selected='selected'";
 } ?>>Last 75</option>
      <option value='100'<?php if ($productAmount === '100') {
     echo " selected='selected'";
 } ?>>Last 100</option>
    </select></div>
    <div class="col-lg-3 ml-0 mr-0 px-1" style="">
      <select class= "custom-select mr-1" name='productSort' onchange='this.form.submit();'>
      <option value='DESC'>Sort results</option>
      <option value='DESC'<?php if ($productSort === 'DESC') {
     echo " selected='selected'";
 } ?>>Newest first</option>
      <option value='ASC'<?php if ($productSort === 'ASC') {
     echo " selected='selected'";
 } ?>>Oldest first</option>
    </select></form></div>
    <div class="col-lg-3 mr-0 px-1" style="">
  <form class method="post" action="/?tab=searchuser">
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text" id="basic-addon1">@</span>
    </div>
    <input type="text" class="form-control mr-1" placeholder="Search user" name="searchUser" onchange='this.form.submit();'>
  </div>
  </form>
  </div><div class="col-lg-3 mr-0 px-1" style="">
  <form class method="post" action="/?tab=searchproduct">
  <div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">≈</span>
  </div>
  <input type="text" class="form-control mr-1" placeholder="Search product" name="searchProduct" onchange='this.form.submit();'>
  </div>
  </form>
  </div>
  </div>
  <div class="row">

    <?php
    $values_needed = array("message_type", "timestamp", "product_id", "product_name", "product_description", "product_price", "product_type", "amount_left", "user_name");
    $filter_value = '1';
    getValue('select', $values_needed, 'ALL', 'products', 'list_on_marketplace', $filter_value, 'timestamp', $productSort, $productAmount, 'none');
    ?>

  </div>
  </div></div>
  </div>
  </div>
  </div>
<div class="tab-pane container mt-2 <?php if ($tab === 'dashboard') {
        echo 'active show';
    } ?>" id="dashboard" style="overflow:hidden;">
<div class="row mt-2">
<div class="col-lg-4" style="padding-right:0px;">
<div class="card mx-left mt-2" style="width: auto;">
<div class="card-header bg-primary text-white">
Payment alerts <i>(last 10)</i>
</div><div class="card">
<?php
$filter_value = $_SESSION['user_name'];
$values_needed = array("message_type", "timestamp", "arg", "alert_state");
getValue('select', $values_needed, 'ALL', 'payment_alerts', 'user_name', $filter_value, 'timestamp', 'DESC', '10', 'none');
?></div>
</div></div><div class="col-lg-8">
<div class="card mx-left mt-2" style="width: auto;">
<div class="card-header bg-primary text-white">
Platform announcements <i>(last 5)</i>
</div>
<?php
$values_needed = array("message_type", "timestamp", "message");
getValue('select', $values_needed, 'ALL', 'system_alerts', 'none', 'none', 'timestamp', 'DESC', '5', 'none');

?></div>
<div class="card mx-left mt-2" style="width: auto;">
<div class="card-header bg-primary text-white">
Payments <i>(last 5)</i>
</div>
<?php
$filter_value = $_SESSION['user_name'];
$values_needed = array("message_type", "timestamp", "payment_id", "payment_state", "payment_cost", "payment_type", "payment_extra");
getValue('select', $values_needed, 'ALL', 'payments', 'user_name', $filter_value, 'timestamp', 'DESC', '5', 'none');

?></div>
</div>
</div>



</div>
<div class="tab-pane container fade <?php if ($tab === 'alerts') {
    echo 'active show';
} ?>" id="alerts">


  <div class="row">
  <div class="col-lg-12" style="">
  <div class="card mx-left mt-2 mb-2" style="width: auto;">
    <div class="card mt-2">
      <div class="row mb-2">
    <div class="col-lg-3 ml-0 mr-0 px-1" style="">
    <form class method="post" action='/?tab=alerts'>
      <select class= "custom-select mr-1" name='alertAmount' onchange='this.form.submit();'>
      <option value='10'<?php if ($alertAmount === '10') {
    echo " selected='selected'";
} ?>>Amount of results</option>
      <option value='25'<?php if ($alertAmount === '25') {
    echo " selected='selected'";
} ?>>Last 10</option>
      <option value='100'<?php if ($alertAmount === '100') {
    echo " selected='selected'";
} ?>>Last 20</option>
      <option value='200'<?php if ($alertAmount === '200') {
    echo " selected='selected'";
} ?>>Last 50</option>
      <option value='300'<?php if ($alertAmount === '300') {
    echo " selected='selected'";
} ?>>Last 75</option>
      <option value='500'<?php if ($alertAmount === '500') {
    echo " selected='selected'";
} ?>>Last 100</option>
    </select></div>
    <div class="col-lg-3 ml-0 mr-0 px-1" style="">
      <select class= "custom-select mr-1" name='alertSort' onchange='this.form.submit();'>
      <option value='DESC'>Sort results</option>
      <option value='DESC'<?php if ($alertSort === 'DESC') {
    echo " selected='selected'";
} ?>>Newest first</option>
      <option value='ASC'<?php if ($alertSort === 'ASC') {
    echo " selected='selected'";
} ?>>Oldest first</option>
    </select></form></div>
  </div>
  <div class="card mt-3">
    <?php
    $filter_value = $_SESSION['user_name'];
    $values_needed = array("message_type", "timestamp", "arg", "alert_state");
    getValue('select', $values_needed, 'ALL', 'payment_alerts', 'user_name', $filter_value, 'timestamp', $alertSort, $alertAmount, 'none');
      ?>
  </div>
  </div></div>
  </div>
  </div>
</div>

<div class="tab-pane container fade <?php if ($tab === 'payments') {
          echo 'active show';
      } ?>" id="payments">
  <div class="row">
  <div class="col-lg-12" style="">
  <div class="card mx-left mt-2 mb-2" style="width: auto;">
    <div class="card mt-2">
      <div class="row mb-2">
    <div class="col-lg-3 ml-0 mr-0 px-1" style="">
    <form class method="post" action='/?tab=payments'>
<select name='orderAmount' class="custom-select mr-1" onchange='this.form.submit();'>
<option value ='4'>Results</option>
 <option value='5' <?php if ($orderAmount === '5') {
          echo " selected='selected'";
      } ?>>Last 5</option>
 <option value='50'<?php if ($orderAmount === '50') {
          echo " selected='selected'";
      } ?>>Last 50</option>
 <option value='100'<?php if ($orderAmount === '100') {
          echo " selected='selected'";
      } ?>>Last 100</option>
 <option value='250'<?php if ($orderAmount === '250') {
          echo " selected='selected'";
      } ?>>Last 250</option>
 <option value='500'<?php if ($orderAmount === '500') {
          echo " selected='selected'";
      } ?>>Last 500</option>
</select></div>
<div class="col-lg-3 ml-0 mr-0 px-1" style="">
  <select class= "custom-select mr-1" name='orderSort' onchange='this.form.submit();'>
  <option value='DESC'>Sort results</option>
  <option value='DESC'<?php if ($orderSort === 'DESC') {
          echo " selected='selected'";
      } ?>>Newest first</option>
  <option value='ASC'<?php if ($orderSort === 'ASC') {
          echo " selected='selected'";
      } ?>>Oldest first</option>
</select></form></div>
</div>
<div class="card mt-3">
<?php
$filter_value = $_SESSION['user_name'];
$values_needed = array("message_type", "timestamp", "payment_id", "payment_cost", "payment_state", "payment_cost", "product_id", "payment_tag");
getValue('select', $values_needed, 'ALL', 'payments', 'user_name_seller', $filter_value, 'timestamp', $orderSort, $orderAmount, 'none');
  ?>
</div>
</div></div>
</div>
</div>
</div>

<div class="tab-pane container fade <?php if ($tab === 'products') {
      echo 'active show';
  } ?>" id="products">
  <div class="row">
  <div class="col-lg-12" style="">
  <div class="card mx-left mt-2 mb-2" style="width: auto;">
    <div class="card mt-2">
      <div class="row mb-2">
    <div class="col-lg-3 ml-0 mr-0 px-1" style="">
    <form class method="post" action='/?tab=products'>
<select name='productAmount' class="custom-select mr-1" onchange='this.form.submit();'>
<option value ='4'>Results</option>
 <option value='5' <?php if ($productAmount === '5') {
      echo " selected='selected'";
  } ?>>Last 5</option>
 <option value='50'<?php if ($productAmount === '50') {
      echo " selected='selected'";
  } ?>>Last 50</option>
 <option value='100'<?php if ($productAmount === '100') {
      echo " selected='selected'";
  } ?>>Last 100</option>
 <option value='250'<?php if ($productAmount === '250') {
      echo " selected='selected'";
  } ?>>Last 250</option>
 <option value='500'<?php if ($productAmount === '500') {
      echo " selected='selected'";
  } ?>>Last 500</option>
</select></div>
<div class="col-lg-3 ml-0 mr-0 px-1" style="">
  <select class= "custom-select mr-1" name='productSort' onchange='this.form.submit();'>
  <option value='DESC'>Sort results</option>
  <option value='DESC'<?php if ($productSort === 'DESC') {
      echo " selected='selected'";
  } ?>>Newest first</option>
  <option value='ASC'<?php if ($productSort === 'ASC') {
      echo " selected='selected'";
  } ?>>Oldest first</option>
</select></form></div>
</div>
  <div class="row">
<?php
$values_needed = array("message_type", "timestamp", "product_id", "product_name", "product_description", "product_price", "product_type", "amount_left", "user_name");
$filter_value = $_SESSION['user_name'];
getValue('select', $values_needed, 'ALL', 'products', 'user_name', $filter_value, 'timestamp', $productSort, $productAmount, 'none');
  ?>
</div>
</div></div>
</div>
</div>
</div>

<div class="tab-pane container fade <?php if ($tab === 'balance') {
      echo 'active show';
  } ?>" id="balance">
  <div class="row">
  <div class="col-lg-12" style="">
  <div class="card mx-left mt-2 mb-2" style="width: auto;">

      <?php
      $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      if ($conn->connect_error) {
          die("Error 757 ");
      }

      $bal_user = $_SESSION['user_name'];

      $sql = 'SELECT payment_cost from payments WHERE payment_state="3" AND user_name_seller="' . $bal_user . '"';
      $sql2 = 'SELECT withdraw_amt from withdraws WHERE user_name="' . $bal_user . '"';
      $sql3 = 'SELECT public_id from users WHERE user_name="' . $bal_user . '"';

      $result = $conn->query($sql);
      $result2 = $conn->query($sql2);
      $result3 = $conn->query($sql3);

      $confirmed_payments = 0;
      $in_withdraw = 0;
      // $public_id_db = 'Not set';

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              // var_dump($row);
              try {
                  $payment_cost = $row["payment_cost"];
                  $confirmed_payments = $confirmed_payments + intval($payment_cost); ////////////////////////////////////////
              } catch (Exception $e) {
                  $confirmed_payments = 0;
                  $in_withdraw = 0;
              }
          }
      } else {
          $confirmed_payments = 0;
          $in_withdraw = 0;
      }

      if ($result2->num_rows > 0) {
          while ($row = $result2->fetch_assoc()) {
              try {
                  $withdraw_amount = $row["withdraw_amt"];
                  $in_withdraw = $in_withdraw + intval($withdraw_amount);
              } catch (Exception $e) {
                  $in_withdraw = 0;
              }
          }
      } else {
          $in_withdraw = 0;
      }

      if ($result3->num_rows > 0) {
          while ($row = $result3->fetch_assoc()) {
              // echo $row["public_id"];
              // echo '<br>';
              // echo strlen($row["public_id"]);
              try {
                  if (strlen($row["public_id"]) === 67) {
                      $public_id_db = $row["public_id"];
                  } else {
                      $public_id_db = 'Not set';
                  }
              } catch (Exception $e) {
                  $public_id_db = 'Not set';
              }
          }
      } else {
          $public_id_db = 'Not set';
      }



    //   echo '<table class="table table-responsive" style="border-collapse:collapse; border-top:0px;">
    // <thead>
    //   <tr>
    //     <th>Nyzo received</th>
    //     <th>Nyzo withdrawn</th>
    //     <th>Payout address</th>
    //   </tr>
    // </thead>
    // <tbody>
    //   <tr>
    //   <td>';
    //   echo $confirmed_payments;
    //   echo '</td>
    //     <td>';
    //     echo $in_withdraw;
    //     echo '</td>
    //     <td>';
    //     echo $public_id_db;
    //     echo '</td>
    //   </tr>
    //   </tbody>
    //   </table>';

      echo '<div class="form-group row mb-2">
        <label for="no1" class="col-4 col-form-label">Current payment address</label>
        <div class="col-8">
          <span id="no1" class="form-text text-muted mb-2">
          ';
          echo $public_id_db; echo '</span>
          </div>
      </div>
    ';
    echo '<div class="form-group row mb-2">
      <label for="no2" class="col-4 col-form-label">Nyzo received</label>
      <div class="col-8">
      <span id="no2" class="form-text text-muted mb-2">

        ';
        echo $confirmed_payments; echo '</span>
        </div>
    </div>
  ';
  echo '<div class="form-group row mb-2">
    <label for="no3" class="col-4 col-form-label">Nyzo withdrawn</label>
    <div class="col-8">  <span id="no3" class="form-text text-muted mb-2">
    ';
      echo $in_withdraw; echo '</span>
      </div>
  </div>
';
      // echo "Amount of Nyzo received: " . $confirmed_payments . "<br>";
      // echo "Amount of Nyzo withdrawn: " . $in_withdraw . "<br>";
      // echo "Public ID configured: " . $public_id_db . "<br>";
      $conn->close();

      ///
      echo '<form method="post" action="setpaymentid" name="loginform">
        <div class="form-group row mb-2">
          <label for="pubID" class="col-4 col-form-label">Public ID</label>
          <div class="col-8">
          <input type="hidden" name="csrf" value="';
          echo $csrf;
          echo '">
            <input id="pubID" name="pubID" type="text" class="form-control" required="required">
            <span id="pubIDHelpBlock" class="form-text text-muted mb-2">67 characters<br>Example: <i>1419b9d57f3da984-f66b595dbd15455c-5ed9679a1dee156f-6149a63357ee038d</i></span>
          </div>
        </div>
        <div class="form-group row">
          <div class="offset-4 col-8">
            <button name="submit" type="submit" class="btn btn-primary mt-3">Set</button>
            <span id="createpubIDblock" class="form-text text-muted mb-5"><br>Your account details will be reported to the authorities if you are selling highly inappropiate content. Please use common sense when using our marketplace.</span>

          </div>
        </div>
      </form>';
      ///

      ?>
    </div>
</div>
<div class="card mt-3">

</div>
</div>
</div>

<div class="tab-pane container fade <?php if ($tab === 'searchuser') {
          echo 'active show';
      } ?>" id="searchuser">
  <div class="row">
  <div class="col-lg-12" style="">
  <div class="card mx-left mt-2 mb-2" style="width: auto;">
    <div class="card mt-2">
      <div class="row mb-2">
    <div class="col-lg-3 ml-0 mr-0 px-1" style="">
    <form class method="post" action='/?tab=searchuser'>
<select name='userAmount' class="custom-select mr-1" onchange='this.form.submit();'>
<option value ='4'>Results</option>
 <option value='5' <?php if ($userAmount === '5') {
          echo " selected='selected'";
      } ?>>Last 5</option>
 <option value='10'<?php if ($userAmount === '10') {
          echo " selected='selected'";
      } ?>>Last 10</option>
 <option value='25'<?php if ($userAmount === '25') {
          echo " selected='selected'";
      } ?>>Last 25</option>
 <option value='50'<?php if ($userAmount === '50') {
          echo " selected='selected'";
      } ?>>Last 50</option>
</select></div>
<div class="col-lg-3 ml-0 mr-0 px-1" style="">
  <select class= "custom-select mr-1" name='userSort' onchange='this.form.submit();'>
  <option value='DESC'>Sort results</option>
  <option value='DESC'<?php if ($userSort === 'DESC') {
          echo " selected='selected'";
      } ?>>Newest first</option>
  <option value='ASC'<?php if ($userSort === 'ASC') {
          echo " selected='selected'";
      } ?>>Oldest first</option>
</select></form></div>
</div>
<div class="card mt-3">
<?php
$filter_value = $searchUser;
$values_needed = array("message_type", "user_name", "user_id", "user_positive_fb", "user_negative_fb");
getValue('select', $values_needed, 'ALL', 'users', 'user_name', $filter_value, 'user_name', $userSort, $userAmount, 'none');
  ?>
</div>
</div></div>
</div>
</div>
</div>


<div class="tab-pane container fade <?php if ($tab === 'searchproduct') {
      echo 'active show';
  } ?>" id="searchproduct">
  <div class="row">
  <div class="col-lg-12" style="">
  <div class="card mx-left mt-2 mb-2" style="width: auto;">
    <div class="card mt-2">
      <div class="row mb-2">
    <div class="col-lg-3 ml-0 mr-0 px-1" style="">
    <form class method="post" action='/?tab=searchproduct'>
<select name='searchProductAmount' class="custom-select mr-1" onchange='this.form.submit();'>
<option value ='4'>Results</option>
 <option value='5' <?php if ($searchProductAmount === '5') {
      echo " selected='selected'";
  } ?>>Last 5</option>
 <option value='50'<?php if ($searchProductAmount === '50') {
      echo " selected='selected'";
  } ?>>Last 50</option>
 <option value='100'<?php if ($searchProductAmount === '100') {
      echo " selected='selected'";
  } ?>>Last 100</option>
 <option value='250'<?php if ($searchProductAmount === '250') {
      echo " selected='selected'";
  } ?>>Last 250</option>
 <option value='500'<?php if ($searchProductAmount === '500') {
      echo " selected='selected'";
  } ?>>Last 500</option>
</select></div>
<div class="col-lg-3 ml-0 mr-0 px-1" style="">
  <select class= "custom-select mr-1" name='searchProductSort' onchange='this.form.submit();'>
  <option value='DESC'>Sort results</option>
  <option value='DESC'<?php if ($searchProductSort === 'DESC') {
      echo " selected='selected'";
  } ?>>Newest first</option>
  <option value='ASC'<?php if ($searchProductSort === 'ASC') {
      echo " selected='selected'";
  } ?>>Oldest first</option>
</select></form></div>
</div>
<div class="card mt-3">
<?php
$filter_value = $searchProduct;
$values_needed = array("message_type", "timestamp", "product_id", "product_name", "product_description", "product_price", "product_type", "amount_left", "user_name");
getValue('select', $values_needed, 'ALL', 'products', 'product_name', $filter_value, 'timestamp', $searchProductSort, $searchProductAmount, 'none');

  ?>
</div>
</div></div>
</div>
</div>
</div>


<?php include 'footer.php'; ?>


  </body>

</html>
