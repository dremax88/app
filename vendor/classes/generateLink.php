<?php


namespace classes;


class generateLink
{
    protected $idUser, $ufType;

    public function __construct($idUser, $ufType)
    {
        $this->idUser=$idUser;
        $this->ufType=$ufType;
    }

    public function getGenerateUfLink()
    {
        $arUser=new userArr($this->idUser, $this->ufType);
        $arUser=$arUser->getUserArr();
        $hech = uniqid();
        switch ($this->ufType)
        {
            case 'UF_LINK':

                $link = "https://rolf.si-24.ru/questionnaires/negative/?avto=no&hech=".$hech."&admid=".$this->idUser."&type_of_questionnaire=Negative";
                $arLink['link']=$link;
                $arUser[$this->ufType][]=$link;
                $arLink[$this->ufType]=$arUser[$this->ufType];
                break;

            case 'UF_SOTR_LINK':

                $link = "https://rolf.si-24.ru/questionnaires/negative/?avto=no&hech=".$hech."&admid=".$this->idUser."&type_of_questionnaire=HR";
                $arLink['link']=$link;
                $arUser[$this->ufType][]=$link;
                $arLink[$this->ufType]=$arUser[$this->ufType];
                break;

            case 'UF_KADRSH':
                $link = "https://rolf.si-24.ru/questionnaires/negative/?avto=no&hech=".$hech."&admid=".$this->idUser."&type_of_questionnaire=Extended";
                $arLink['linck']=$link;
                $arUser[$this->ufType][]=$link;
                $arLink[$this->ufType]=$arUser[$this->ufType];
                break;
            default:
                $arLink=false;
        }
        return $arLink;
    }
}