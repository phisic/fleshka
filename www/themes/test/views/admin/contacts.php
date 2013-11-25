<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'well'),
)); ?>
 
<?php echo $form->ckEditorRow($model, 'content', array('options'=>array('fullpage'=>'js:true', 'width'=>'800', 'height' => '600', 'resize_maxWidth'=>'800','resize_minWidth'=>'800')));?>
<br/>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); ?>
 
<?php $this->endWidget(); ?>