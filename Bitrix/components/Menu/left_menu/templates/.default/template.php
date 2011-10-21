<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die(); ?>

<div class="side-box">
    <div class="top">
        <div class="btm">
            <?
            $arr_h3 = array(
                'duch_obr' => '<h3 class="obrazovanie">Духовное образование</h3>',
                'duch_cht' => '<h3 class="chtenie">Духовное чтение, молитва,<br>богослужение</h3>',
                'hud_lit' => '<h3 class="literatura">Художественная литература</h3>',
                'nauka_jaziky' => '<h3 class="cultura">Культура, наука, философия,<br>языки</h3>',
                'christ_zizn' => '<h3 class="zhizn">Христианская жизнь<br>и современность</h3>'
            ); //h3 со стилями
            ?>

            <?
            foreach ($arResult as $key_razd => $val_razd) {
                $arr_razdela = array();
                if (!empty($val_razd)):
                    echo $arr_h3[$key_razd]; //выводим h3
                    echo '<ul class="subnav">';
                    foreach ($val_razd as $key => $val) {
                        $arr_razdela[] = $val['linc'];
                    }
//print_r2($arr_razdela);

                    for ($g = 0; $g < (count($arr_razdela)); $g++) {
                        if ($arr_razdela[$g]['level'] == 1)
                            echo '<li>';
                        elseif ($arr_razdela[$g]['level'] > $arr_razdela[$g - 1]['level'])
                            echo '<ul><li>';

                        echo '<a href="' . $arr_razdela[$g]['link'] . '">' . $arr_razdela[$g]['name'] . '</a>';

                        if ($arr_razdela[$g]['level'] == $arr_razdela[$g + 1]['level'] or ($arr_razdela[$g]['level'] == 1 and $g + 1 == count($arr_razdela)))
                            echo '</li>';
                        elseif ($g + 1 != count($arr_razdela) and $arr_razdela[$g]['level'] > $arr_razdela[$g + 1]['level']) {
                            $razn = $arr_razdela[$g]['level'] - $arr_razdela[$g + 1]['level'];
                            for ($t = 0; $t < $razn; $t++)
                                echo '</ul></li>';
                        } elseif ($g + 1 == count($arr_razdela)) {
                            $razn = $arr_razdela[$g + 1]['level'] - 1;
                            for ($t = 0; $t < $razn; $t++)
                                echo '</ul></li>';
                        };
                    }
                    echo '</ul>';
                endif;
            }
            ?>
        </div>
    </div>
</div>
<h4 class="download"><a href="#">загрузка Прайс-листов</a></h4>


