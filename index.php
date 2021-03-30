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
function processGetInfo($userID, $typeLink, $initialization){

    $arrLink=$initialization::generateUfLink($userID, $typeLink);
    $fields = [$typeLink => $arrLink[$typeLink]];
    $user = new CUser;
    $user->Update($userID, $fields);
    $arrForJson=[
        'status'=>'OK',
        'request_url'=>$arrLink['link']
    ];
    return $arrForJson;

}

//запуск патерна одиночки для инициализации соединения и получения данных с проверкой Api-key
$initialization=initialization::getInit();
$arrInfo=$initialization::parseArr(61, $_REQUEST, $userID, 'UF_KEY');

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
switch ($_REQUEST['type_reg']){

    case 'negative':
        $typeLink='UF_LINK';
        $arrForJson=processGetInfo($userID,$typeLink,$initialization);
        break;

    case 'personal':
        echo $typeLink='UF_SOTR_LINK';
        $arrForJson=processGetInfo($userID,$typeLink,$initialization);
        break;

    case 'advanced':
        $typeLink='UF_KADRSH';
        $arrForJson=processGetInfo($userID,$typeLink,$initialization);
        break;

    default:
        $arrForJson=false;
        break;

}

//В случае успеха вывели json-ответ
if($arrForJson!==false)
{
    $arrForJson=json_encode($arrForJson);
    CIBlockElement::SetPropertyValueCode($idUnit, "JsonParam", $arrForJson);
    echo $arrForJson;
}
else
{
    echo 'Error';
}

echo 'test';