<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//$arResult["TOVARY"]=;
   
if(CModule::IncludeModule("iblock"))
   { 
    $arr_tovary=array();
    $arSelect = Array();
    $arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("shows"=>"desc"), $arFilter, false, Array("nTopCount"=>$arParams["KOL_VIBORKY"]), $arSelect);
    while($ob = $res->GetNextElement())
    {
      $arFields = $ob->GetFields();
      $arr_tovary[]=$arFields;
    }
$arResult["SLUCH_TOVAR"]=$arr_tovary[$arParams["RAND_ID"]-1];    
}

// saving template name to cache array
$arResult["__TEMPLATE_FOLDER"] = $this->__folder;

// writing new $arResult to cache file
$this->__component->arResult = $arResult; 
?>
