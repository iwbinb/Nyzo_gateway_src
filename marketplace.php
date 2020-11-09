<?php
include 'header.php';
require_once("alerts.php");

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

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $productSort = 'DESC';
    $productAmount = '9';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $productAmount = test_input($_POST["productAmount"]);
        $productSort = test_input($_POST["productSort"]);
        if (filter_var($productAmount, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Not an INT');
        }
        if ($productAmount > 100) {
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
        $productAmount = '9';
        $productSort = 'DESC';
    }
}

// echo $productAmount;
// echo $productSort;
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
<a class="nav-link active" data-toggle="tab" href="#marketplace">Marketplace</a>
</li>
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#network">Network</a>
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
<div class="tab-pane container active" id="marketplace" style="overflow:hidden;">
<div class="row">
<div class="col-lg-12" style="">
<div class="card mx-left mt-2 mb-2" style="width: auto;">
  <div class="card mt-2">
    <div class="row mb-2">
  <div class="col-lg-3 ml-0 mr-0 px-1" style="">
  <form class method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
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

<div class="tab-pane container" id="network" style="overflow:hidden;">
<div class="row">
<div class="col-lg-12" style="">
<div class="card mx-left mt-2 mb-2" style="width: auto;">
  <div class="card mt-2">
<div class="row">

  <!------>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://code.highcharts.com/stock/highstock.js"></script>
  <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
<div id="container-analysis" style="height: 400px; min-width: 310px"></div>
<script>

function yyyymmdd() {
    var x = new Date();
    var y = x.getFullYear().toString();
    var m = (x.getMonth() + 1).toString();
    var d = x.getDate().toString();
    (d.length == 1) && (d = '0' + d);
    (m.length == 1) && (m = '0' + m);
    var yyyymmdd = y + m + d;
    return y + '-' + m + '-' + d;
}

var seriesOptions = [],
  seriesCounter = 0,
  names = ['ANT'],
  analysis_type = 'fcas';


/**
 * Create the chart when all data is loaded
 * @returns {undefined}
 */
function createChart() {

  Highcharts.stockChart('container-analysis', {

    rangeSelector: {
      selected: 4
    },

    yAxis: {
      labels: {
        formatter: function () {
          return (this.value > 0 ? ' + ' : '') + this.value + '%';
        }
      },
      plotLines: [{
        value: 0,
        width: 2,
        color: 'silver'
      }]
    },

    plotOptions: {
      series: {
        compare: 'percent',
        showInNavigator: true
      }
    },

    tooltip: {
      pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
      valueDecimals: 2,
      split: true
    },

    series: seriesOptions
  });
}

$.each(names, function (i, name) {
  // $.getJSON('json/' + yyyymmdd(); + name.toLowerCase() + '-c.json',  function (data) {
  $.getJSON('json/' + yyyymmdd(); + '-history-' + name + '-' + analysis_type + '.json',  function (data) {

    seriesOptions[i] = {
      name: name,
      data: data
    };

    // As we're loading the data asynchronously, we don't know what order it will arrive. So
    // we keep a counter and create the chart when all the data is loaded.
    seriesCounter += 1;

    if (seriesCounter === names.length) {
      createChart();
    }
  });
});
</script>

  <!------>

</div>
</div></div>
</div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>
  </body>

</html>
