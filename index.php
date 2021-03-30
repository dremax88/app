<?php
require_once ('vendor/autoload.php');

use \classes\initialization;

$a=initialization::getInit();
$a=$a::parseArr($_REQUEST);
var_dump($a);