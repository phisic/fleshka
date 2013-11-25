<?php $color_group = 0; ?>
<div>
	<div style="float:left;">Цвета на картинке: </div>

	<div style="float:left;margin-right:7px;">
		<?php foreach($colorprices as $key => $color) : ?>

			<?php 

				$width = 30;
				$height = 20;
				$my_color = $color->colors->html;
				$color_group = $color->color_group;
			?>

			<div class="my_color_icon"
					colorprice_id="<?php echo $color->id;?>"
					style="width:<?php echo $width; ?>px;
							height:<?php echo $height; ?>px;
							background:<?php echo $my_color; ?>;">
				<!--<i class="icon-vector-path-square"></i>-->
			</div>

		<?php endforeach; ?>
	</div>

	<a style="cursor:pointer;" id="new_color_to_current">Добавить ещё один</a>
		
</div>

<div style="clear:both;"></div>

<div class="well edit_current_color" style="display:none;"></div>

<script type="text/javascript">

	$(function() {

		$('.update_color .my_color_icon').click(function() {

			$('.update_color .my_color_icon').css('border', '1px solid');

			$(this).css('border', '2px solid blue');

			var fleshka_id = <?php echo $fleshka_id; ?>;

			var colorprice_id = $(this).attr('colorprice_id');

			$('.edit_current_color').show();

			$('.edit_current_color').load('<?php echo Yii::app()->createUrl('fleshka/newColor'); ?>', {
				fleshka_id: fleshka_id,
				colorprice_id: colorprice_id
			});

		});

		$('#new_color_to_current').click(function() {

			var fleshka_id = <?php echo $fleshka_id; ?>;

			var colorprice_id = 0;

			var color_group = <?php echo $color_group; ?>;

			$('.edit_current_color').show();

			$('.edit_current_color').load('<?php echo Yii::app()->createUrl('fleshka/newColor'); ?>', {
				fleshka_id: fleshka_id,
				colorprice_id: colorprice_id,
				color_group: color_group
			});

		});

	});

</script>
