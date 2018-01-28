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
//show this years stats ( times entered)(minutes trained)(calories burned)


//returns the ammount of active customers
function getActiveCustomers($db){
    $result = $db->query('SELECT `klantnummer` FROM `klanten` WHERE `actief` = 1');
    return $result->rows();
}
//Returns ammount of customers inside each location at that moment
function getCustomersInLocation($db,$locationid){
    $result = $db->query('SELECT `aanmeldingid` FROM `aanmeldingen` LEFT JOIN `klanten` ON aanmeldingen.klantnummer = klanten.klantnummer WHERE aanmeldingen.filiaalnummer = '.$locationid.'AND aanmeldingen.eindtijd IS NULL AND klanten.accounttype = "klant"');
    return $result->rows();
}

function getAllLocations(){

}
