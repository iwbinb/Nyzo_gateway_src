<!DOCTYPE html>
<html lang="en">

<?php
include 'statics.php';
date_default_timezone_set("America/Curacao");
?>

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nyzo Payment Gateway</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">


  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <a class="navbar-brand mr-1" href="/"><?php echo $title ?></a>

    <!--  <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button> -->

      <!-- Navbar -->
      <!-- <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
              <!-- IF NOT LOGGED IN -->
              <!-- <li class="nav-item">
              <a class="btn btn-primary" href="createproduct" style="">Create a product</a>
              </li>
              <li class="nav-item" id="loginButton">
              <a class="btn btn-primary" href="login"> Login</a>
              </li> <!-- nav link -->
              <!-- <li class="nav-item" id="registerButton">
              <a class="btn btn-primary" style="margin-left: 5px;" href="register">Register</a>
              </li> -->
    <!-- IF NOT LOGGED IN -->
    <!-- IF LOGGED IN -->


      <!-- </ul> -->

      <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">

              <!-- <li class="nav-item" id="loginButton">
              <a class="btn btn-primary" href="login.php"> Login</a>
              </li> -->
<!--
              <li class="nav-item">
              <a class="btn btn-primary" href="createproduct" style="">Create a product</a>
            </li> -->
              <li class="nav-item" id="loginButton">
              <a class="btn btn-primary" style="margin-left: 10px;" href="login"> Login</a>
              </li>
              <li class="nav-item" id="registerButton">
              <a class="btn btn-primary" style="margin-left: 5px;" href="register">Register</a>
              </li>



      </ul>

    </nav>

        <div id="wrapper">
