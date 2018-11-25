<?php
// require_once '../vendor/autoload.php';
require_once './_firebase_connection.php';

use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;

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