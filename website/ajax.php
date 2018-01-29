<?php
include "functions.php";
if (!empty($_POST)){
    $action = $_POST['actionName'];
    switch ($action){
        case 'weekchart':
            echo json_encode(weekChart($db,$_POST['id']));
            break;
        case'monthchart':
            echo json_encode(monthChart($db,$_POST['id']));
            break;
        case'allchart':
            echo json_encode(allChart($db,$_POST['id']));
            break;
        default:
            break;
    }
}

function weekChart($db,$id){
    $result = $db->query("SELECT * FROM `apparaattypes`")->fetch_all();
    $data = array();
    foreach ($result as $row){
        $data[] = $row['apparaatsoort'];
    }
    $array['devicetypes'] = $data;
    $dates = getLastNDays(7,'d-m-Y');
    $array['dates'] = $dates;
    $array['data'] = getChartinfoByCustomerId($db,'week',$id);
    return json_encode($array);
}
function monthChart($db,$id){
    $result = $db->query("SELECT * FROM `apparaattypes`")->fetch_all();
    $data = array();
    foreach ($result as $row){
        $data[] = $row['apparaatsoort'];
    }
    $array['devicetypes'] = $data;
    $dates = getLastNDays(31,'d-m-Y');
    $array['dates'] = $dates;
    $array['data'] = getChartinfoByCustomerId($db,'month',$id);
    return json_encode($array);
}
function allChart($db,$id){
    $result = $db->query("SELECT * FROM `apparaattypes`")->fetch_all();
    $data = array();
    foreach ($result as $row){
        $data[] = $row['apparaatsoort'];
    }
    $array['devicetypes'] = $data;
//    dear gods save me
    $now = time();
    $result = $db->query('SELECT `begintijd` FROM `sportactiviteiten` ORDER BY `begintijd` LIMIT 1')->fetch_assoc();
    $firstdate = strtotime($result['begintijd']);
    $datediff = $now - $firstdate;
    $days = round($datediff / (60 * 60 * 24));
    $dates = getLastNDays($days,'d-m-Y');
    $array['dates'] = $dates;
    $array['data'] = getChartinfoByCustomerId($db,'all',$id);
    return json_encode($array);
}