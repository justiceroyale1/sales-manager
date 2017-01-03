<?php

session_start();
require_once '../config.php';
require_once '../class/PromoCode.php';
require_once '../functions.php';

if (isset($_POST)) {
    try {
        PromoCode::setConnection(HOST, USER, PASS, DB);
        $dis = new PromoCode(" ");
        $dis->setNumToGen($_POST["promoAmount"]);// qty of products to buy to qualify for discount
        $dis->setDiscountTypeId(2);
        $dis->setMinDiscount($_POST["promoMin"]); 
        $dis->setMaxDiscount($_POST["promoMax"]);
        $dis->save();
        $_SESSION['success'] = "New promo code added";
        redirect("promo.php#promo_dialog");
    } catch (Exception $exc) {
        $_SESSION['error'] = $exc->getMessage();
        head_redirect("promo.php#promo_dialog");
    }
}