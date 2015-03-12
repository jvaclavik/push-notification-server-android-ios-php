<?php

include __DIR__ . "/vendor/autoload.php";

$title = 'Title';
$message = 'Hello!';

$androidDeviceToken = "APA91bEArdlFJMqGrcXtxWYZFue30fSVKiVSVqnXiCyK2AI2ZBTHclI-biWJShtDWi0lmwNTkB6fCPWvvDIcOYBIUbdvU9dPdNwWAeRwLxyE_gRP2FUdSGkB901wpA0_1pG0ikuTpTeeJKiIe2f2-z67hjUlhlv97D2dRdZq-3gmr2soXlkzs7gqYGzSHW8k62_WRFpkkOpM";

$iOSDeviceToken = '3b24e2b4ed3e92e59428eeadab2cee972d6cd44184b133fad09d48e62a3d48a6';
$iOSPassphrase = 'krava';
$androidApiKey = "AIzaSyAkBcScJJ_MWswDRYm7y_qptno-KuWKo14";




// Android pusher

$androidPusher = new AndroidPusher\Pusher($androidApiKey);
$androidPusher->notify($androidDeviceToken, array("message"=> $message, "title"=> $title));
//
//print_r($androidPusher->getOutputAsArray());





// iOS pusher

$iOSPusher = new iOSPusher\Pusher($iOSPassphrase);
$iOSPusher->notify($iOSDeviceToken, array(
    'alert' => array(
        "title" => $title,
        "body" => $message
    ),
    'sound' => 'default'
));

//print_r($iOSPusher->getOutputAsArray());