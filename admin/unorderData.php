<?php
session_start();
require_once '../config.php';
require_once '../class/Order.php';
require_once '../functions.php';

if (isset($_POST)) {
    if (isset($_SESSION['user'])) {
//   $user = new Customer("", "");
        $user = unserialize($_SESSION['user']);
    } else {
        redirect("../index.php");
    }
    try {
        Order::setConnection(HOST, USER, PASS, DB);
        Order::getUndeliveredOrders($_POST['start'], $_POST['length'], $_POST['order'][0]['dir'], $_POST['draw']);
    } catch (Exception $exc) {
        echo fail($exc->getMessage());
    }
}