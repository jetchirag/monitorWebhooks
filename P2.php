<?php
error_reporting(0);

$key = "blahblahblah";

$accessCode = '';

if (!isset($_GET["key"]) || $_GET["key"] != $key){
    exit("Unauthorised");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
    $content = trim(file_get_contents("php://input"));

    $monitorData = json_decode($content, true);

    if(!is_array($monitorData)){
        exit("Invalid json");
    }
    
    if ($monitorData['monitor_status'] == 'offline') {
        file_put_contents('value.txt',"offline");
    }
    else {
        file_put_contents('value.txt',"online");
    }
    
}
else {
    echo file_get_contents('value.txt');
}
?>
