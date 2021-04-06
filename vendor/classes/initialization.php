<?php


namespace classes;

class initialization
{
    private static $init;

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

    public static function UserArr($idUser, $ufType)
    {
        $userArr=new userArr($idUser, $ufType);
        return $userArr->getUserArr();
    }

    public static function parseArr($id, $arrDump, $idUser, $ufType)
    {
        $arInfo=new processArr($id, $arrDump, $idUser, $ufType);
        return $arInfo->parseArr();

    }

    public static function generateUfLink($idUser, $ufType)
    {
        $arUser=new generateLink($idUser,$ufType);
        return $arUser->getGenerateUfLink();
    }
}