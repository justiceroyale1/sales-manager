<?php
require_once '../config.php';
require_once '../class/PromoCode.php';
require_once '../functions.php';

if(isset($_POST)){
    try {
        PromoCode::setConnection(HOST, USER, PASS, DB);
        PromoCode::getPromoCodes($_POST['start'],$_POST['length'],$_POST['order'][0]['dir'],$_POST['draw']);
    } catch (Exception $exc) {
        echo fail($exc->getMessage());
    }

}