<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
global $USER;
$summ_tov_all=number_format($arResult['summ_tov_all'], 0, ',', ' ');
$summ_with_skidka=number_format($arResult['summ_with_skidka'], 0, ',', ' ');;
$kolvo_tov=$arResult['kolvo_tov'];
$cur_page=$APPLICATION->GetCurPage();

$stat='out';//статус зарегестрированного пользователя
if(isset($_REQUEST['logout']) and $USER->IsAuthorized())
{
    $USER->Logout();
}

if(!$USER->IsAuthorized())
{
    $stat='in';//статус незарегистрированного пользователя
}
?>

    <div class="private slide-block">
        
        <span class="cab"> 
            
            <?if($stat=='out'){?>
                <a class="open-close" href="#">Личный кабинет</a>
            <?}else{?>
                <a href="/personal/index.php">Вход в магазин</a>
            <?}?>
            
        </span>
        <div class="block" style="display: none;">
                <span class="cab"><a class="open-close grey" href="#">Личный кабинет</a></span>
                <span class="add"><a href="/personal/basket.php">Корзина</a></span>
                <span class="add"><a href="/personal/index.php">Список заказов</a></span>
        </div>
        
        <span class="logout">
            <?if($stat=='out'){?>
               <a href="<?=$cur_page?>?logout=Y">Выйти</a>
            <?}else{?>
               <a href="/personal/index.php?register=yes">Регистрация</a>
            <?}?>
        </span>
    </div>  
    <h4><a href="/personal/basket.php">сейчас в корзине:</a></h4>
    
    <?if($summ_with_skidka==0){//если скидки нет?> 
    <p>
        <strong><?=$kolvo_tov?></strong> позиций стоимостью <?=$summ_tov_all?> руб.
    </p>
    <?}
    else{ 
    ?>
        <p>
            <strong><?=$kolvo_tov?></strong> позиций стоимостью <em><?=$summ_tov_all?> руб.</em>
        </p>
    <p>Цена со скидкой: <strong><?=$summ_with_skidka?></strong> руб.</p>

    <?}?>


