<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

//������� ��������� ������������� test
function sub_dir($ar_dir,&$aMenuLinks,$code_gl,$IBLOCK_ID){//$ar_dir - ������ � ��������� ����������,&$aMenuLinks - ������ �����������,$code_gl - ��� ���������� ������� ������

	//print_r2($ar_dir);
	foreach($ar_dir as $key=>$val) 
	{	
		//echo $IBLOCK_ID;
		//die(); 
		//��������� ���� �� ��������� �������
		if(($val['RIGHT_MARGIN']-$val['LEFT_MARGIN'])>1)
			{ 
				//echo $val['ID'];
				$rsSections = GetIBlockSectionList($IBLOCK_ID, false, array("SORT" => "ASC"), false, array("ACTIVE"=>"Y","LEFT_BORDER"=>$val['LEFT_MARGIN']+1,"RIGHT_BORDER"=>$val['RIGHT_MARGIN']-1 )); 
				while ($arSection = $rsSections->Fetch())
				{ 
 
					$ar_dir_new[]=$arSection;
					$Links = SITE_DIR."book/index.php?SECTION_ID=".$arSection["ID"];
					$aMenuLinks[$code_gl][$arSection["ID"]]['linc']=array('name'=>$arSection['NAME'],'link'=>$Links,'level'=>$arSection['DEPTH_LEVEL']);
				}
				sub_dir($ar_dir_new,&$aMenuLinks,$code_gl,$IBLOCK_ID); 
			}
			else
				return false; 
	}
	return false;
}


if (CModule::IncludeModule("iblock")):

	$CACHE_TIME = $arParams['CACHE_TIME'];
	$IBLOCK_TYPE = $arParams['IBLOCK_TYPE'];	// ��� ����-�����
	$IBLOCK_ID = $arParams['IBLOCK_ID'];			// ID ����-�����
	$arr_gl_razdelov=explode(',',$arParams['csv_cods_razdelov']);//������ ����� �������� ������� ������
	

	$aMenuLinks = array();
	
	// ������� ���������
	$CACHE_ID = __FILE__.$IBLOCK_ID;
	$obMenuCache = new CPHPCache;
	// ���� ������ ����������� ��
	if($obMenuCache->InitCache($CACHE_TIME, $CACHE_ID, "/"))
	{
		// ����� ������ �� ����
		$arVars = $obMenuCache->GetVars();
		$aMenuLinks = $arVars["aMenuLinks"];
	}
	else
	{
		//$level=1;//������� ����
		// ����� �������� �������,���������� �� ������� �������� � �������� ������
		for($i=0;$i<count($arr_gl_razdelov);$i++)
		{
			$rsSections = GetIBlockSectionList($IBLOCK_ID, false, array("SORT" => "ASC"), false, array("ACTIVE"=>"Y","CODE"=>"%".$arr_gl_razdelov[$i])); 
			while ($arSection = $rsSections->Fetch())
			{
				$Links = SITE_DIR."book/index.php?SECTION_ID=".$arSection["ID"];
				$code_dir=explode('#',$arSection['CODE']);//��������� ������ ����� ���� ����������
				$aMenuLinks[$arr_gl_razdelov[$i]][$code_dir[0]]['linc']=array('name'=>$arSection['NAME'],'link'=>$Links,'level'=>$arSection['DEPTH_LEVEL']);
				
				sub_dir(array('0'=>$arSection),&$aMenuLinks,$arr_gl_razdelov[$i],$IBLOCK_ID);
				 
				
				//print_r2($aMenuLinks);
				
				
				// ��������� �� ��������� �������
				/*if ($rsElements = GetIBlockElementListEx($IBLOCK_TYPE, false, false, array(), false, array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID, "SECTION_ID" => $arSection["ID"]), array("ID", "IBLOCK_ID", "DETAIL_PAGE_URL")))
				{
					while ($arElement = $rsElements->GetNext()) $arrAddLinks[] = $arElement["DETAIL_PAGE_URL"];
				}*/
				
				/*$aMenuLinksNew_2[] = array(
					$arSection["NAME"], 
					SITE_DIR."/book/index.php?SECTION_ID=".$arSection["ID"],
					$arrAddLinks);*/	  
			}
				//print_r2($aMenuLinksNew_2);
				//die();
		}
	}
	
	// ��������� ������ � ����
	if($obMenuCache->StartDataCache())
	{
		$obMenuCache->EndDataCache(Array("aMenuLinks" => $aMenuLinks));
	}

	endif;
$arResult=$aMenuLinks;

//����������� �������
$this->IncludeComponentTemplate();
?>
