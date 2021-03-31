<?php


namespace classes;

use \Bitrix;
use \Bitrix\Main;
use \Bitrix\Main\Loader;
use \Bitrix\Iblock;

class initialization
{
    private static $init;
    protected static $info;

    private function __construct()
    {
        // TODO: Implement __clone() method.
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    public static function getInit()
    {
        if(self::$init===null){
            self::$init=new self();
        }
        return self::$init;
    }

    protected static function getUserArr($idUser, $ufType)
    {
        $arFilter=['ID'=>$idUser];
        $arSelect=['ID',$ufType];
        $result = Main\UserTable::getList
        (
            [

            'filter' => $arFilter,
            'select' => $arSelect, // выбираем идентификатор группы и символьный код группы

            ]
        );

        while  ($arUgroup = $result->fetch()) {
            $arUser=$arUgroup;
        }
        return $arUser;
    }

    public static function parseArr($id, $arrDump, $idUser, $ufType)
    {

        $arUser=self::getUserArr($idUser,$ufType);
        if($arrDump['key']===$arUser[$ufType])
            {
                $PROP = $arrDump;
                $arInfo =
                    [

                        "MODIFIED_BY"    => 1,
                        "IBLOCK_SECTION_ID" => false,
                        "IBLOCK_ID"      => $id,
                        "PROPERTY_VALUES"=> $PROP,
                        "NAME"           => $arrDump["lastname"].' '.$arrDump["firstname"].' '.$arrDump["surname"],
                        "ACTIVE"         => "Y",

                    ];
            }
        else
        {
            $arInfo = false;
        }
        return $arInfo;

    }

    public static function checkResult($key, $idHReg){
        Loader::includeModule('iblock');

        $res = Iblock\CIBlockElement::GetList([], ['PROPERTY_1485'=>$key, 'PROPERTY_1468'=>$idHReg], false, false, ['*']);
        while($ob = $res->GetNextElement()){
            $arFields = $ob->GetFields();
            print_r($arFields);
            $arProps = $ob->GetProperties();
            print_r($arProps);
        }
        return $arFields;
    }

    public static function generateUfLink($idUser, $ufType)
    {
        $arUser=self::getUserArr($idUser,$ufType);
        $hech = uniqid();
        switch ($ufType)
        {
            case 'UF_LINK':

                $link = "https://rolf.si-24.ru/questionnaires/negative/?avto=no&hech=".$hech."&admid=".$idUser."&type_of_questionnaire=Negative";
                $arLink['link']=$link;
                $arUser[$ufType][]=$link;
                $arLink[$ufType]=$arUser[$ufType];
                break;

            case 'UF_SOTR_LINK':

                $link = "https://rolf.si-24.ru/questionnaires/negative/?avto=no&hech=".$hech."&admid=".$idUser."&type_of_questionnaire=HR";
                $arLink['link']=$link;
                $arUser[$ufType][]=$link;
                $arLink[$ufType]=$arUser[$ufType];
                break;

            case 'UF_KADRSH':
                $link = "https://rolf.si-24.ru/questionnaires/negative/?avto=no&hech=".$hech."&admid=".$idUser."&type_of_questionnaire=Extended";
                $arLink['linck']=$link;
                $arUser[$ufType][]=$link;
                $arLink[$ufType]=$arUser[$ufType];
                break;
            default:
                $arLink=false;
        }
        return $arLink;

    }


}