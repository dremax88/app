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
        $arrForJson=[
            'status'        => $status,
            'request_url'   =>$arrLink['link']
        ];
        return $arrForJson;

    }

//запуск патерна одиночки для инициализации соединения и получения данных с проверкой Api-key
switch ($_REQUEST['type_reg'])
    {

        case 'negative':
            $typeLink='UF_LINK';
            break;

        case 'personal':
            $typeLink='UF_SOTR_LINK';
            break;

        case 'advanced':
            $typeLink='UF_KADRSH';
            break;

        default:
            $typeLink=false;
            break;
    }
if($typeLink)
    {
        $initialization=initialization::getInit();
        $arrInfo=$initialization::parseArr(61, $_REQUEST, $userID, $typeLink);

        $arSelect = ["ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*"];
        $arFilter =
            [
                "IBLOCK_ID"         =>61,
                "=PROPERTY_id_h_reg" => $arrInfo['PROPERTY_VALUES']['id_h_reg'],
                "=PROPERTY_key"      => $arrInfo['PROPERTY_VALUES']['key']
            ];

        $elem = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
        while($arrEl = $elem->GetNextElement()){

            $arElement['FIELDS'] = $arrEl->GetFields();
            $arElement['PROPERTIES'] = $arrEl->GetProperties();

        }
        echo '<pre>';
        print_r($arElement['PROPERTIES']['JsonParam']['VALUE']);
        echo '</pre>';

        $arrUserLnk=$initialization::getUserArr($userID,$typeLink);
        echo '<pre>';
        print_r($arrUserLnk);
        echo '</pre>';
    }
else
    {
       echo 'Error';
    }






////скоплектовали массив и загрузили в инфоблок новый элемент
//
//if($arrInfo)
//{
//    $el=new CIBlockElement;
//    $idUnit=$el->add($arrInfo);
//}
//else
//{
//    echo 'Error';
//}
//
//// проверили тип анкеты сгенерировали ссылку, через функцию-рефактор
//// 1) создали массив и загрузили в массив ссылок
//// 2) на выходе создали json ответ подгрузили в соответсвующий элемент инфоблока
//
//switch ($arrInfo['PROPERTY_VALUES']['type_reg'])
//    {
//
//        case 'negative':
//            $status='OK';
//            $typeLink='UF_LINK';
//            $arrForJson=processGetInfo($userID,$typeLink,$initialization, $status);
//            break;
//
//        case 'personal':
//            $status='OK';
//            echo $typeLink='UF_SOTR_LINK';
//            $arrForJson=processGetInfo($userID,$typeLink,$initialization,$status);
//            break;
//
//        case 'advanced':
//            $status='OK';
//            $typeLink='UF_KADRSH';
//            $arrForJson=processGetInfo($userID,$typeLink,$initialization,$status);
//            break;
//
//        default:
//            $arrForJson=false;
//            break;
//
//    }
//
////В случае успеха вывели json-ответ
//
//if($arrForJson!==false)
//{
//    $arrForJson=json_encode($arrForJson);
//    CIBlockElement::SetPropertyValueCode($idUnit, "JsonParam", $arrForJson);
//    echo $arrForJson;
//}
//else
//{
//    echo 'Error';
//}
