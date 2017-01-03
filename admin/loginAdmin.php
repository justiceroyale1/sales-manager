<?php
session_start();
require_once '../config.php';
require_once '../class/Admin.php';
require_once '../functions.php';

if (isset($_POST)) {
    try {
        Admin::setConnection(HOST, USER, PASS, DB);
        $user = new Admin(" ", "");
        $user->setLoginUsername($_POST['username']);
        $user->setPassword($_POST['password']);
        $user->load();
        $_SESSION['admin'] = serialize($user);
        head_redirect("index.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = $exc->getMessage();
        head_redirect("login.php");
    }
}
