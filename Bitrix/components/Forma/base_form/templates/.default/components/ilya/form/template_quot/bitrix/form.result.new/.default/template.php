<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>
<?//print_r2($POST);?>


<?if ($arResult["isFormNote"] != "Y") 
{
?>

<?=$arResult["FORM_HEADER"]?>

<?
/***********************************************************************************
						form questions
***********************************************************************************/

foreach($arResult['QUESTIONS'] as $quest)
{
	$arr_quest[$quest['CAPTION']]=$quest['STRUCTURE']['0'];
}

$email=$arr_quest['Email'];
$num=$arr_quest['Container'];

$email_str='<input id="number" type="text" size="0" value="'.$email['VALUE'].'" name="form_email_'.$email['ID'].'">';
$num_str='<input type="text" value="'.$num['VALUE'].'" id="email" name="form_text_'.$num['ID'].'">';

//print_r2($email_str);
//print_r2($arResult);
?>

<fieldset>
	<div class="row">
		<label for="number">Container’s number:</label>
		<div class="form-item short"><?=$num_str?></div>
	</div>
	<div class="row">
		<label for="email">Email: <span>to get the answer</span></label>
		<div class="form-item"><?=$email_str?></div>
	</div>
	<input type="submit" value="Find" class="form-submit" name="web_form_submit">
</fieldset>

<?=$arResult["FORM_FOOTER"]?>

<?
} //endif (isFormNote)
?>
