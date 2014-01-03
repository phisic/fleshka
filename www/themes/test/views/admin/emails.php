<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'well'),
)); ?>


<div style="margin-left:0px;vertical-align:top">
Список Email (новый email добавьте через запятую)&nbsp;&nbsp;&nbsp;&nbsp;
<textarea name="emaillist"  style="width:300px;height:100px"/><?php echo $emaillist->content; ?></textarea>
</div>
<br/>


<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); ?>

<?php $this->endWidget(); ?>

<?php if ($success) :?>
	<span class="label label-success">Успешно изменен</span>
<?php endif; ?>
