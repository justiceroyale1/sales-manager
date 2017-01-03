<?php

session_start();
require_once '../config.php';
require_once '../class/Discount.php';
require_once '../functions.php';

if (isset($_POST)) {
    try {
        Discount::setConnection(HOST, USER, PASS, DB);
        $dis = new Discount($_POST["disName"]);
        $dis->setDiscountTypeId($_POST["disType"]);
        $dis->setNumOfPrd($_POST["disAmount"]); // qty of products to buy to qualify for discount
        $dis->setDiscount($_POST["discount"]);
        if (empty($_POST["start"])) {
            $dis->setStartTimestamp("0000-00-00 00:00:00");
        } else {
            $dis->setStartTimestamp($_POST["start"] . " 00:00:00");
        }
        if (empty($_POST["end"])) {
            $dis->setEndTimestamp("0000-00-00 00:00:00");
        } else {
            $dis->setEndTimestamp($_POST["end"] . " 00:00:00");
        }
        $dis->save();
        $_SESSION['success'] = "New discount added";
        redirect("discount.php#discount_dialog");
    } catch (Exception $exc) {
        $_SESSION['error'] = $exc->getMessage();
        head_redirect("discount.php#discount_dialog");
    }
}