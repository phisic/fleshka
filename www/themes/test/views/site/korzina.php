<?php
$this->layout = '//layouts/column1';
?>

<?php
// echo '<br/>korzina_fleshkas<br/>';print_r(Yii::app()->session['korzina_fleshkas']);
// echo '<br/>korzina_volume<br/>';print_r(Yii::app()->session['korzina_volume']);
// echo '<br/>korzina_color<br/>';print_r(Yii::app()->session['korzina_color']);
//	echo '<br/>korzina_color<br/>';print_r(Yii::app()->session['korzina_logos']);
?>

<?php
	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'Корзина',
    'id' => 'my_flash_content',
    //'headerIcon' => 'icon-home',
    //'content' => $this->renderPartial('pages/korzina_all_item_show', array('relgoodscatalogs' => $relgoodscatalogs, 'color_id' => $color_id, 'order_id' => $order_id, 'error' => $error), true)
    'content' => $this->renderPartial('pages/korzina_all_item_show', array('order_id' => $order_id, 'error' => $error), true)
));
?>

<?php
$fleshkas = Yii::app()->session['korzina_fleshkas'];
if (count($fleshkas)>0) {
	foreach($fleshkas as $key => $fleshka) {
		$fleshka_id = $key;
	}

	$fleshka = Descriptionsize::model()->findByPk($fleshka_id);

	if (count($fleshka)>0 && count($fleshka->relgoodscatalogs)>0) {

		$this->widget('bootstrap.widgets.TbBox', array(
		    'title' => 'Упаковки для флешек',
		    'content' => $this->renderPartial('recommended_items', array('fleshka'=>$fleshka), true)
		));	
	}
}

?>

<script type="text/javascript">

$(function() {

	$('#my_filtr_div .my_color_icon').click( function() {

		var color_id = $(this).attr('color_id');

	});

	<?php if ($color_id > 0) : ?>

		$('#div_my_id_color_<?php echo $color_id ?>').html('<i class="icon-ok"></i>');

	<?php endif; ?>

});

</script>
