<?php
global $USER;

// id пользователя компании

$userID=1112;

// автоподгрузка библиотек

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once ($_SERVER["DOCUMENT_ROOT"].'/app/vendor/autoload.php');

// подключение классов

use \classes\initialization;
use Bitrix;
use Bitrix\Main\Loader;

//подключение модулей

Loader::includeModule('iblock');

// функция-рефакторинг повторения в исполнительном скрипте

function processGetInfo($userID, $typeLink, $initialization, $status)
    {

        $arrLink=$initialization::generateUfLink($userID, $typeLink);
        $fields = [$typeLink => $arrLink[$typeLink]];
        $user = new CUser;
        $user->Update($userID, $fields);
        $arrParams['arrForJson']=[
            'status'        => $status,
            'request_url'   =>$arrLink['link']
        ];
        $arrParams['link']=$arrLink['link'];
        $arrParams['status']=$status;
        return $arrParams;

    }

//запуск патерна одиночки для инициализации соединения и получения данных с проверкой Api-key

$initialization=initialization::getInit();
$arrInfo=$initialization::parseArr(61, $_REQUEST, $userID, 'UF_KEY');

switch ($arrInfo['PROPERTY_VALUES']['type_reg'])
{

    case 'negative':
        $typeLink='UF_LINK';
        break;

    case 'personal':
        echo $typeLink='UF_SOTR_LINK';
        break;

    case 'advanced':
        $typeLink='UF_KADRSH';
        break;

    default:
        $arrParams=false;
        break;
}

if ($arrParams===false){
    echo 'Error';
}

//Проверяем ссылку и применяем статус

$arSelect = ["ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*"];
$arFilter =
     [

         "IBLOCK_ID"         =>61,
         "=PROPERTY_id_h_reg" => $arrInfo['PROPERTY_VALUES']['id_h_reg'],
         "=PROPERTY_key"      => $arrInfo['PROPERTY_VALUES']['key']

     ];

$elem = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
while($arrEl = $elem->GetNextElement())
    {

         $arElement['FIELDS'] = $arrEl->GetFields();
         $arElement['PROPERTIES'] = $arrEl->GetProperties();

     }

$arrUserLnk=$initialization::getUserArr($userID,$typeLink);

$checkLink=array_search($arElement['PROPERTIES']['request_url']['VALUE'], $arrUserLnk['UF_LINK']);

if( $checkLink!==false )
    {
        $status='REQ';
    }
else
    {
        $status='OK';
    }

//скоплектовали массив и загрузили в инфоблок новый элемент

if($arrInfo)
{
    $el=new CIBlockElement;
    $idUnit=$el->add($arrInfo);
}
else
{
    echo 'Error';
}

// проверили тип анкеты сгенерировали ссылку, через функцию-рефактор
// 1) создали массив и загрузили в массив ссылок
// 2) на выходе создали json ответ подгрузили в соответсвующий элемент инфоблока

$arrParams=processGetInfo($userID,$typeLink,$initialization, $status);

//В случае успеха вывели json-ответ

if($arrParams!==false)
{
    $arrForJson=json_encode($arrParams['arrForJson']);
    CIBlockElement::SetPropertyValueCode($idUnit, "JsonParam", $arrForJson);
    CIBlockElement::SetPropertyValueCode($idUnit, "request_url", $arrParams['link']);
    CIBlockElement::SetPropertyValueCode($idUnit, "status", $arrParams['status']);
    echo $arrForJson;
}
else
{
    echo 'Error';
}
