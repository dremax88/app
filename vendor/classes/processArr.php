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
                if(strpos($key,'work_company') !== false)
                {
                    $count++;
                    $dstart=explode('.',$this->arrDump['work_begin_'.$count]);
                    $dstart=$dstart[2].'-'.$dstart[1].'-'.$dstart[0];
                    $arrWork_begin[]=$dstart;
                    $dend=explode('.',$this->arrDump['work_end_'.$count]);
                    $dend=$dend[2].'-'.$dend[1].'-'.$dend[0];
                    $arrWork_end[]=$dend;
                    $arrWork_company[]=$this->arrDump['work_company_'.$count];
                    $arrWork_position[]=$this->arrDump['work_position_'.$count];
                }

            }
            $this->arrDump['work_begin']=$arrWork_begin;
            $this->arrDump['work_end']=$arrWork_end;
            $this->arrDump['work_company']=$arrWork_company;
            $this->arrDump['work_position']=$arrWork_position;
            if($key=='data_b'){

                $date=explode('.',$this->arrDump[$key]);
                $date=$date[2].'-'.$date[1].'-'.$date[0];
                $this->arrDump['data_b']=$date;
            }
            $PROP = $this->arrDump;
            print_r($PROP['data_b']);
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