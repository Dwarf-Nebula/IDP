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
function getCustomersInAllLocations($db){
    $result = $db->query('SELECT `aanmeldingid` FROM `aanmeldingen` LEFT JOIN `klanten` ON aanmeldingen.klantnummer = klanten.klantnummer WHERE aanmeldingen.eindtijd IS NULL AND klanten.accounttype = "klant"');
    return $result->rows();
}

function getAllLocations($db){
    $result = $db->query('SELECT * FROM `filialen`')->fetch_all();
    return $result;
}

function getAmmountOfLocations($db){
    $result = $db->query('SELECT * FROM `filialen`');
    return $result->rows();
}
function getAmmountOfSportsEquipment($db){
    $result = $db->query('SELECT * FROM `apparaten`');
    return $result->rows();
}

function getAmmountOfSportsEquipmentPerLocation($db,$locationid){
    $result = $db->query('SELECT * FROM `apparaten` WHERE `filiaalnummer` = '.$locationid);
    return $result->rows();
}
function getVisitsByDay($db, $date,$id){
    $dateformat = date('Y-m-d',strtotime($date));
    $result = $db->query('SELECT * FROM `aanmeldingen` WHERE `klantnummer` = '.$id.' AND `begintijd` LIKE "'.$dateformat.'%"');
    return $result->rows();
}

function getChartinfoByCustomerId($db, $time, $customerid){
    $now = date('Y-m-d H:i:s');
    $result = $db->query("SELECT * FROM `apparaattypes`")->fetch_all();
    $data = array();
    if (!isset($data['devices'])){ // notice destroyer
        $data['devices'] = null;
    }
    foreach ($result as $row){
        $data['devices'][$row['apparaattypeid']] = 0;
    }
    switch($time){
        case 'week':
            $begintime = date('Y-m-d H:i:s',strtotime('-1 week'));
            $dates = getLastNDays(7,'d-m-Y');
            $result = $db->query("SELECT * FROM `sportactiviteiten` AS sa
                                      LEFT JOIN apparaten AS app ON sa.apparaatid = app.apparaatid
                                      LEFT JOIN apparaattypes AS appt ON app.apparaattypeid = appt.apparaattypeid
                                      WHERE sa.eindtijd IS NOT NULL AND sa.klantnummer = ".$customerid." AND sa.begintijd BETWEEN '".$begintime."' AND  '".$now."'")->fetch_all();
            break;
        case 'month':
            $begintime = date('Y-m-d H:i:s',strtotime('-1 month'));
            $dates = getLastNDays(31,'d-m-Y');
            $result = $db->query("SELECT * FROM `sportactiviteiten` AS sa
                                      LEFT JOIN apparaten AS app ON sa.apparaatid = app.apparaatid
                                      LEFT JOIN apparaattypes AS appt ON app.apparaattypeid = appt.apparaattypeid
                                      WHERE sa.eindtijd IS NOT NULL AND sa.klantnummer = ".$customerid." AND sa.begintijd BETWEEN '".$begintime."' AND  '".$now."'")->fetch_all();
            break;
        case 'all':
            $now = time();
            $result = $db->query('SELECT `begintijd` FROM `sportactiviteiten` ORDER BY `begintijd` LIMIT 1')->fetch_assoc();
            $firstdate = strtotime($result['begintijd']);
            $datediff = $now - $firstdate;
            $days = round($datediff / (60 * 60 * 24));
            $dates = getLastNDays($days,'d-m-Y');
            $result = $db->query("SELECT * FROM `sportactiviteiten` AS sa
                                      LEFT JOIN apparaten AS app ON sa.apparaatid = app.apparaatid
                                      LEFT JOIN apparaattypes AS appt ON app.apparaattypeid = appt.apparaattypeid
                                      WHERE sa.eindtijd IS NOT NULL AND sa.klantnummer = ".$customerid)->fetch_All();

            break;
        default:
            return 'Invalid time supplied';
            break;

    }
    if (!empty($result)){

        $i = 0;

        foreach ($dates as $date){
            if (!isset($data['visits'][ $i])){ // notice destroyer
                $data['visits'][ $i] = 0;
            }
            if (!isset($data['calories'][ $i])){ // notice destroyer
                $data['calories'][$i] = 0;
            }
            if (!isset($data['visits'])){ // notice destroyer
                $data['visits'] = null;
            }
            if (!isset($data['calories'])){ // notice destroyer
                $data['calories'] = null;
            }
            $i++;
        }
        foreach ($result as $row){
            $datediff = strtotime($row['eindtijd']) - strtotime($row['begintijd']);
            $minutesspend = round($datediff / (60));
            $caloriePerMinute = round($row['calorienperuur'] / 60,1);
            $calories = round(($caloriePerMinute * $minutesspend)/ 100,2) ;
            $newStartDate = date('d-m-Y', strtotime($row['begintijd']));
            $datekey = array_search($newStartDate,$dates);

            $data['devices'][$row['apparaattypeid']] += 1;
            $data['visits'][$datekey] = getVisitsByDay($db, $newStartDate, $customerid);
            $data['calories'][$datekey] += $calories;
        }
        if (!empty($data)){
            return $data;
        }
    }
}
function getLastNDays($days, $format = 'Y-m-d'){
    $dateArray = array();
    for($i=0; $i<=$days-1; $i++){
        $dateArray[] =  date($format, strtotime('-'.$i.'day'));
    }
    return array_reverse($dateArray);
}