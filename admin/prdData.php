<?php
require_once '../config.php';
require_once '../class/Product.php';
require_once '../functions.php';

if(isset($_POST)){
    try {
        Product::setConnection(HOST, USER, PASS, DB);
        Product::getProducts($_POST['start'],$_POST['length'],$_POST['order'][0]['dir'],$_POST['draw']);
    } catch (Exception $exc) {
        echo fail($exc->getMessage());
    }

}