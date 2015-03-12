Simple library to send push notifications to Android and iOS devices

Fork from: https://github.com/gonzalo123/androidpusher

```php

// you need store key for Apple certificate in root folder with name "ck.pem". You can change it in lib/


$title = 'Title';
$message = 'Hello!';
$androidDeviceToken = "APA91bEArdlAAMqGrcXtxWYZFue30fSVKiVSVqnXiCyK2AI2ZBTHclI-biWJShtDWi0lmwNTkB6fCPWvvDIcOYBIUbdvU9dPdNwWAeRwLxyE_gRP2FUdSGkB901wpA0_1pG0ikuTpTeeJKiIe2f2-z67hjUlhlv97D2dRdZq-3gmr2soXlkzs7gqYGzSHW8k62_WRFpkkOpM";
$iOSDeviceToken = '3b24e2b4ed3e92e59428eeadab2cee972d6aa14184b133fad09d48e62a3d48b6';
$iOSPassphrase = 'pass';
$androidApiKey = "AIzaSyAkBcScJJ_MWswDRYm7y_qptno-KuwKo65";

// Android pusher
$androidPusher = new AndroidPusher\Pusher($androidApiKey);
$androidPusher->notify($androidDeviceToken, array(
    "message"=> $message, 
    "title"=> $title)
);

// iOS pusher
$iOSPusher = new iOSPusher\Pusher($iOSPassphrase);
$iOSPusher->notify($iOSDeviceToken, array(
    'alert' => array(
        "title" => $title,
        "body" => $message
    ),
    'sound' => 'default'
));
```