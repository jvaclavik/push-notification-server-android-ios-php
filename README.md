PHP Push notification server for Android and iOS devices
========================================================

Simple library to send push notifications to Android and iOS devices

Fork from: https://github.com/gonzalo123/androidpusher

Installation
------------

require original package:
```sh
$ composer require gonzalo123/androidpusher
```

override package repository in `composer.json`:
```json
# ...
"repositories": [
    {
        "url": "https://github.com/jvaclavik/push-notification-server-android-ios-php.git",
        "type": "git"
    }
],
"require": {
    "gonzalo123/androidpusher": "dev-master",
# ...
```


Usage
-----

Prepare your message and API keys
```php
$title = "Title";
$message = "Hello!";
$androidDeviceToken = "APA91bEArdlAAMqGrcXtxWYZFue30fSVKiVSVqnXiCyK2AI2ZBTHclI-biWJShtDWi0lmwNTkB6fCPWvvDIcOYBIUbdvU9dPdNwWAeRwLxyE_gRP2FUdSGkB901wpA0_1pG0ikuTpTeeJKiIe2f2-z67hjUlhlv97D2dRdZq-3gmr2soXlkzs7gqYGzSHW8k62_WRFpkkOpM";
$iOSDeviceToken = '3b24e2b4ed3e92e59428eeadab2cee972d6aa14184b133fad09d48e62a3d48b6';
$iOSPassphrase = 'pass';
$androidApiKey = "AIzaSyAkBcScJJ_MWswDRYm7y_qptno-KuwKo65";
```

Android pusher for Google Cloud Messaging (deprecated)
```php
$androidPusher = new AndroidPusher\Pusher($androidApiKey);
$androidPusher->notify($androidDeviceToken, [
    "message" => $message,
    "title" => $title,
]);
```

Android pusher for Firebase Cloud Messaging
```php
$androidPusher = new AndroidPusher\Pusher($androidApiKey, null, true);
$androidPusher->notify($androidDeviceToken, [
    "message" => $message,
    "title" => $title,
]);
```

IOS Pusher
__You need store key for Apple certificate in root folder with name "ck.pem".__
```php
$iOSPusher = new iOSPusher\Pusher($iOSPassphrase);
$iOSPusher->notify($iOSDeviceToken, [
    "alert" => [
        "title" => $title,
        "body" => $message,
    ],
    "sound" => "default",
]);
```


Multiple push notifications (Android)
-------------------------------------
If you want to show more than one notification in your notification bar on Android you have to iterate parameter notId. Example:
```javascript

$androidPusher->notify($androidDeviceToken, [
    "message" => $message,
    "title" => $title,
    "notId" => 1
]);
$androidPusher->notify($androidDeviceToken, [
    "message" => $message2,
    "title" => $title2,
    "notId" => 2
]);
```

Sending push notifications to multiple recipients (Android)
-----------------------------------------------------------
```php
$androidDeviceTokens = [
    "APA91bEArdlAAMqGrcXtxWYZFue30fSVKiVSVqnXiCyK2AI2ZBTHclI-biWJShtDWi0lmwNTkB6fCPWvvDIcOYBIUbdvU9dPdNwWAeRwLxyE_gRP2FUdSGkB901wpA0_1pG0ikuTpTeeJKiIe2f2-z67hjUlhlv97D2dRdZq-3gmr2soXlkzs7gqYGzSHW8k62_WRFpkkOpM",
    "dhyK4kAjfNs:APA91bHZEY3xOY7VYYboHcSL-kiWcHC30kh8sZVyw0IPkxT7Wxh3xNuKIIEzGMEdqDH_BW-QGQ7yK-cf1z_5dnM9RU4RPQJwlOMlhhQ2_9hn-dIl3BTgAKQ-RkFJpOhwu9_AONzN_Wfm",
    # ...
]
$androidPusher->notify($androidDeviceTokens, [
    "message" => $message,
    "title" => $title,
]);
```