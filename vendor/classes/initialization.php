<?php


namespace classes;
use Bitrix\Main\Loader;

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
        global $USER;

        $filter   = ["ID" => 1112];
        $arParams = [
                     "FIELDS"=>["ID"],
                     "SELECT"=>["UF_KEY"]
                    ];

        $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter, $arParams);

        while ($arUser = $rsUsers->Fetch())
        {
            $arHund = $arUser;
        }

        Loader::includeModule("iblock");
        Loader::includeModule("main");

        if($arrDump['key']===$arHund['UF_KEY'])
        {
            return self::$info= $arrDump;
        }
        else
        {
            return 'Error !!';
        }

    }


}