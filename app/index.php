<?php 
require_once '../external/google-api-php-client/vendor/autoload.php';
require_once './_helper.php';
require_once '../users/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "hi";
} 
// else ($_SERVER['REQUEST_METHOD'] === 'POST') {
else {
    $post = file_get_contents('php://input');
    $post = json_decode($post, true);
    var_dump($post);
    $idToken = $post['idToken'];
    $fcmToken = $post['fcmToken'];
    $creds = helper_getCredsAfterIdVerification($idToken);
    if(!$creds) {
        echo "FAIL";
        return;
    }
    $email = $creds['email'];
    // now check if this email exists in thalilist
    // if yes, send OK to client, login has succeeded from faiz side
    $query = "SELECT * FROM `thalilist` WHERE email_ID = '$email'";
    $result = mysqli_query($link, $query);
    if(!$result) {
        echo "FAIL";
        return;
    }
    $row = mysqli_fetch_array($result);
    // now we have got the user's information from our database
    $query = "select * from appUser where email_id = '$email'";
    $result = mysqli_query($link, $query);
    $result = mysqli_fetch_array($result);
    if($result) {
        // update it
        $query = "update appUser set fcm_token = '$fcmToken' where email_id='$email'";
    } else {
        // create an entry
        $query = "insert into appUser (email_id, fcm_token) values ('$email', '$fcmToken')";
    }
    $result = mysqli_query($link, $query);
    
    echo "PASS";
}
?>