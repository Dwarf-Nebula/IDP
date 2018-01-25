<?php
include 'classes.php';
$db = new MySQL();
$db->connect('127.0.0.1','root','', 'benno', '3306');
$test = $db->query('SELECT * FROM `klanttabel`')->fetch_assoc();
$customer = Customer::getCustomerByCustomerId($db,1);
var_dump($test);