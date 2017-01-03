<?php
require_once '../config.php';
require_once '../class/Discount.php';
require_once '../functions.php';

if ($_POST) {
    try {
        Discount::setConnection(HOST, USER, PASS, DB);
        if(empty($_POST['disName'])){
            echo fail("fail");
        }elseif(Discount::isUsed($_POST['disName']) == 0){
            echo success("success");
        }else{
            echo fail("fail");
        }
    } catch (Exception $ex) {
        echo fail($ex->getMessage());
    }
}
