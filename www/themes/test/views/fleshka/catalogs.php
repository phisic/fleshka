<div class="well" id="id_fleshka_catalog">
	
	<b style="float:left;">Выводить в каталоги:</b>
	<?php foreach($fleshka->relgoodscatalogs as $key => $relgoodscatalog) : ?>

		<div class="fleshka_catalog" rel_id="<?php echo $relgoodscatalog->id; ?>"><?php echo $relgoodscatalog->catalog->name; ?></div>
	<?php endforeach; ?>
	<div class="fleshka_catalog" rel_id="0">Добавыть</div>

	<div style="clear:both;"></div>

	<div class="well edit_catalog" style="display:none;"></div>

</div>

<script type="text/javascript">
	$(function () {

		$('.fleshka_catalog').click(function() {

			$('.fleshka_catalog').css('background', 'none');

			$(this).css('background', 'blue');

			var rel_id = $(this).attr('rel_id');

			$('.edit_catalog').show();

			$('.edit_catalog').load('<?php echo Yii::app()->createUrl('fleshka/editCatalog'); ?>', {
				fleshka_id: <?php echo $fleshka->id; ?>,
				rel_id: rel_id,
			});
		});

	});

	function load_catalogs(fleshka_id)
	{
		$('#div_catalogs').load('<?php echo Yii::app()->createUrl('fleshka/catalogs'); ?>', {
			fleshka_id: fleshka_id
		});
	}
</script>