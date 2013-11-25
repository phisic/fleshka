<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'well'),
)); ?>


<div style="margin-left:100px;">
300&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="price300" value="<?php echo $calculation['price300']; ?>" style="width:100px;"/>
</div>
<br/>
 
<div style="margin-left:100px;">
500&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="price500" value="<?php echo $calculation['price500']; ?>" style="width:100px;"/>
</div>
<br/>

<div style="margin-left:100px;">
1000&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="price1000" value="<?php echo $calculation['price1000']; ?>" style="width:100px;"/>
</div>
<br/>

<div style="margin-left:100px;">
Под заказ&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="price_zakaz" value="<?php echo $calculation['price_zakaz']; ?>" style="width:100px;"/>
</div>
<br/>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); ?>
 
<?php $this->endWidget(); ?>

<?php if ($success) :?>
	<span class="label label-success">Успешно изменен</span>
<?php endif; ?>
