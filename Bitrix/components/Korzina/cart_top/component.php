<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$TOV=getcartpr_top();//������ ������� � �������

//print_r2($TOV);
//���������� ������ ��� ����������

//����� �����
$summ_tov_all=0;//����� �����
$summ_with_skidka=0;//����� �����

//����������
$summ_with_ogr=0;//����� ������� ������������ �� ������ �������
$summ_no_ogr=0;//����� ������� ��� ������
$sobsh_skidka=0;//����� ������
$summ_with_skidka=0;
$procent_noogr=$arParams['PROCENTS'];//������� ��� ������� ��� �����������
$procent_ogr=5;//������� ��� ������� � ������������ �� ������

$kolvo_tov=count($TOV);


foreach($TOV as $id_tov=>$tov_cart)
{
    $summ_tov_all+=$tov_cart['PRICE']*$tov_cart['QUANTITY'];
    if($tov_cart['indic_real']=='Y')
        $summ_with_ogr+=$tov_cart['PRICE']*$tov_cart['QUANTITY'];
    if($tov_cart['indic_real']=='N')
        $summ_no_ogr+=$tov_cart['PRICE']*$tov_cart['QUANTITY'];
}

/*echo $summ_tov_all.'--- $summ_tov_all.<br>';
echo $summ_with_ogr.'--- $summ_with_ogr.<br>';
echo $summ_no_ogr.'--- $summ_no_ogr.<br>';*/

//����� ������� ��� ������� ������
if($summ_tov_all<10000)
{
    $sobsh_skidka=0;
    $summ_with_skidka=0;
}
elseif($summ_tov_all>=10000){    

    if($summ_tov_all>=10000 and $summ_tov_all<20000)
    {
        $index_sk=0;//����� ������ �� ������ ��� �����������
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
    $sum_sk_noogr=$summ_no_ogr/100*$procent_noogr[$index_sk];//����� ������ �� ������ ��� �����������
    $sobsh_skidka=$sum_sk_ogr+$sum_sk_noogr;
    $summ_with_skidka=$summ_tov_all-$sobsh_skidka;
}




$arResult=array('kolvo_tov'=>$kolvo_tov,'summ_with_skidka'=>$summ_with_skidka,'summ_tov_all'=>$summ_tov_all);

//����������� �������
$this->IncludeComponentTemplate();
?>
