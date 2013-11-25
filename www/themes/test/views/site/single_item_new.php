<div id="my_flash_content">
<?php

    if ($fleshka_id>0) {

        $content = '';

        $fleshka = Descriptionsize::model()->findByPk($fleshka_id);

        if (count($fleshka)==0) {

            $upakovka = Descriptionprice::model()->findByPk($fleshka_id);

            $this->renderPartial('pages/single_item_show1', array('upakovka'=>$upakovka));

        } else {

            $this->renderPartial('pages/single_item_show', array('fleshka'=>$fleshka));

        }

    }

?>

</div>

    <div class="div_zakazat_fleshki" style="display:none;">
        <div class="zakazat_fleshki">
            <button class="id_my_button">Заказать флешки</button>&nbsp;<span></span>
        </div>
    </div>
