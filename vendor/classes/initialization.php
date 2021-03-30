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


        $result = Main\UserGroupTable::getList(array(

            'filter' => array('USER_ID'=>1112,'GROUP.ACTIVE'=>'Y'),

            'select' => array('USER_ID','UF_KEY'), // выбираем идентификатор группы и символьный код группы

            'order' => array('GROUP.C_SORT'=>'ASC'), // сортируем в соответствии с сортировкой групп

        ));

        while ($arGroup = $result->fetch())

        {

            print_r($arGroup);

        }



//        if($arrDump['key']===$arHund['UF_KEY'])
//        {
//            return self::$info= $arrDump;
//        }
//        else
//        {
//            return 'Error !!';
//        }

    }


}