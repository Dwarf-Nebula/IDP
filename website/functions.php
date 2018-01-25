<?php
include 'classes.php';
session_start();
if (isset($_SESSION['customer'])){
    $currentCustomer = unserialize($_SESSION['customer']);
}else{

    if (basename($_SERVER['PHP_SELF']) != 'login.php'){
        header("Location: login.php?redirect=true");
        exit();
    }
}

function generatehash($password){
   $bytes = random_bytes(10);
   $salt = bin2hex($bytes);
   return crypt($password,$salt);
}