<select id="fleshka_color">
<?php foreach ($colors as $key => $color) : ?>

	<option value="<?php echo $color->id; ?>" <?php echo ($color_id==$color->id)?'selected':''; ?>>
		<?php echo $color->name; ?>
	</option>

<?php endforeach; ?>

</select>

	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>($color_id>0?'Изменить':'Создать'), 
		'id' => 'save_color',
		'size' => 'mini')); 
	?>

	&nbsp;

	<?php
		// $this->widget('bootstrap.widgets.TbButton', array(
		// 	'label'=>'Удалить',
		// 	'type'=>'danger',
		// 	'size'=>'mini',
		// 	'htmlOptions'=>array(
		// 		'onclick'=>'js:bootbox.confirm("Вы уверены?",
		// 		function(confirmed){
		// 			if (confirmed==true) {
		// 				delete_it();
		// 			}
		// 		})'
		// 	),
		// ));
	?>

<script type="text/javascript">
$(function() {

	$('#save_color').click(function() {

		var colorprice_id = <?php echo $colorprice_id; ?>;

		var color_id = $('#fleshka_color option:selected').val();

		var fleshka_id = <?php echo $fleshka_id; ?>;
		
		$.post('<?php echo Yii::app()->createUrl('fleshka/saveColor'); ?>', {

			color_id: color_id,
			colorprice_id: colorprice_id,
			fleshka_id: fleshka_id,
			color_group: <?php echo $color_group; ?>,

		}, function() {
			load_fleshka(fleshka_id);
		});
	});
});
</script>