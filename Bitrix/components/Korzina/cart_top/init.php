<?
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/.default/sale/mp3/init_vars.php");
include($_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/print_r.php');
require_once('FirePHPCore/fb.php');

//include_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/includes/phpThumb/phpThumb.class.php');
ini_set('realpath_cache_size', '6000k');
ini_set('eaccelerator.shm_size', '254');
set_time_limit(180); 

AddEventHandler("sale", "OnSaleCancelOrder", "SaleCancelOrderEventAdd");
function SaleCancelOrderEventAdd(&$ID, &$var)
{
 	if($var == "Y" && CModule::IncludeModule("statistic"))
 	{
		CStatistic::Set_Event("eStore", "order_cancel", $ID);
	}
}

/*AddEventHandler("sale", "OnOrderAdd", "OnOrderAddEventAdd");
function OnOrderAddEventAdd(&$ID, &$arFields )
{
    //echo $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sale_payment/post_body.php";
    print_r2($arFields);
    $arFields['DISCOUNT_VALUE']=30;
    
    print_r2($arFields);
    print_r2($ID);
    //CSaleOrder::Update($ID,$arFields);
    $arItems = GetBasketList();
    /*for ($i = 0; $i<count($arItems); $i++)
	{
        $arFields["DISCOUNT_PRICE"] = 0;      //величина скидки
        $arFields["DISCOUNT_NAME"] = "[4]"."skidka_15"; //название скидки
        $arFields["DISCOUNT_VALUE"] = 15;      //размер скидки (в процентах)      
        $arFields["DISCOUNT_COUPON"] = 'CP-II8U3-GN6W0UK';                   //купон скидки  
	CSaleBasket::Update($arItems[$i]["ID"],$arFields);
    }
    $arItems = GetBasketList();*/
    //print_r2($arItems);
    
    
    //die();
 	/*if($var == "Y" && CModule::IncludeModule("statistic"))
 	{
		CStatistic::Set_Event("eStore", "order_cancel", $ID);
	}
}*/

/*AddEventHandler("sale", "OnSaleComponentOrderOneStepComplete","KillCoupon");
function KillCoupon($ID,$arFields) 
{ 
   CModule::IncludeModule('catalog'); 
   foreach ($_SESSION["CATALOG_USER_COUPONS"] as $coupon): 
      $res=CCatalogDiscountCoupon::GetList(array(),array('COUPON'=>$coupon))->Fetch(); 
      if ($res && $res['DATE_APPLY']) 
         CCatalogDiscountCoupon::Update($res['ID'],Array('ACTIVE'=>'N'));
   endforeach; 
}*/



function MP3DeliveryOrderCallback($productID, $userID, $bPaid, $orderID)
{
	global $DB;

	$productID = IntVal($productID);
	$userID = IntVal($userID);
	$bPaid = ($bPaid ? True : False);
	$orderID = IntVal($orderID);

	if ($userID <= 0)
		return False;

	if ($orderID <= 0)
		return False;

	if (!array_key_exists($productID, $GLOBALS["arMP3Sums"]))
		return False;

	if (!($arOrder = CSaleOrder::GetByID($orderID)))
		return False;

	$baseLangCurrency = CSaleLang::GetLangCurrency($arOrder["LID"]);

	$currentPrice = $GLOBALS["arMP3Sums"][$productID]["PRICE"];
	$currentCurrency = $GLOBALS["arMP3Sums"][$productID]["CURRENCY"];
	if ($GLOBALS["arMP3Sums"][$productID]["CURRENCY"] != $baseLangCurrency)
	{
		$currentPrice = CCurrencyRates::ConvertCurrency($GLOBALS["arMP3Sums"][$productID]["PRICE"], $GLOBALS["arMP3Sums"][$productID]["CURRENCY"], $baseLangCurrency);
		$currentCurrency = $baseLangCurrency;
	}

	if (!CSaleUserAccount::UpdateAccount($userID, ($bPaid ? $currentPrice : -$currentPrice), $currentCurrency, "MANUAL", $orderID))
		return False;

	return True;
}

function cutStr($str,$scount,$cutParam,$id_element){
if(strlen($str) > $scount){   // если кол-во символов строки превышает  $scount
	
	$str_izm = substr($str,0,$scount);
	$result = preg_match('/([\s])/',$str,$found,PREG_OFFSET_CAPTURE, $scount-20);
	//print_r($found);
        //die();
	if(count($found)>0)
	{
		/*$poz_tchk=strrpos($str_izm,$found[0]);  
		$poz_tchk_after=strpos($str,'.',$scount);
		$poz_prob_befor=strpos($str,'.',$scount);
		if($poz_tchk)
		{
			$str_izm = substr($str_izm,0,$poz_tchk+1);  // обрезаем строку до символа $scount и ставим окончание $cutParam 
		}
		elseif($poz_tchk_after)
		{
			$str_izm = substr($str,0,$poz_tchk_after+1); 
		}
		elseif($poz_prob_befor)
			{
				$str_izm=substr($str,0,$poz_prob_befor);
				$str_izm=$str_izm.'...';
			}*/
          $str_izm = substr($str,0,$found[1][1]).' ...';      
	}
$str=$str_izm;
}
elseif(strlen($str) < 20)//на случай малого описания
{
    $str_izm='';
    $str=$str_izm;
}
    
return $str; // возвращаем результат
}

function cutStr_ID($str,$scount,$cutParam,$id_element){
if(strlen($str) > $scount){   // если кол-во символов строки превышает  $scount
	
	$str_izm = substr($str,0,$scount);
	$result = preg_match('/([\s])/',$str,$found,PREG_OFFSET_CAPTURE, $scount-20);
	//print_r($found);
        //die();
	if(count($found)>0)
	{
		/*$poz_tchk=strrpos($str_izm,$found[0]);  
		$poz_tchk_after=strpos($str,'.',$scount);
		$poz_prob_befor=strpos($str,'.',$scount);
		if($poz_tchk)
		{
			$str_izm = substr($str_izm,0,$poz_tchk+1);  // обрезаем строку до символа $scount и ставим окончание $cutParam 
		}
		elseif($poz_tchk_after)
		{
			$str_izm = substr($str,0,$poz_tchk_after+1); 
		}
		elseif($poz_prob_befor)
			{
				$str_izm=substr($str,0,$poz_prob_befor);
				$str_izm=$str_izm.'...';
			}*/
          $str_izm = substr($str,0,$found[1][1]).' <a class="link_hover" href=/book/element.php?ID='.$id_element.'>...</a>';      
	}
$str=$str_izm;
}
elseif(strlen($str) < 20)//на случай малого описания
{
    $str_izm='';
    $str=$str_izm;
}
    
return $str; // возвращаем результат
}


function getcardproduct()
{
    if (CModule::IncludeModule("sale"))
    {
        $arBasketItems = array();
        $dbBasketItems = CSaleBasket::GetList(
                array(
                        "NAME" => "ASC",
                        "ID" => "ASC"
                    ),
                array(
                        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                        "LID" => SITE_ID,
                        "ORDER_ID" => "NULL"
                    ),
                false,
                false,
                array("ID", "CALLBACK_FUNC", "MODULE", 
                      "PRODUCT_ID", "QUANTITY")
            );
        while ($arItems = $dbBasketItems->Fetch())
        {
            if (strlen($arItems["CALLBACK_FUNC"]) > 0)
            {
                CSaleBasket::UpdatePrice($arItems["ID"], 
                                         $arItems["CALLBACK_FUNC"], 
                                         $arItems["MODULE"], 
                                         $arItems["PRODUCT_ID"], 
                                         $arItems["QUANTITY"]);
                $arItems = CSaleBasket::GetByID($arItems["ID"]);
            }
            $arBasketItems[$arItems['PRODUCT_ID']] = array('id_inbt'=>$arItems['ID'],'QUANTITY'=>$arItems['QUANTITY']);
        }
    return $arBasketItems;    
    }
}

function getcartpr_top()//функция для выборки товаров в корзине для вывода потом их в шапке
{
    if (CModule::IncludeModule("sale"))
    {
        $arBasketItems = array();
        $dbBasketItems = CSaleBasket::GetList(
                array(
                        "NAME" => "ASC",
                        "ID" => "ASC"
                    ),
                array(
                        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                        "LID" => SITE_ID,
                        "ORDER_ID" => "NULL",
                        "DELAY"=>"N",
                        "CAN_BUY"=>"Y",
                    ),
                false,
                false,
                array("ID", "CALLBACK_FUNC", "MODULE", 
                      "PRODUCT_ID", "QUANTITY","PRICE")
            );
        while ($arItems = $dbBasketItems->Fetch())
        {
            if (strlen($arItems["CALLBACK_FUNC"]) > 0)
            {
                CSaleBasket::UpdatePrice($arItems["ID"], 
                                         $arItems["CALLBACK_FUNC"], 
                                         $arItems["MODULE"], 
                                         $arItems["PRODUCT_ID"], 
                                         $arItems["QUANTITY"],
                                         $arItems["PRICE"]);
                
                $arItems = CSaleBasket::GetByID($arItems["ID"]);
            }
            
            $arSelect = Array("ID", "PROPERTY_indic_real");
            $arFilter = Array("ID"=>$arItems['PRODUCT_ID']);
            
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->GetNextElement())
            {
                $arFields_el = $ob->GetFields();
            }
            
            
            $arBasketItems[$arItems['PRODUCT_ID']] = array('id_inbt'=>$arItems['ID'],'QUANTITY'=>$arItems['QUANTITY'],"PRICE"=>$arItems["PRICE"],"indic_real"=>$arFields_el["PROPERTY_INDIC_REAL_VALUE"]);
        }
    return $arBasketItems;    
    }
}


//функция кеширования участников и ролей
function cash_uch($CACHE_TIME_UCH)
{
    //$time1=time();
    // TODO: функция::кешируем массив ролей и участников
    $CACHE_ID_UCH = md5('rols_uch'); //ключ кеша для массива участников и ролей
    $obCache_uch = new CPHPCache;
    if ($obCache_uch->InitCache($CACHE_TIME_UCH, $CACHE_ID_UCH, "/")) {
        $vars_uch = $obCache_uch->GetVars();

        //востанавливаем массивы
        $arr_uch = $vars_uch['arr_uch'];
        $arr_rols = $vars_uch['arr_rols'];
        $arr_chin = $vars_uch['arr_chin'];
        $arr_uch_kn=$vars_uch['arr_uch_kn'];
        
    } else {
        //тут выбираем роли и участников
        $rs_rols = CIBlockElement::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => '52'), false);
        $arr_rols = array(); //инициируем массив ролей

        while ($rolElement = $rs_rols->GetNextElement()) {
            $element = $rolElement->GetFields();
            $element_prop = $rolElement->GetProperties();
            $arr_rols[$element_prop['id_in_cat']['VALUE']] = $element['NAME']; //составляем массив ролей
        }

        //собираем массив участников и их чинов
        $rs_uch = CIBlockElement::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => '51'), false);
        while ($uchElement = $rs_uch->GetNextElement()) {
            $element = $uchElement->GetFields();
            $element_prop = $uchElement->GetProperties();
            $arr_uch[$element_prop['id_in_cat']['VALUE']] = $element['NAME']; //составляем массив участников
            $arr_chin[$element_prop['id_in_cat']['VALUE']] = $element_prop['chin_umolch']['VALUE'];
        }
        
        //$count=0;
        foreach($arr_uch as $key_uch=>$val_uch)
        {
            //$count++;
            //if($count>10)
               //break;
            $arSelect=array('ID');
            $arFilter=array('IBLOCK_ID' => '55','PROPERTY_uchastnik'=>'P'.$key_uch);
            $rsElements = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
            $count_knig=$rsElements->SelectedRowsCount();
            if($count_knig>0)
            {
                $arr_uch_kn[$key_uch]=$count_knig;
            }
            else
            {
                $count_knig=0;
            }
        }
}

// начинаем буферизирование вывода
    if ($obCache_uch->StartDataCache()):
        $obCache_uch->EndDataCache(array(
            "arr_rols" => $arr_rols,
            "arr_uch" => $arr_uch,
            "arr_chin" => $arr_chin,
            "arr_uch_kn" =>$arr_uch_kn
        ));
    endif;
    
    //end --- кешируем массив ролей и участников
    //$time2=time();
    //echo $time2-$time1;
    //echo ' --- время';
    return(array($arr_rols,$arr_uch,$arr_chin,$arr_uch_kn));
}

/**
* Генерация превьюшек для больших изображений
*
* @param string $src путь от корня сайта к исходной картинке
* @param int $size размер изображения (сторона квадрата в пикселях)
* @param int $lifeTime время жизни превьюшки в секундах (по дефолту месяц)
* @return string
*/
function MakeImage ($src, $size=87, $lifeTime = 2592000, $params = "") {
   if (!$lifeTime) $lifeTime = 2592000;
   if (!$size) $size = 87;
    if (is_numeric($src)) if ($src > 0) $src = CFile::GetPath($src);
   if (file_exists($_SERVER['DOCUMENT_ROOT'].$src)) {
        require_once($_SERVER['DOCUMENT_ROOT']."bitrix/php_interface/include/phpThumb/phpthumb.class.php"); // Подключаем и иннициализируем phpThumb
        $phpThumb = new phpThumb();
        $phpThumb->src = $src;
        $ext = end(explode(".", $src)); // Расширение файла картинки
        switch ($ext) {
            case "jpg": $phpThumb->f = "jpeg"; break;
            case "gif": $phpThumb->f = "gif"; break;
            case "png": $phpThumb->f = "png"; break;
            default: $phpThumb->f = "jpeg"; break;
        }
        $base_name = basename($src, ".".$ext); // Основное имя файла
        $phpThumb->w = $size;
        //$phpThumb->h = $size;
        $phpThumb->q = 90;
        $phpThumb->bg = "#ffffff";
        $phpThumb->far = true;
        $phpThumb->aoe = false;
        if (is_array($params)) {
           foreach ($params as $param=>$value) {
              $phpThumb->$param = $value;
           }
           $code = substr(md5(serialize($params)), 8, 16); // сократим суффикс с параметрами до 16 символов
        } else {
           $code = $phpThumb->w;
        }
        $target_file = $_SERVER['DOCUMENT_ROOT'].dirname($src)."/".$base_name."_thumb_".$code.".".$ext;
        if (file_exists($target_file) AND filesize($target_file)>0) {
            if (filemtime($target_file)+$lifeTime < time()) { // Файл есть, но старый
                $phpThumb->GenerateThumbnail();
                $success = $phpThumb->RenderToFile($target_file);
            } else { // Файл есть, новый, не генерируем
                $success = true;
            }
        } else { // Файла нет, генерируем
           if (file_exists($target_file) AND filesize($target_file)==0) @unlink($target_file); // удаление файла нулевой длины
            $phpThumb->GenerateThumbnail();
            $success = $phpThumb->RenderToFile($target_file);
        }
        if ($success) return substr($target_file, strlen($_SERVER['DOCUMENT_ROOT'])); else return false;
    } else {
        return false;
    }
}

function scidka($arr_itog,$allSum,$arr_procent)
{
    //сумма всего
    $summ_tov_all=0;//общая сумма
    $summ_with_skidka=0;//общая сумма со скидкой

    //переменная
    $summ_with_ogr=0;//сумма товаров ограничением на скидку скидкой
    $summ_no_ogr=0;//сумма товаров без скидки
    $sobsh_skidka=0;//общая скидка
    $procent_noogr=$arr_procent;//array(15,20,25);//процент для товаров без ограничения
    $procent_ogr=5;//процент для товаров с ограничением на скидку

    $kolvo_tov=count($arr_itog);

    $summ_tov_all=$allSum;
    
    foreach($arr_itog as $id_tov=>$tov_cart)
    {
        if($tov_cart['indic_real']=='Y')
            $summ_with_ogr+=$tov_cart['cena_one_tov']*$tov_cart['book_quan'];
        if($tov_cart['indic_real']=='N')
            $summ_no_ogr+=$tov_cart['cena_one_tov']*$tov_cart['book_quan'];
    }
     //print_r2($summ_no_ogr);
     //die();

    //пишем условия для расчета скидки
    if($summ_tov_all<10000)
    {
        $sobsh_skidka=0;
        $summ_with_skidka=0;
        $pr_skidka=0;
    }
    elseif($summ_tov_all>=10000){    

        if($summ_tov_all>=10000 and $summ_tov_all<20000)
        {
            $index_sk=0;//сумма скидки на товары без ограничения
        }
        elseif($summ_tov_all>=20000 and $summ_tov_all<50000)
        {
            $index_sk=1;
        }
        elseif($summ_tov_all>=50000)
        {
            $index_sk=2;
        }
        $sum_sk_ogr=$summ_with_ogr/100*$procent_ogr;
        $sum_sk_noogr=$summ_no_ogr/100*$procent_noogr[$index_sk];//сумма скидки на товары без ограничения

        $sobsh_skidka=$sum_sk_ogr+$sum_sk_noogr;
        $summ_with_skidka=$summ_tov_all-$sobsh_skidka;
        
        $pr_skidka=$arr_procent[$index_sk];
    }
    
return(array('sobsh_skidka'=>$sobsh_skidka,'summ_with_skidka'=>$summ_with_skidka,'skidka'=>$pr_skidka));
    
}

function raschet_summa($arItems,$delay,$CACHE_UCH){
    
//массив элементов -$arItems,индикатор активного или отложенного товара - $delay
    
    $allSum = 0;
    $allWeight = 0;
    $allQuan= 0;
    $allCurrency = CSaleLang::GetLangCurrency(LANG);

    list($arr_rols_cash,$arr_uch_cash,$arr_chin_cash)=$CACHE_UCH;
    
for ($i = 0; $i<count($arItems); $i++)
{
    if ($arItems[$i]["DELAY"]==$delay && $arItems[$i]["CAN_BUY"]=="Y")
	{
       
$name_book=$arItems[$i]['NAME'];
$book_quan=$arItems[$i]['QUANTITY'];//количество одного вида книг
$book_id=$arItems[$i]['PRODUCT_ID'];//ай-ди книги        

//вытаскиваем значения нужных свойств из инфоблока
//*****************************************************
$arSelect = Array("ID", "PROPERTY_indic_real", "PROPERTY_VES","PROPERTY_uchastnik","PROPERTY_rol_","PROPERTY_KOL");
$arFilter = Array("ID"=>$book_id);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);

$arr_rols=array();
$arr_uch=array();
$arr_rols_itog=array();
$arr_uch_itog=array();

$schet_iter=0;
while($ob = $res->GetNextElement())
{
  $arFields = $ob->GetFields();
  $arr_rols[]=$arFields['PROPERTY_ROL__VALUE'];
  $arr_uch[]=$arFields['PROPERTY_UCHASTNIK_VALUE'];
  $schet_iter++;
}

if(count($arr_uch)>1)
{
    //считаем размер массива и выбираем квадратный корень авторов,выбираем первого попавшегося автора
    $count_uch=sqrt(count($arr_uch));

    for($j=1;$j<$count_uch+1;$j++)
    {
        if($j==1)
            $index=1;
        else
            $index=$j+$count_uch*($j-1)-1;
        
        $arr_rols_itog[]=$arr_rols[$j-1];
        $arr_uch_itog[]=$arr_uch[$index];
    }


    $arFields['PROPERTY_ROL__VALUE']=array_slice($arr_rols_itog, 0, $count_uch);
    $arFields['PROPERTY_UCHASTNIK_VALUE']=array_slice($arr_uch_itog, 0, $count_uch);

}
else
{
    $arFields['PROPERTY_ROL__VALUE']=$arr_rols;
    $arFields['PROPERTY_UCHASTNIK_VALUE']=$arr_uch; 
    
}

$arr_rol_rez=$arFields['PROPERTY_ROL__VALUE'];//результативный массив для ролей
$arr_uch_rez=$arFields['PROPERTY_UCHASTNIK_VALUE'];//результативный массив участников

if(count($arr_uch_rez)>1)
    $chislo_uch = count($arr_el_uch);
elseif($arr_uch_rez[0]!=NULL)
    $chislo_uch=1;

if(count($arr_rol_rez)>1)
    $chislo_rol = count($arr_rol_rez);
elseif($arr_rol_rez[0]!=NULL)
    $chislo_rol=1;

//определяем заглавного учатника(автора по дефолту)
$arr_rol_rez_fl=array_flip($arr_rol_rez);//перевернутый массив ролей
//die();

if($chislo_rol>0)
{
    /*if(isset($arr_rol_rez_fl['R1']))
    {
        $id_rol=substr('R1', 1);
        foreach($arr_rol_rez as $key=>$rol)
        {
            if($rol=='R1'){
                $id_uch_in=$key;
            }
        }
    }
    else
    {
        $id_rol=substr($arr_uch_rez[0], 1);
        $id_uch_in=0;
    }*/
    $id_rol=substr($arr_uch_rez[0], 1);
    $id_uch_in=0;
}

$id_uch = substr($arr_uch_rez[$id_uch_in], 1);//ай-ди участника
$name_uch = $arr_uch_cash[$id_uch];//заглавное имя участника
$chin = $arr_chin_cash[$id_uch];//заглавный чин участников

//*****************************************************конец выборки ролей

$id_tov_vkor=$arItems[$i]['ID'];
$name_book=$arItems[$i]['NAME'];
$book_quan=$arItems[$i]['QUANTITY'];//количество одного вида книг
$indic_real=$arFields['PROPERTY_INDIC_REAL_VALUE'];//индикатор реализации
$weight=$arFields['PROPERTY_VES_VALUE'];//вес одного товара
$kol_na_sklade=$arFields['PROPERTY_KOL_VALUE'];//вес одного товара


$cena_one_tov=number_format($arItems[$i]['PRICE'], 0, ',', ' ');//цена одного товара
$cena_all_tov=$cena_one_tov*$book_quan;//цена всех товаров одного типа

$allSum += $cena_all_tov;//общая сумма всех товаров
$allQuan+=$book_quan;
$allWeight += ($weight*$book_quan);

$arr_itog[]=array('name_book'=>$name_book,'chin'=>$chin,'name_uch'=>$name_uch,'weight'=>$weight,'cena_one_tov'=>$cena_one_tov,'book_quan'=>$book_quan,'indic_real'=>$indic_real,'kol_na_sklade'=>$kol_na_sklade,'id_tov_vkor'=>$id_tov_vkor);       

    }
}

$arr_vars_param=array('allSum'=>$allSum,'allQuan'=>$allQuan,'allWeight'=>$allWeight);

return(array('arr_vars_param'=>$arr_vars_param,'arr_itog'=>$arr_itog));
}

function get_rus_date($str_date){//необходимо передать в формате 'дата время'
    //руские названия месяцев можно выводить следующим образом
    $rus_months=array('января', 'февраля', 'марта', 'апреля', 'мая','июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
    $arr_date_time=split(' ', $str_date);
    $arr_date=split('\.',$arr_date_time[0]);
    $itog_date=intval($arr_date[0]).' '.$rus_months[intval($arr_date[1])-1].' '.$arr_date[2];
   
    return $itog_date;
}

//функция выбирает автора книги и его чин
function get_avtor($id_book,$arr_uch,$arr_chin)
{
        $name_uch=array();
        $chin=array();
        
        //выбираем нужные нам свойства товара участника и автора
        $arSelect = Array("ID",'PROPERTY_uchastnik',"PROPERTY_rol_","PROPERTY_KOD");
        $arFilter = Array("ID"=>$id_book);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        
        $arruch=array();
        while($ob = $res->GetNextElement())
        {
          $arruch[] = $ob->GetFields();
          break;//выбираем первого участника как автора
        }

        if(!empty($arruch))
        {
            $id_rol=substr($arruch[0]['PROPERTY_ROL__VALUE'],1);
            $id_uch=substr($arruch[0]['PROPERTY_UCHASTNIK_VALUE'],1);
            $name_uch = $arr_uch[$id_uch];//заглавное имя участника
            $chin = $arr_chin[$id_uch];//заглавный чин участников
        }
        else
        {
            $name_uch=='';
            $chin='';
        }
        
        $kod_tov=$arruch[0]['PROPERTY_KOD_VALUE'];
        
return array('name_uch'=>$name_uch,'chin'=>$chin,'kod'=>$kod_tov);
}


function num_form($var_str)
{
    $var_return=number_format($var_str, 0, ',', ' ');
    return $var_return;
}

function get_pic_puth($id_pic)
{
    if($id_pic!='')
    {
        $rsFile = CFile::GetByID($id_pic);
        $arpik = $rsFile->Fetch();
        $pic_path='/upload/'.$arpik['SUBDIR'].'/'.$arpik['FILE_NAME'];
    }
 else {
        $pic_path='';
      }
    
return $pic_path;
}

?>
