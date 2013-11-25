<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'well'),
)); ?>


<div style="margin-left:100px;">
Телефон1&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="phone1" value="<?php echo $phone1->content; ?>" style="width:600px;"/>
</div>
<br/>
 
<div style="margin-left:100px;">
Телефон2&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="phone2" value="<?php echo $phone2->content; ?>" style="width:600px;"/>
</div>
<br/>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); ?>
 
<?php $this->endWidget(); ?>

<?php if ($success) :?>
	<span class="label label-success">Успешно изменен</span>
<?php endif; ?>
