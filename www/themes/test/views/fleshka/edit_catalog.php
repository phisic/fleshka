<div style="float:left;margin-right:10px;"><b>Каталог: </b>

	<select id="catalog">
		<?php foreach($catalogs as $key => $catalog) : ?>

			<option value="<?php echo $catalog->id; ?>" <?php echo ($catalog->id==$relgoodcatalog->catalog_id)?'selected':'';?>>
				<?php echo $catalog->name; ?>
			</option>
		<?php endforeach; ?>
	</select>
		
</div>

	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>($rel_id>0?'Изменить':'Создать'), 
		'id' => 'save_catalog',
		'size' => 'mini')); 
	?>

	&nbsp;

	<?php

		if ($rel_id>0) {
			$this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Удалить',
				'type'=>'danger',
				'size'=>'mini',
				'htmlOptions'=>array(
					'onclick'=>'js:bootbox.confirm("Вы уверены?",
					function(confirmed){
						if (confirmed==true) {
							delete_catalog();
						}
					})'
				),
			));
		}
	?>

<script type="text/javascript">

	$(function() {

		$('#save_catalog').click(function() {
			save_catalog();
		})
	});

	function save_catalog()
	{
		var catalog_id = $('#catalog option:selected').val();

		var fleshka_id = <?php echo $fleshka_id; ?>;

		$.post('<?php echo Yii::app()->createUrl('fleshka/save_catalog') ?>', {
			fleshka_id: fleshka_id,
			rel_id: <?php echo $rel_id ?>,
			catalog_id: catalog_id
		}, function() {

			load_catalogs(fleshka_id);
		});
	}

	function delete_catalog()
	{
		var fleshka_id = <?php echo $fleshka_id; ?>;

		$.post('<?php echo Yii::app()->createUrl('fleshka/delete_catalog') ?>', {
			rel_id: <?php echo $rel_id ?>,
		}, function() {

			load_catalogs(fleshka_id);
		});

	}

</script>
