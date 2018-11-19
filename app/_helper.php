<?php

function helper_getCredsAfterIdVerification($idToken)
{
    require_once '_credentials.php';
    require_once '../external/google-api-php-client/vendor/autoload.php';

    $client = new Google_Client(['client_id'=> $CLIENT_ID]);
    $payload = $client->verifyIdToken($idToken);
    if($payload) {
        return $payload;
        /*
        keys that can be accessed in payload:
        ["iss"]
        ["azp"]
        ["aud"]
        ["sub"]
        ["email"]           <--- important
        ["email_verified"]
        ["name"]
        ["picture"]
        ["given_name"]
        ["family_name"]
        ["locale"]
        ["iat"]
        ["exp"]
        */
    } else {
        // not sure what to do here
        // implement some common error logic here.
        return false;
    }
}

?>