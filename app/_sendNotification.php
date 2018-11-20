<?php
require_once '../vendor/autoload.php';
require_once './_credentials.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

// This assumes that you have placed the Firebase credentials in the same directory
// as this PHP file.
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/admin/_credentials.json');

$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->create();

$messaging = $firebase->getMessaging();

$title = 'My Notification Title';
$body = 'My Notification Body';
$notification = Notification::fromArray([
    'title' => $title,
    'body' => $body
]);

$message = CloudMessage
    ::withTarget('token', $debugDeviceToken)
    ->withNotification($notification)
    ;

$messaging->send($message);

echo "heya";

?>