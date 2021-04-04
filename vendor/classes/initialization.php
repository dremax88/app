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
        $arUser=self::UserArr($idUser,$ufType);
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