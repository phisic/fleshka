<style type="text/css">
	.current_color {
		height: auto;
		display: none;
		height:auto;
	}

	.fleshka_catalog {
		float:left;
		margin:0 5px 0 5px;
		cursor:pointer;
	}
</style>

<div class="well">

	<div>
		<div style="float:left;"><b>Цвета и фотографии флешки:</b> </div>

		<div style="float:left;margin-right:7px;">
			<?php foreach($fleshka->colorprices as $key => $color) : ?>

				<?php 
					// skip if not main color
					if ($color->id!=$color->color_group) {
						continue;
					}

					// defile colors
					// define more colors in single item
					$color_ = array();
					$color_[0] = $color->colors->html;
					$k = 1;

					foreach($fleshka->colorprices as $key1 => $color1) {

						if ($key==$key1) continue;

						if ($color->color_group==$color1->color_group) {

							$color_[$k++] = $color1->colors->html;
						}
					}

					$width = 30;
					$height = 20;


					if (count($color_)==1) {

						$my_color = $color_[0];

					} else {

						$pass_array = serialize($color_);

						$my_color = 'url('.Yii::app()->createUrl('site/color', array('color' => $pass_array)).')';

					}
				?>

				<div class="my_color_icon"
						fleshka_id="<?php echo $fleshka->id; ?>"
						mycolorprice="<?php echo $key; ?>" 
						colorprice_id="<?php echo $color->id;?>"
						style="width:<?php echo $width; ?>px;
								height:<?php echo $height; ?>px;
								background:<?php echo $my_color; ?>;">
					<!--<i class="icon-vector-path-square"></i>-->
				</div>

			<?php endforeach; ?>
		</div>

		<a style="cursor:pointer;" id="new_color">Новый цвет</a>
			
	</div>

	<div style="clear:both;"></div>

	<div class="current_color well"></div>

	<div class="update_color well" style="display:none;"></div>

	<div class="delete_color well" style="display:none;">
		<?php
			$this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Удалить цветовое решение',
				'type'=>'danger',
				'size'=>'mini',
				'htmlOptions'=>array(
					'onclick'=>'js:bootbox.confirm("Вы уверены?",
					function(confirmed){
						if (confirmed==true) {
							delete_color();
						}
					})'
				),
			));
		?>
	</div>

</div>

<script type="text/javascript">

	var colorprice_id = 0;

	$(function() {

		$('.my_color_icon').click(function() {

			$('.my_color_icon').css('border', '1px solid');

			$(this).css('border', '2px solid blue');

			var fleshka_id = $(this).attr('fleshka_id');

			var mycolorprice = $(this).attr('mycolorprice');

			colorprice_id = $(this).attr('colorprice_id');

			$('.current_color').show();
			$('.delete_color').show();
			$('.update_color').show();

			$('.current_color').load('<?php echo Yii::app()->createUrl('fleshka/showPhoto'); ?>', {
				fleshka_id: fleshka_id,
				mycolorprice: mycolorprice,
				colorprice_id: colorprice_id
			});

			$('.update_color').load('<?php echo Yii::app()->createUrl('fleshka/editColor'); ?>', {
				fleshka_id: fleshka_id,
				colorprice_id: colorprice_id
			});

		});

		$('#new_color').click(function() {

			$('.delete_color').hide();
			$('.update_color').hide();
			$('.current_color').show();
			$('.current_color').load('<?php echo Yii::app()->createUrl('fleshka/newColor'); ?>', {
				fleshka_id: <?php echo $fleshka->id; ?>
			});
		});

	});

	function delete_color()
	{
		var fleshka_id = <?php echo $fleshka->id; ?>

		$.post("<?php echo Yii::app()->createUrl('fleshka/delete_color'); ?>", {
			fleshka_id: fleshka_id,
			colorprice_id: colorprice_id
		}, function() {
			load_fleshka(fleshka_id);
		});
	}

</script>
