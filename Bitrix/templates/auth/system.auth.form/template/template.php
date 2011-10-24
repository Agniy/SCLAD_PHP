<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arResult["FORM_TYPE"] == "login"):?>

<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>
    
<form method="post" target="_top" id="form_auth" action="<?= $arResult["AUTH_URL"] ?>">

        <? if ($arResult["BACKURL"] <> ''): ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
        <? endif ?>
        <? foreach ($arResult["POST"] as $key => $value): ?>
            <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
        <? endforeach ?>
        <input type="hidden" name="AUTH_FORM" value="Y" />
        <input type="hidden" name="TYPE" value="AUTH" />




    <label class="l">e-mail или логин:</label>
    <input type="text" class="txt" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>"/>
    <label class="l">Пароль:</label>
    <input type="password" class="txt" name="USER_PASSWORD" maxlength="50" size="17" />
    <div>
            <input type="checkbox" class="ch" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" />
            <label for="ch">Запомнить меня</label>
    </div>
    <div>
            <input type="image" id="but_auth" class="butt" src="/images/btn-enter.png">
            <!--<input type="submit" class="butt" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />-->
            <input type="image" id="but_skip" class="butt" src="/images/btn-skip.png">
    </div>

</form>


<?endif?>