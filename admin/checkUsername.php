<?php
require_once '../config.php';
require_once '../class/Admin.php';
require_once '../functions.php';

if ($_POST) {
    try {
        Admin::setConnection(HOST, USER, PASS, DB);
        if(empty($_POST['username'])){
            echo fail("fail");
        }
        elseif(Admin::isUsed($_POST['username']) == 0){
            echo success("success");
        }else{
            echo fail("fail");
        }
    } catch (Exception $ex) {
        echo fail($ex->getMessage());
    }
}
