<?php

require_once '../vendor/autoload.php';
require_once './_credentials.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/admin/_credentials.json');

$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->create();

?>