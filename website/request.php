<?php
include 'db.php';
$db = new MySQL();
$db->connect('127.0.0.1','root','', 'benno', '3306');

if (!empty($_POST)){ // check if post is set and not empty
    if (!empty($_POST('action'))){ // check if action is set and not empty
        $action = $_POST('action');// typing $_POST['action'] is annoying
        switch ($action){
            case 'checkin':
                if (!empty($_POST('customerid')) && !empty($_POST('locationid'))){
                    echo checkincustomer($db, $_POST('customerid'), $_POST('locationid'));
                }else{
                    echo 'missing data';
                }
                break;
            case 'checkout':
                if (!empty($_POST('customerid')) && !empty($_POST('locationid'))){
                    echo checkoutcustomer($db, $_POST('customerid'), $_POST('locationid'));
                }else{
                    echo 'missing data';
                }
                break;
            case 'activitystart':
                if (!empty($_POST('customerid')) && !empty($_POST('equipmentid'))){
                    echo activitystart($db, $_POST('customerid'), $_POST('equipmentid'));
                }else{
                    echo 'missing data';
                }
                break;
            case 'activitystop':
                if (!empty($_POST('customerid')) && !empty($_POST('equipmentid'))){
                    echo activitystop($db, $_POST('customerid'), $_POST('equipmentid'));
                }else{
                    echo 'missing data';
                }
                break;
            default:
                //geen bestaande case
                echo 'action does not exsist';
        }
    }else{

    }
}
function checkincustomer($db, $customerid, $locationid){
    $time = gettime();
    $query = $db->query('INSERT INTO `aanmeldingen`( `filiaalnummer`, `klantnummer`, `begintijd`) VALUES ('.$locationid.','.$customerid.',"'.$time.'")');
    $numrows = $query->rows();
    if ($numrows > 0){
        $result = 'succes';
    }else{
        $result = 'failure';
    }
    return $result;
}
function checkoutcustomer($db, $customerid, $locationid){
    $time = gettime();
    $query = $db->query();
    $numrows = $query->rows();
    if ($numrows > 0){
        $result = 'succes';
    }else{
        $result = 'failure';
    }
    return $result;
}
function activitystart($db, $customerid, $equipmentid){
    $time = gettime();
    $query = $db->query('INSERT INTO `sportactiviteiten`( `klantnummer`, `apparaatid`, `begintijd`) VALUES ('.$customerid.','.$equipmentid.',"'.$time.'")');
    $numrows = $query->rows();
    if ($numrows > 0){
        $result = 'succes';
    }else{
        $result = 'failure';
    }
    return $result;
}
function activitystop($db, $customerid, $equipmentid){
    $time = gettime();
    $query = $db->query('UPDATE `sportactiviteiten` SET `eindtijd`="'.$time.'" WHERE `klantnummer` = '.$customerid.' AND `apparaatid` = '.$equipmentid.' AND `eindtijd` = NULL ');
    $numrows = $query->rows();
    if ($numrows > 0){
        $result = 'succes';
    }else{
        $result = 'failure';
    }
    return $result;
}

function gettime(){
        return date('Y-m-d H:i:s'); // return current time in the database format
}