<?php
/* @var $this SiteController */

$this->layout = '//layouts/column1';

?>


<?php

    $content = 'По запросу ничего не найдено';

    if (count($fleshkas)>0) {

        $content = '';

        $show_hints = 1;
        foreach($fleshkas as $fleshka_id) {

            $fleshka = Descriptionsize::model()->findByPk($fleshka_id);

            if (count($fleshka)==0) {

                $upakovka = Descriptionprice::model()->findByPk($fleshka_id);

                if ($show_hints==1) {

                    $content .= $this->renderPartial('pages/single_item_show1', array('upakovka'=>$upakovka, 'show_hints'=>1), true);
                    $show_hints = 0;

                } else {

                    $content .= $this->renderPartial('pages/single_item_show1', array('upakovka'=>$upakovka), true);

                }

            } else {

                if ($show_hints==1) {

                    $content .= $this->renderPartial('pages/single_item_show', array('fleshka'=>$fleshka, 'show_hints'=>1), true);

                    $show_hints = 0;
                } else {

                    $content .= $this->renderPartial('pages/single_item_show', array('fleshka'=>$fleshka), true);

                }

            }

        }
    }

    $this->widget('bootstrap.widgets.TbBox', array(
        'title' => 'Поиск "'.$searched_word.'"',
        //'headerIcon' => 'icon-home',
        'id' => 'my_flash_content',
        'content' => $content
    ));

?>

<div class="div_zakazat_fleshki" style="display:none;">
	<div class="zakazat_fleshki">
		<button class="id_my_button">Заказать флешки</button>&nbsp;<span></span>
	</div>
</div>

<?php
if (count($fleshka)>0 && count($fleshka->relgoodscatalogs)>0) {

    $this->widget('bootstrap.widgets.TbBox', array(
        'title' => 'Упаковки для флешек',
        //'headerIcon' => 'icon-home',
        'content' => $this->renderPartial('recommended_items', array('fleshka'=>$fleshka), true),
    ));
}
?>
