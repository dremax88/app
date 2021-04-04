<?php


namespace classes;

use \Bitrix;
use \Bitrix\Main;
use \Bitrix\Main\Loader;

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

    public static function getUserArr($idUser, $ufType)
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
                $count=0;
                foreach ($arrDump as $key=>$value)
                {
                    if(strpos('work_company', $key) !== false)
                        {
                            $count++;
                        }
                    $arrWork_begin[]=$arrDump['work_begin_'.$count];
                    $arrWork_end[]=$arrDump['work_end_'.$count];
                    $arrWork_company[]=$arrDump['work_company_'.$count];
                    $arrWork_position[]=$arrDump['work_position_'.$count];
                }
                $arrDump['work_begin']=$arrWork_begin;
                $arrDump['work_end']=$arrWork_end;
                $arrDump['work_company']=$arrWork_company;
                $arrDump['work_position']=$arrWork_position;
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