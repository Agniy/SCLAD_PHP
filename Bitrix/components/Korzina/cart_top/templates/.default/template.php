<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
global $USER;
$summ_tov_all=number_format($arResult['summ_tov_all'], 0, ',', ' ');
$summ_with_skidka=number_format($arResult['summ_with_skidka'], 0, ',', ' ');;
$kolvo_tov=$arResult['kolvo_tov'];
$cur_page=$APPLICATION->GetCurPage();

$stat='out';//������ ������������������� ������������
if(isset($_REQUEST['logout']) and $USER->IsAuthorized())
{
    $USER->Logout();
}

if(!$USER->IsAuthorized())
{
    $stat='in';//������ ��������������������� ������������
}
?>

    <div class="private slide-block">
        
        <span class="cab"> 
            
            <?if($stat=='out'){?>
                <a class="open-close" href="#">������ �������</a>
            <?}else{?>
                <a href="/personal/index.php">���� � �������</a>
            <?}?>
            
        </span>
        <div class="block" style="display: none;">
                <span class="cab"><a class="open-close grey" href="#">������ �������</a></span>
                <span class="add"><a href="/personal/basket.php">�������</a></span>
                <span class="add"><a href="/personal/index.php">������ �������</a></span>
        </div>
        
        <span class="logout">
            <?if($stat=='out'){?>
               <a href="<?=$cur_page?>?logout=Y">�����</a>
            <?}else{?>
               <a href="/personal/index.php?register=yes">�����������</a>
            <?}?>
        </span>
    </div>  
    <h4><a href="/personal/basket.php">������ � �������:</a></h4>
    
    <?if($summ_with_skidka==0){//���� ������ ���?> 
    <p>
        <strong><?=$kolvo_tov?></strong> ������� ���������� <?=$summ_tov_all?> ���.
    </p>
    <?}
    else{ 
    ?>
        <p>
            <strong><?=$kolvo_tov?></strong> ������� ���������� <em><?=$summ_tov_all?> ���.</em>
        </p>
    <p>���� �� �������: <strong><?=$summ_with_skidka?></strong> ���.</p>

    <?}?>


