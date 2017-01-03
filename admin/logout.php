<?php
session_start();
if(session_destroy()){
    setcookie(session_name(), "", time() - 3600, "/", "", "", TRUE);
    
    header("Location: login.php");
}