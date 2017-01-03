<?php
require_once '../config.php';
require_once '../class/Product.php';
require_once '../functions.php';

if ($_POST) {
    try {
        Product::setConnection(HOST, USER, PASS, DB);
        if(empty($_POST['prdName'])){
            echo fail("fail");
        }elseif(Product::isUsed($_POST['prdName']) == 0){
            echo success("success");
        }else{
            echo fail("fail");
        }
    } catch (Exception $ex) {
        echo fail($ex->getMessage());
    }
}
