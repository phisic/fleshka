<style type="text/css">
	.form-horizontal .control-group {
		margin-bottom: 3px;
	}
	.well{
		padding: 10px;
		margin-bottom: 5px;
		margin-top: 5px;
	}
	.alert {
		margin-bottom: 5px;
	}
</style>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'my_form',
    'htmlOptions'=>array('class'=>'well'),
    'type' => 'horizontal'
)); ?>

	<input type="hidden" value="<?php echo ($upakovka->id>0)?$upakovka->id:0; ?>" name="id">

	<?php echo $form->textFieldRow($upakovka, 'name', array('class'=>'span7')); ?>

	<?php echo $form->textFieldRow($upakovka, 'index', array('class'=>'span7')); ?>

	<?php echo $form->textFieldRow($upakovka, 'description', array('class'=>'span7')); ?>

	<?php echo $form->textFieldRow($upakovka, 'price', array('class'=>'span7')); ?>
	
	<?php echo $form->textFieldRow($upakovka, 'count', array('class'=>'span7')); ?>

	<?php echo $form->checkBoxRow($upakovka, 'instock'); ?>

	<?php echo $form->checkBoxRow($upakovka, 'is_new'); ?>	

	<?php echo $form->checkBoxRow($upakovka, 'is_custom_text'); ?>

	<?php echo $form->textAreaRow($upakovka, 'custom_text', array('class'=>'span7', 'rows' => 5)); ?>

	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>($upakovka->id>0)?'Изменить':'Создать', 
		'id' => 'save_it',
		'size' => 'mini')); 
	?>

	&nbsp;

	<?php
	if ($upakovka->id>0) {
		$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Удалить',
			'type'=>'danger',
			'size'=>'mini',
			'htmlOptions'=>array(
				'onclick'=>'js:bootbox.confirm("Вы уверены?",
				function(confirmed){
					if (confirmed==true) {
						delete_it();
					}
				})'
			),
		));
	}
	?>


<?php $this->endWidget(); ?>

<div id="status_message"></div>

<div id="status_info" style="display:none;">
	<?php
		Yii::app()->user->setFlash('success', '<strong>Успешно изменен!</strong>');
		$this->widget('bootstrap.widgets.TbAlert', array(
		    'block'=>false, // display a larger alert block?
		    'fade'=>true, // use transitions?
		    'closeText'=>'×', // close link text - if set to false, no close link is displayed
		    'alerts'=>array( // configurations per alert type
			    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
		    ),
		));		
	?>				
</div>

<?php if ($upakovka->id>0) : ?>

	<?php 
	echo $this->renderPartial('upakovkaColor', array(
			'upakovka' => $upakovka,
		));
	?>

	<div id="div_catalogs">
		<?php
		echo $this->renderPartial('upakovkaCatalogs', array(
				'upakovka' => $upakovka,
			));
		?>
	</div>

	<div id="div_search">
		<?php
			echo $this->renderPartial('upakovkaSearch', array(
					'upakovka' => $upakovka
				));
		?>
	</div>

<?php endif; ?>

<script type="text/javascript">

	$(function() {

		$('#save_it').click(function() {

			var form_data = $('#my_form').serialize();

			$.post('<?php echo Yii::app()->createUrl('fleshka/upakovkaSave'); ?>', form_data, 
				function(data) {

					console.log(data);
					<?php if ($upakovka->id>0) : ?>
						$('#status_message').html($('#status_info').html());
					<?php else: ?>
						reload_all_list();
						load_fleshka(data);
						//location.reload();
					<?php endif; ?>
					
				});
		});

	});

	function delete_it()
	{
		<?php if ($upakovka->id>0) : ?>

			$.post('<?php echo Yii::app()->createUrl('fleshka/UpakovkaDelete'); ?>', {
				id: <?php echo $upakovka->id; ?>
			}, function() {
				location.reload();
			});

			return false;

		<?php endif; ?>
	}

</script>