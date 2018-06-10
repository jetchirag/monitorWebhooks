<?php
/*
*   Usage: URL?key=$key
*/

error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $key = "blahblahblah";
    
    $accessCode = '';
    
    if (!isset($_GET["key"]) || $_GET["key"] != $key){
        exit("Unauthorised");
    }
    
    $content = trim(file_get_contents("php://input"));

    $monitorData = json_decode($content, true);

    if(!is_array($monitorData)){
        exit("Invalid json");
    }
    
    if ($monitorData['monitor_status'] == 'offline') {
        $message = 'Your monitor ' . $monitorData['monitor_name'] . 'is offline. Error code:' . array_values($monitorData['monitor_errors'])[0];
    }
    else {
        $message = 'Your monitor ' . $monitorData['monitor_name'] . 'is now back up online';
    }
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://api.notifymyecho.com/v1/NotifyMe");
    curl_setopt($ch, CURLOPT_POST, true);

    $postdata = json_encode(array('notification' => $message,
                                        'accessCode' => $accessCode));

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_exec ($ch);
    curl_close ($ch);
    
}
?>
