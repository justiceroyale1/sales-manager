<?php
session_start();
require_once '../config.php';
require_once '../class/Admin.php';
require_once '../functions.php';

if(isset($_POST)){
    try {
        Admin::setConnection(HOST, USER, PASS, DB);
        $user = new Admin($_POST["surname"], $_POST["other_names"]);
        $user->setUsername($_POST["username"]);
        $user->setPassword($_POST["password"]);
        $user->setEmail($_POST["email"]);
        $user->setAddress($_POST["address"]);
        $user->setPhone($_POST["phone"]);
        $user->setPrivilegeId($_POST["priv"]);
        $user->save();
        $_SESSION['success'] = "New admin added";
        redirect("admins.php#admins_dialog");
    } catch (Exception $exc) {
         $_SESSION['error'] = $exc->getMessage();
         head_redirect("admins.php#admins_dialog");
    }
}