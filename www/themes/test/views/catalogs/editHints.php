<?php
$this->layout = '//layouts/admin';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inlineForm',
	'type'=>'horizontal',
	'htmlOptions'=>array('enctype' => 'multipart/form-data', 'class'=>'well', 'action' => Yii::app()->createUrl('catalogs/createHints')),
)); ?>

<input type="hidden" name="id" value="<?php echo $hints->id; ?>">

<?php echo $form->textFieldRow($hints, 'title', array('class'=>'span3')); ?>
<?php echo $form->textAreaRow($hints, 'hints', array('class'=>'span10', 'rows'=>3)); ?>

<div style="float:left;width:300px;">
	<?php
	$i = 1;
	foreach($catalogs as $catalog) {

		if ($i>count($catalog)/3) {
			echo '</div>';
			echo '<div style="float:left;width:300px;">';
		}

		if ($hints->id>0) {
			$hints_fleshka = HintsFleshka::model()->find('id_hints='.$hints->id.' and id_catalog='.$catalog->id);
		}

		echo '<input type="checkbox" name="catalog['.$catalog->id.']" catalog="'.$catalog->id.'" '.(count($hints_fleshka)>0?'checked':'').'> '.$catalog->name;
		echo '<br/>';
		$i++;
	}
	?>
</div>

<div style="clear:both;"></div>

<br/>

<?php 
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'secondary', 'label'=>'Назад', 'url' => Yii::app()->createUrl("catalogs/hints")));
echo '&nbsp;';
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Сохранить')); 
?>

<?php $this->endWidget(); ?>

<script type="text/javascript">

$(function() {

});

</script>