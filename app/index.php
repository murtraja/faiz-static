<?php 
require_once '../external/google-api-php-client/vendor/autoload.php';
//print_r($_SERVER);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "hi";
} 
// else ($_SERVER['REQUEST_METHOD'] === 'POST') {
else {
    //$request = json_decode($_REQUEST[0]);
    // $a = array("34", "23", "234");
    // var_dump($a);
    // var_dump($_REQUEST);
    // var_dump($_REQUEST[0]);
    // $idToken = $request['idToken'];
    // $data = array("token" => $idToken);
    // echo(json_encode($data));
    $post = file_get_contents('php://input');
    $post = json_decode($post, true);
    $idToken = $post['idToken'];
    $CLIENT_ID = '1078083950140-jhaqi6u7n3avctus3ao5vtv5oo58nmla.apps.googleusercontent.com';
    $client = new Google_Client(['client_id'=> $CLIENT_ID]);
    $payload = $client->verifyIdToken($idToken);
    if($payload) {
        $userid = $payload['sub'];
        echo "SUCCESS";
    } else {
        echo "FAIL";
    }
    // echo(json_encode($_REQUEST));
}
?>