<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('enctype' => 'multipart/form-data', 'class'=>'well'),
)); ?>

<input type="hidden" name="id" value="<?php echo $catalog->id; ?>">

<?php echo $form->textFieldRow($catalog, 'name', array('class'=>'span3')); ?>
<?php echo $form->textFieldRow($catalog, 'header', array('class'=>'span3')); ?>
<?php echo $form->textFieldRow($catalog, 'index', array('class'=>'span3')); ?>

<?php echo $form->checkBoxRow($catalog, 'show', array('class'=>'span1')); ?>

<input type="file" name="my_image">
<?php if ($catalog->image!='') : ?>
	<img src="<?php echo Yii::app()->theme->baseUrl."/img/flash/".$catalog->image; ?>" width="100" heigh="100" alt=""/>
<?php endif; ?>
<br/><br/>

<?php echo $form->textAreaRow($catalog, 'description', array('class'=>'span10', 'rows'=>3)); ?>

<?php echo $form->checkBoxRow($catalog, 'date_apply', array('class'=>'span1')); ?>

<div id="my_dates">
<?php echo $form->datepickerRow($catalog, 'from_date',
        array('prepend'=>'<i class="icon-calendar"></i>', 'value' => ($catalog->from_date>0?date('d.m.Y', strtotime($catalog->from_date)):date('d.m.Y')), 'options' => array('format' => 'dd.mm.yyyy'))); ?>
<?php echo $form->datepickerRow($catalog, 'to_date',
        array('prepend'=>'<i class="icon-calendar"></i>', 'value' => ($catalog->to_date>0?date('d.m.Y', strtotime($catalog->to_date)):date('d.m.Y')), 'options' => array('format' => 'dd.mm.yyyy'))); ?>
</div>

<?php 
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'secondary', 'label'=>'Назад', 'url' => Yii::app()->createUrl("catalogs")));
echo '&nbsp;';
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); 
?>

<?php $this->endWidget(); ?>

<script type="text/javascript">

$(function() {

	check_date_apply();

	$('#Catalogs_date_apply').change(function() {

		check_date_apply();
	});
});

function check_date_apply()
{

	if ($('#Catalogs_date_apply').is(":checked")) {

		$('#my_dates').css('display', 'block');

	} else {

		$('#my_dates').css('display', 'none');
	}

}

</script>