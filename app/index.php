<?php 
//require_once '../external/google-api-php-client/vendor/autoload.php';
//print_r($_SERVER);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "hi";
} 
// else ($_SERVER['REQUEST_METHOD'] === 'POST') {
else {
    $data = array("token" => "34234lakskqr432l");
    echo(json_encode($data));
}
?>