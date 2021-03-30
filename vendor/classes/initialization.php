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

    public static function parseArr($arrDump)
    {

        $arFilter=['ID'=>1112];
        $arSelect=['ID','UF_KEY'];
        $result = Main\UserTable::getList([

            'filter' => $arFilter,

            'select' => $arSelect, // выбираем идентификатор группы и символьный код группы

        ]);

        while  ($arUroup = $result->fetch()) {
            $arUser=$arUroup;
        }

        if($arrDump['key']===$arUser['UF_KEY'])
        {
            $res = $arrDump;
            $PROP = $arrDump;
            $arInfo = [
                "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
                "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                "IBLOCK_ID"      => 61,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => $arrDump["lastname"].' '.$arrDump["firstname"].' '.$arrDump["surname"],
                "ACTIVE"         => "Y",            // активен
            ];
//           Bitrix\Iblock\ElementTable::add($arInfo);
        }
        else
        {
            $res = 'Error !!';
        }
        return $res;

    }


}