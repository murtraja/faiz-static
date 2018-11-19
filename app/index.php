<?php 
require_once '../external/google-api-php-client/vendor/autoload.php';
require_once './_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "hi";
} 
// else ($_SERVER['REQUEST_METHOD'] === 'POST') {
else {
    $post = file_get_contents('php://input');
    $post = json_decode($post, true);
    $idToken = $post['idToken'];
    $creds = helper_getCredsAfterIdVerification($idToken);
    if($creds) {
        $email = $creds['email'];
        // now check if this email exists in thalilist
        // if yes, send OK to client, login has succeeded from faiz side
    } else {
        echo "FAIL";
    }
    // echo(json_encode($_REQUEST));
}
?>