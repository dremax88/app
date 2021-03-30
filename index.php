<?php
require_once ('vendor/autoload.php');

use \classes\initialization;

$a=initialization::getInit($_REQUEST);

print_r($a);