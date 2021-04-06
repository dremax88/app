<?php


namespace classes;

use \Bitrix;
use \Bitrix\Main;
use \Bitrix\Main\Loader;

class userArr
{
    protected $idUser,$ufType;

    public function __construct($idUser, $ufType)
    {
        $this->idUser=$idUser;
        $this->ufType=$ufType;
    }

    public function getUserArr()
    {
        $arFilter=['ID'=>$this->idUser];
        $arSelect=['ID',$this->ufType];
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
}