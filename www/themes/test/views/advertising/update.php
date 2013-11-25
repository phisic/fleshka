<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'well', 'enctype'=>'multipart/form-data'),
)); ?>

<input type="hidden" name="id" value="<?php echo $id; ?>">

<?php echo $form->textFieldRow($model, 'text_advertising', array('class'=>'span8')); ?>
<br/>

<?php 
echo $form->fileFieldRow($model, 'picture', array('class'=>'span5')); 
?>
<br/>
<?php echo $form->textFieldRow($model, 'url', array('class'=>'span5')); ?>

<?php if($model->picture!='') : ?>
	<img src="<?php echo Yii::app()->request->baseUrl."/images/".$model->picture; ?>" alt=""/>
<?php endif; ?>
<br/>
<?php echo $form->checkboxRow($model, 'blank'); ?>
<br/>
<?php echo $form->checkboxRow($model, 'is_active'); ?>

<?php
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'secondary', 'label'=>'Назад', 'url' => Yii::app()->createUrl("advertising")));
echo '&nbsp;';
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); 
?>

<?php $this->endWidget(); ?>