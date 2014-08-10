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

	<input type="hidden" value="<?php echo ($fleshka->id>0)?$fleshka->id:0; ?>" name="id">

	<?php echo $form->textFieldRow($fleshka, 'name', array('class'=>'span7')); ?>
	<?php echo $form->textFieldRow($fleshka, 'index', array('class'=>'span7')); ?>
	<?php echo $form->textFieldRow($fleshka, 'description', array('class'=>'span7')); ?>

	<?php echo $form->textFieldRow($fleshka, 'pricesize2', array('class'=>'span7')); ?>
		<?php echo $form->textFieldRow($fleshka, 'pricesize2_z', array('class'=>'span7')); ?>
	<?php echo $form->textFieldRow($fleshka, 'count2', array('class'=>'span7')); ?>

	<?php echo $form->textFieldRow($fleshka, 'pricesize4', array('class'=>'span7')); ?>
		<?php echo $form->textFieldRow($fleshka, 'pricesize4_z', array('class'=>'span7')); ?>
	<?php echo $form->textFieldRow($fleshka, 'count4', array('class'=>'span7')); ?>

	<?php echo $form->textFieldRow($fleshka, 'pricesize8', array('class'=>'span7')); ?>
		<?php echo $form->textFieldRow($fleshka, 'pricesize8_z', array('class'=>'span7')); ?>
	<?php echo $form->textFieldRow($fleshka, 'count8', array('class'=>'span7')); ?>

	<?php echo $form->textFieldRow($fleshka, 'pricesize16', array('class'=>'span7')); ?>
		<?php echo $form->textFieldRow($fleshka, 'pricesize16_z', array('class'=>'span7')); ?>
	<?php echo $form->textFieldRow($fleshka, 'count16', array('class'=>'span7')); ?>

	<?php echo $form->textFieldRow($fleshka, 'pricesize32', array('class'=>'span7')); ?>
		<?php echo $form->textFieldRow($fleshka, 'pricesize32_z', array('class'=>'span7')); ?>
	<?php echo $form->textFieldRow($fleshka, 'count32', array('class'=>'span7')); ?>
    
    <?php echo $form->textFieldRow($fleshka, 'pricesize64', array('class'=>'span7')); ?>
		<?php echo $form->textFieldRow($fleshka, 'pricesize64_z', array('class'=>'span7')); ?>
	<?php echo $form->textFieldRow($fleshka, 'count64', array('class'=>'span7')); ?>

	<?php echo $form->checkBoxRow($fleshka, 'instock'); ?>

	<?php echo $form->checkBoxRow($fleshka, 'is_new'); ?>

	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>($fleshka->id>0)?'Изменить':'Создать',
		'id' => 'save_it',
		'size' => 'mini'));
	?>

	&nbsp;

	<?php
	if ($fleshka->id>0) {
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

<?php if ($fleshka->id>0) : ?>

	<?php
	echo $this->renderPartial('color', array(
			'fleshka' => $fleshka,
		));
	?>

	<div id="div_catalogs">
		<?php
		echo $this->renderPartial('catalogs', array(
				'fleshka' => $fleshka,
			));
		?>
	</div>

	<div id="div_search">
		<?php
			echo $this->renderPartial('search', array(
					'fleshka' => $fleshka
				));
		?>
	</div>

<?php endif; ?>

<script type="text/javascript">

	$(function() {

		$('#save_it').click(function() {

			var form_data = $('#my_form').serialize();

			$.post('<?php echo Yii::app()->createUrl('fleshka/save'); ?>', form_data,
				function(data) {

					console.log(data);
					<?php if ($fleshka->id>0) : ?>
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
		<?php if ($fleshka->id>0) : ?>

			$.post('<?php echo Yii::app()->createUrl('fleshka/delete'); ?>', {
				id: <?php echo $fleshka->id; ?>
			}, function() {
				location.reload();
			});

			return false;

		<?php endif; ?>
	}

</script>