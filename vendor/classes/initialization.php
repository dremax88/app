<?php


namespace classes;
use \Bitrix\Main;
use \Bitrix\Main\Loader;

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

        Loader::includeModule("iblock");
        Loader::includeModule("main");

        $arFilter=['ID'=>1112];
        $arSelect=['ID','UF_KEY'];
        $result = Main\UserTable::getList([

            'filter' => $arFilter,

            'select' => $arSelect, // выбираем идентификатор группы и символьный код группы

        ]);

        if ($arUroup = $result->fetch()) return;

        print_r($arrDump) ;

        if($arrDump['key']===$arUroup['UF_KEY'])
        {
            $res = $arrDump;
        }
        else
        {
            $res = 'Error !!';
        }
        return self::$info= $res;

    }


}