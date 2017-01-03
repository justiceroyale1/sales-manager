<?php
session_start();
require_once '../config.php';
require_once '../class/Product.php';
require_once '../functions.php';

if (isset($_POST)) {
    try {
        Product::setConnection(HOST, USER, PASS, DB);
        $prd = new Product($_POST["prdName"]);
        $prd->setPrdPrice($_POST["prdPrice"]);
        $prd->setPrdCOP($_POST["prdCOP"]);
        $prd->setPrdProfit();
        if (isset($_FILES['prdImage']) && !empty($_FILES['prdImage'])) {
            $size = $_FILES['prdImage']['size'];
            if ($size > 1000000) {
                throw new Exception("The image file selected is too large");
            } else {
                $time = date('hms');
                $filename = $_FILES['prdImage']['tmp_name'];
                $path = "prd/$time" . $_FILES['prdImage']['name'];
                move_uploaded_file($filename, "../$path");
            }
        } else {
            $path = "";
        }
        $prd->setPrdImage($path);
        $prd->setDescription($_POST["prdDescription"]);
        $prd->setTimestamp(date("Y-m-d h:m:s"));
        $prd->save();
        $_SESSION['success'] = "New product added";
        redirect("setup.php#prd_dialog");
    } catch (Exception $exc) {
        $_SESSION['error'] = $exc->getMessage();
        head_redirect("setup.php#prd_dialog");
    }
}