<?php
session_start();
require_once '../config.php';
require_once '../class/Class.Validate.php';
require_once '../class/Admin.php';
require_once '../class/Customer.php';
require_once '../class/Discount.php';
require_once '../functions.php';


if(isset($_SESSION['admin'])){
//   $admin = new Admin(" ", "");
   $admin = unserialize($_SESSION['admin']);
   if($admin->isAdmin()){
       
   }  else {
       $_SESSION['error'] = "admin record was not found";
       redirect("login.php");
   }
}else{
    redirect("login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon --> 
        <link rel="shortcut icon" href="">
        <link rel="apple-touch-icon" href="">

        <title>Creative Bakers</title>

        <!-- Bootstrap -->
        <link href="../external/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="../external/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- jVectorMap -->
        <link href="../css/maps/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
        <!-- Datatables -->
        <link href="../external/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="../external/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="../external/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="../external/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="../external/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> 
        <!-- Custom Theme Style -->
        <link href="../css/custom.css" rel="stylesheet">
        <!--JQuery UI-->
        <link href="../css/jquery-ui.css" rel="stylesheet">
    </head>
