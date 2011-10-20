<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>
<?//print_r2($arResult['QUESTIONS']);?>


<?if ($arResult["isFormNote"] != "Y") 
{
?>

<?=$arResult["FORM_HEADER"]?>

<?
/***********************************************************************************
						form questions
***********************************************************************************/

foreach($arResult['QUESTIONS'] as $key=>$quest)
{
	$arr_quest[$quest['CAPTION']]=$quest['STRUCTURE'];
	$arr_key[$quest['CAPTION']]=$key;
}

//print_r2($arr_quest);

///////////////////str arr
$company=$arr_quest['Company'];
$email=$arr_quest['E-mail'];
$h_s_code=$arr_quest['H.S.code'];

	$incoterms=$arr_quest['Incoterms'];
	$key_incoterms=$arr_key['Incoterms'];

$destin_from=$arr_quest['Destin_from'];
$destin_to=$arr_quest['Destin_to'];
$weight_car=$arr_quest['Weight_of_cargo'];

	$cont_type=$arr_quest['Container type'];
	$key_cont_type=$arr_key['Container type'];

	$num_cont=$arr_quest['Num_cont'];
	$key_num_cont=$arr_key['Num_cont'];

$adit_info=$arr_quest['Adit_info'];

$select_str='selected';

////////////////////str val
$company_str='<input type="text"  class="company"  name="form_text_'.$company[0]['ID'].'" value="" size="0" />';
$email_str='<input type="text"  class="e-mail"  name="form_email_'.$email[0]['ID'].'" value="" size="0" />';
$h_s_code_str='<input type="text"  class="code"  name="form_text_'.$h_s_code[0]['ID'].'[1]" value="" size="0" />';

//$incoterms_str - выпадающий список
$incoterms_str='<select class="select" selected name="form_dropdown_'.$key_incoterms.'" id="form_dropdown_'.$key_incoterms.'">';
	foreach($incoterms as $val)
	{
		if($val['FIELD_PARAM']=='selected')
			$select_str='selected';
		else
			$select_str='';
			
		$incoterms_str.='<option '.$select_str.' value="'.$val["ID"].'">'.$val["MESSAGE"].'</option>';
	}
	$incoterms_str.='</select>'; 

$destin_from_str='<input type="text"  class="from"  name="form_text_'.$destin_from[0]['ID'].'" value="" size="0" />';
$destin_to_str='<input type="text" class="to"  name="form_text_'.$destin_to[0]['ID'].'" value="" size="0" />';
$weight_car_str='<input type="text"  class="weight"  name="form_text_'.$weight_car[0]['ID'].'" value="" size="0" />';

//$cont_type - выпадающий список
$cont_type_str='<select class="select" selected name="form_dropdown_'.$key_cont_type.'" id="form_dropdown_'.$key_cont_type.'">';
	foreach($cont_type as $val)
	{
		if($val['FIELD_PARAM']=='selected')
			$select_str='selected';
		else
			$select_str='';
			
		$cont_type_str.='<option '.$select_str.' value="'.$val["ID"].'">'.$val["MESSAGE"].'</option>';
	}
	$cont_type_str.='</select>'; 
	
$num_cont_str='<select class="select" selected name="form_dropdown_'.$key_num_cont.'" id="form_dropdown_'.$key_num_cont.'">';
	foreach($num_cont as $val)
	{
		if($val['FIELD_PARAM']=='selected')
			$select_str='selected';
		else
			$select_str='';
			
		$num_cont_str.='<option '.$select_str.' value="'.$val["ID"].'">'.$val["MESSAGE"].'</option>';
	}
	$num_cont_str.='</select>'; 

$adit_info_str='<textarea name="form_textarea_'.$adit_info[0]['ID'].'" rows="6" cols="35"></textarea>';

//print_r2($email_str);
//print_r2($arResult);
if(isset($_REQUEST['indi_fine']) or isset($_REQUEST['indi_dob']))
	echo GetMessage('FORM_DATA_SAVED');
	
//print_r2($_REQUEST);
?>
<br>
<br>
<fieldset>
                <div class="row">
                    <label for="company">Company:</label>
                    <div class="form-item"><?=$company_str?></div>
                </div>
                <div class="row">
                    <label for="e-mail">E-mail:</label>
                    <div class="form-item"><?=$email_str?></div>
                </div>
                <div class="row">
                    <label for="code">H. S. code:</label>
                    <div class="code-area" id="code_area">
                        <div class="row">
                            <div class="form-item short"><?=$h_s_code_str?></div>
							<a class="btn-add" href="#">+Add one more</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="incoterms">Incoterms:</label>
                    <?=$incoterms_str?>
                </div>
                <div class="row destination">
                    <label for=" from">Destination from</label>
                    <div class="form-item short"><?=$destin_from_str?></div>
                    <label for="to">to</label>
                    <div class="form-item short"><?=$destin_to_str?></div>
                </div>
                <div class="row">
                    <label for="weight">Weight of cargo, lbs:</label>
                    <div class="form-item"><?=$weight_car_str?></div>
                </div>
                <div class="row">
                    <label for="type">Container type:</label>
                    <?=$cont_type_str?>
                </div>
                <div class="row">
                    <label for="type">Num. of containers</label>
                    <?=$num_cont_str?>
                </div>
                <div class="row">
                    <label for="type">Additional info:</label>
                    <div class="form-textarea"><?=$adit_info_str?></div>
                </div>
				<input type="submit" value="Calculate" class="form-submit" name="web_form_submit">
            </fieldset>

<?=$arResult["FORM_FOOTER"]?>

<?
} //endif (isFormNote)
?>
