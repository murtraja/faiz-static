<?php
require './_firebase_connection.php';
$database = $firebase->getDatabase();

$userid = 12;
$notificationData = Array(
    'title' => "M3",
    'body' => "Salaam, Mubarak for earning sawab and participating in ...",
    'read' => false,
    'priority' => 'high',
    'timestamp' => 32477324
);
$nodePath = "notification/".$userid;
// $reference = 
//     $database->getReference()
//         -> update(Array(
//             $nodePath => $notificationData
//         ));

$notificationRef = $database->getReference($nodePath)->push($notificationData);

echo "heyaa";
?>