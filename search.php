<?php
include 'header.php';
require_once("alerts.php");

function test_input($data) {
  if (filter_var($data, FILTER_VALIDATE_INT) === false) {
    $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  }
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  $searchSort = 'DESC';
  $searchAmount = '9';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    $searchAmount = test_input($_POST["searchAmount"]);
    $searchSort = test_input($_POST["searchSort"]);
    if (filter_var($searchAmount, FILTER_VALIDATE_INT) === false) {
      throw new Exception('Not an INT');
    }
    if ($searchAmount > 100){
      throw new Exception('Out of range');
    } else {
      $searchAmount = $searchAmount;
    }
    if ($searchSort === 'DESC' | $searchSort === 'ASC'){
      $searchSort = $searchSort;
    } else {
      throw new Exception('Invalid sort method');
    }
  } catch(Exception $e) {
    // echo $e;
    $searchAmount = '9';
    $searchSort = 'DESC';
  }
}

// echo $searchAmount;
// echo $searchSort;
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

  .btn {
    width: -webkit-fill-available;
  }

</style>
<div class="container">

<ul class="nav nav-tabs mr-auto">
<li class="nav-item">
<a class="nav-link active" href="#search">Search results</a>
</li>
<!-- <li class="nav-item disabled">
<a class="nav-link disabled" href="register">Alerts</a>
</li>
<li class="nav-item disabled">
<a class="nav-link disabled" href="register">Payments</a>
</li>
<li class="nav-item disabled">
<a class="nav-link disabled" href="register">Products</a>
</li>
<li class="nav-item disabled">
<a class="nav-link disabled" href="register">Balance history</a>
</li> -->
</ul>

<div class="tab-content px-3" style="border: 1px solid #dee2e6;">
<div class="tab-pane container active" id="search" style="overflow:hidden;">
<div class="row">
<div class="col-lg-12" style="">
<div class="card mx-left mt-2 mb-2" style="width: auto;">
  <div class="card mt-2">
    <div class="row mb-2">
  <div class="col-lg-2 ml-0 mr-0 px-1" style="">
  <form class method="get" action='search'>
    <select class= "custom-select mr-1" name='searchAmount' required>
    <option value='9'<?php if($searchAmount === '9'){echo " selected='selected'";} ?>>Result amount</option>
    <option value='10'<?php if($searchAmount === '10'){echo " selected='selected'";} ?>>Last 10</option>
    <option value='20'<?php if($searchAmount === '20'){echo " selected='selected'";} ?>>Last 20</option>
    <option value='50'<?php if($searchAmount === '50'){echo " selected='selected'";} ?>>Last 50</option>
    <option value='75'<?php if($searchAmount === '75'){echo " selected='selected'";} ?>>Last 75</option>
    <option value='100'<?php if($searchAmount === '100'){echo " selected='selected'";} ?>>Last 100</option>
  </select></div>
  <div class="col-lg-2 ml-0 mr-0 px-1" style="">
    <select class= "custom-select mr-1" name='searchSort' required>
    <option value='ABC'><b>Sort results</b></option>
    <option value='ABC'<?php if($searchSort === 'ABC'){echo " selected='selected'";} ?>>Alphabetically</option>
    <option value='REP'<?php if($searchSort === 'REP'){echo " selected='selected'";} ?>>Reputation</option>
  </select></div>
  <div class="col-lg-3 mr-0 px-1" style="">
<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">@</span>
  </div>
  <input type="text" class="form-control mr-1" placeholder="Search user" name="searchUser">
</div>
</div><div class="col-lg-3 mr-0 px-1" style="">
<div class="input-group">
<div class="input-group-prepend">
  <span class="input-group-text" id="basic-addon1">≈</span>
</div>
<input type="text" class="form-control mr-1" placeholder="Search product" name="searchProduct">
</div></div><div class="col-lg-2 mr-0 px-1" style="">
<input type="submit" class="btn btn-secondary btn-block bg-secondary" style="color: #fff;" value="Submit" name="submit">
</form>
</div>
</div>
<div class="row">

  <?php
  $values_needed = array("message_type", "timestamp", "product_id", "product_type", "product_price", "product_name", "product_description", "amount_left", "user_name");
  $filter_value = '1';
  getValue('select', $values_needed, 'ALL', 'products', 'list_on_marketplace', $filter_value, 'timestamp', $searchSort, $searchAmount, 'none');
  ?>

</div>
</div></div>
</div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>
  </body>

</html>
