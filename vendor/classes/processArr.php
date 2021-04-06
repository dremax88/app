<?php


namespace classes;
use \Bitrix;
use \Bitrix\Main;
use \Bitrix\Main\Loader;
//use \Bitrix\Iblock;

class processArr
{
    protected $id, $arrDump, $idUser, $ufType;

    public function __construct($id, $arrDump, $idUser, $ufType)
    {
        $this->id=$id;
        $this->arrDump=$arrDump;
        $this->idUser=$idUser;
        $this->ufType=$ufType;
    }

    public function parseArr()
    {
//        Loader::includeModule('iblock');
        $arUser=new userArr($this->idUser, $this->ufType);
        $arUser=$arUser->getUserArr();
        if($this->arrDump['key']===$arUser[$this->ufType])
        {
            $count=0;
            foreach ($this->arrDump as $key=>$value)
            {
                echo strpos($key,'work_company') .'<br>';
                if(strpos($key,'work_company') !== false)
                {
                    $count++;
                    echo $count;
                }
                $arrWork_begin[]=$this->arrDump['work_begin_'.$count];
                $arrWork_end[]=$this->arrDump['work_end_'.$count];
                $arrWork_company[]=$this->arrDump['work_company_'.$count];
                $arrWork_position[]=$this->arrDump['work_position_'.$count];
            }
            $this->arrDump['work_begin']=$arrWork_begin;
            $this->arrDump['work_end']=$arrWork_end;
            $this->arrDump['work_company']=$arrWork_company;
            $this->arrDump['work_position']=$arrWork_position;
            $PROP = $this->arrDump;
            $arInfo =
                [

                    "MODIFIED_BY"    => 1,
                    "IBLOCK_SECTION_ID" => false,
                    "IBLOCK_ID"      => $this->id,
                    "PROPERTY_VALUES"=> $PROP,
                    "NAME"           => $this->arrDump["lastname"].' '.$this->arrDump["firstname"].' '.$this->arrDump["surname"],
                    "ACTIVE"         => "Y",

                ];
//            $elementObject = new \CIBlockElement;
//            $elId=$elementObject->add($arInfo);
//            var_dump($elId);
        }
        else
        {
            $arInfo = false;
        }
        return $arInfo;
    }
}