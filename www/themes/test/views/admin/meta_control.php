<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'well'),
)); ?>


<div style="margin-left:100px;">
Keywords&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="keywords" value="<?php echo $keywords->content; ?>" style="width:600px;"/>
</div>
<br/>
 
<?php echo $form->textAreaRow($description, 'content', array('class'=>'span8', 'rows'=>5, 'labelOptions' => array('label' => 'Description'))); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); ?>
 
<?php $this->endWidget(); ?>

<?php if ($success) :?>
	<span class="label label-success">Успешно изменен</span>
<?php endif; ?>
