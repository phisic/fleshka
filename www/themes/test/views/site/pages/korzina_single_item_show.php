<?php
	$width_picture = 200;
	$height_picture = 150;
?>

<div style="clear:both;"></div>

<span id="div_all_korzina_single_fleshka_<?php echo $fleshka->id;?>">

	<ul class="single_item_li shapka">
		<li style="width:200px;"><?php echo $fleshka->name.' #'.$fleshka->id; ?></li>
		<li style="width:120px;">Выбор цвета</li>
		<li style="width:140px;">Выбор объема</li>
	</ul>

	<div id="id_single_fleshka">

		<!-- fleshka photo -->
		<?php
			// if color filtered, apply it
			$photo_colorprice = 0;

			if ($color_id>0) {

				foreach($fleshka->colorprices as $key => $color) {

					if ($color_id == $color->colors->id && $color->id==$color->color_group) {

						$photo_colorprice = $key;
					}
				}
			}
		?>

		<div style="width:200px;display:table-cell;vertical-align:top;float:left;">
			<div id="show_colorprice_<?php echo $fleshka->id;?>">
				<?php
					$this->renderPartial('pages/single_item_photo', array(
						'fleshka' => $fleshka,
						'my_colorprice' => $photo_colorprice,
						'height' => $height_picture,
						'width' => $width_picture,
						'show_thumb' => 0
					));
				?>
			</div>
		</div>

		<!-- fleshka colors -->

		<div class="fleshka_colors_div" style="width:105px;">

			<?php if (count($fleshka->colorprices)>0) : ?>
				<?php foreach($fleshka->colorprices as $key => $color) : ?>

					<?php if (count($fleshka->colorprices[$key]->photoss)>0) : ?>

						<?php
							// defile colors
							// define more colors in single item
							$color_ = array();
							$color_[0] = $color->colors->html;
							$k = 1;

							// check if color filter exist
							if ($color_id>0 && $color_id!=$color->colors->id) {
								$pechat = 0;
							} else {
								$pechat = 1;
							}

							foreach($fleshka->colorprices as $key1 => $color1) {

								if ($key==$key1) continue;

								if ($color->color_group==$color1->color_group) {

									$color_[$k++] = $color1->colors->html;

									// filter color
									if ($color_id>0 && $color_id==$color1->colors->id) {
										$pechat = 1;
									}
								}
							}

							$width = 30;
							$height = 20;


							if (count($color_)==1) {

								$my_color = $color_[0];

							} else {

								 $pass_array = base64_encode(serialize($color_));

								$my_color = 'url('.Yii::app()->createUrl('site/color', array('color' => $pass_array)).')';

							}
						?>

						<?php if ($pechat==1) : ?>

							<div class="my_color_icon"
									fleshka_id="<?php echo $fleshka->id; ?>"
									mycolorprice="<?php echo $key; ?>"
									id="my_color_icon_<?php echo $color->id;?>"
									colorprice_id="<?php echo $color->id;?>"
									width_picture="<?php echo $width_picture; ?>"
									height_picture="<?php echo $height_picture; ?>"
									show_thumb="1"
									style="width:<?php echo $width; ?>px;
											height:<?php echo $height; ?>px;
											background:<?php echo $my_color; ?>;">
								<!--<i class="icon-vector-path-square"></i>-->
							</div>

						<?php endif; ?>


					<?php endif;?>

				<?php endforeach; ?>

			<?php endif; ?>

		</div>

		<div class="div_flesh_buttons" style="width:80px;">

				<!-- 2 gb-->
				<?php if ($fleshka->pricesize2>0): ?>

					<div class="my_unpressed"
							fleshka_volume="<?php echo $fleshka->id.'_2'; ?>">
						2 Gb
					</div>

				<?php endif; ?>

				<!-- 4 gb-->
				<?php if ($fleshka->pricesize4>0): ?>

					<div class="my_unpressed"
							fleshka_volume="<?php echo $fleshka->id.'_4'; ?>">
						4 Gb
					</div>

				<?php endif; ?>

				<!-- 8 gb-->
				<?php if ($fleshka->pricesize8>0): ?>

					<div class="my_unpressed"
							fleshka_volume="<?php echo $fleshka->id.'_8'; ?>">
						8 Gb
					</div>

				<?php endif; ?>

				<!-- 16 gb-->
				<?php if ($fleshka->pricesize16>0): ?>

					<div class="my_unpressed"
							fleshka_volume="<?php echo $fleshka->id.'_16'; ?>">
						16 Gb
					</div>

				<?php endif; ?>

				<!-- 32 gb-->
				<?php if ($fleshka->pricesize32>0): ?>

					<div class="my_unpressed"
							fleshka_volume="<?php echo $fleshka->id.'_32'; ?>">
						32 Gb
					</div>

				<?php endif; ?>
                
                <!-- 64 gb-->
				<?php if ($fleshka->pricesize64>0): ?>

					<div class="my_unpressed"
							fleshka_volume="<?php echo $fleshka->id.'_64'; ?>">
						64 Gb
					</div>

				<?php endif; ?>

		</div>

		<br/>

		<?php
			$this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Удалить',
				'type'=>'danger',
				'size'=>'mini',
				'htmlOptions'=>array(
					'onclick'=>'js:bootbox.confirm("Вы уверены?",
					function(confirmed){
						if (confirmed==true) {
							delete_korzina_flesh('.$fleshka->id.');
						}
					})'
				),
			));
		?>


	</div>

</span>
