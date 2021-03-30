<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once ($_SERVER["DOCUMENT_ROOT"].'/app/vendor/autoload.php');

use \classes\initialization;
use Bitrix\Main\Loader;
use Bitrix\Iblock;
Loader::includeModule('iblock');

$a=initialization::getInit();
$a=$a::parseArr($_REQUEST);
var_dump($a);
$PROP = $_REQUEST;
$arInfo = [
    "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => 61,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST["lastname"].' '.$_REQUEST["firstname"].' '.$_REQUEST["surname"],
    "ACTIVE"         => "Y",            // активен
];
Iblock\ElementTable::add($arInfo);