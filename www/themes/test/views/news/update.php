<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'well'),
)); ?>

<input type="hidden" name="id" value="<?php echo $id; ?>">

<?php echo $form->textFieldRow($model, 'title', array('class'=>'span3')); ?>
<br/>
<?php 
//echo $form->ckEditorRow($model, 'news', array('options'=>array('fullpage'=>'js:true', 'width'=>'800', 'height' => '600', 'resize_maxWidth'=>'800','resize_minWidth'=>'600')));
echo $form->textAreaRow($model, 'news', array('class'=>'span10', 'rows'=>15));

?>
<br/>

<?php 
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); 
?>

<?php $this->endWidget(); ?>



