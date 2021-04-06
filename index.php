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
use Bitrix\Main\Mail\Event;

//подключение модулей

Loader::includeModule('iblock');

// функция-рефакторинг повторения в исполнительном скрипте

function processGetInfo($userID, $typeLink, $initialization, $status)
    {

        $arrLink=$initialization::generateUfLink($userID, $typeLink);
        $fields = [$typeLink => $arrLink[$typeLink]];
        $user = new CUser;
        $user->Update($userID, $fields);
        $arrParams['arrForJson']=
            [
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
            throw new Exception('Error miss type link');
            break;
    }

//Проверяем ссылку и применяем статус

$arFilter =
     [

         "IBLOCK_ID"         =>61,
         "=PROPERTY_id_h_reg" => $arrInfo['PROPERTY_VALUES']['id_h_reg'],
         "=PROPERTY_key"      => $arrInfo['PROPERTY_VALUES']['key']

     ];

$elem = CIBlockElement::GetList([], $arFilter);
while($arrEl = $elem->GetNextElement())
    {
         $requestLink = $arrEl->GetProperties()['request_url']['VALUE'];
     }

$arrUserLnk=$initialization::UserArr($userID,$typeLink);

$checkLink=array_search($requestLink, $arrUserLnk['UF_LINK']);

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
        throw new Exception('Error Can`t construct $arrInfo');
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
        Event::sendImmediate(array(
            "EVENT_NAME" => "ANK_LINK",
            "LID" => "s2",
            "C_FIELDS" => array(
                "EMAIL" => $_REQUEST['email'],
                "LINK" => $arrParams['link']
            ),
        ));
        echo $arrForJson;
    }
else
    {
        throw new Exception('Error can`t get json request');
    }
