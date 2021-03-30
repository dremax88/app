<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once ($_SERVER["DOCUMENT_ROOT"].'/app/vendor/autoload.php');

use \classes\initialization;
use Bitrix\Main\Loader;

$a=initialization::getInit();
$a=$a::parseArr($_REQUEST);
print_r($_REQUEST);
var_dump($a);