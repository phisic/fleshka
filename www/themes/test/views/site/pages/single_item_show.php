<?php

if (isset($show_hints)) {
	// show hints
	  $hints = Hints::model()->findAll();

	  if (count($hints)>0) {

	    foreach($hints as $hint) {

	      echo '<div style="display:none;" id="hint_'.$hint->id.'"><b>'.$hint->title.'</b><br/>'.$hint->hints.'</div>';

	      $this->widget('bootstrap.widgets.TbButton', array(
	              'label'=>$hint->title,
	              'type'=>'info',
	              'size'=>'small',
	              'htmlOptions'=>array(
//	                'onclick'=>'js:bootbox.alert($("#hint_'.$hint->id.'").html())'
	                'onclick'=>'show_hint('.$hint->id.')'
	              ),
	            ));

	      echo ' ';

	    }
	    echo '<div class="my_hint" style="display:none;"></div>';
	  }
}
?>


<?php if (count($fleshka)==0) : ?>

		По запросу ничего не найдено

<?php else: ?>

<?php
	$width_picture = 300;
	$height_picture = 210;
?>

<div class="div_on_single_fleshka" style="padding-bottom:5px;margin-top:5px;display:table;">

	<ul class="single_item_li shapka">
		<li style="width:300px;"><?php echo $fleshka->name.' #'.$fleshka->id; ?></li>
		<li style="width:120px;">Выбор цвета</li>
		<li style="width:100px;">Выбор объема</li>
		<?php if (!$fleshka->is_special()) : ?>
			<li>100 шт</li>
			<li>300 шт</li>
			<li>500 шт</li>
			<li><div>1000 шт</div></li>
			<li><div>под заказ</div></li>
			<li><div>в наличии</div></li>
		<?php else: ?>
			<li>Цена</li>
			<li><div>в наличии</div></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		<?php endif; ?>
	</ul>

	<div class="id_single_fleshka">

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

		<div style="width:300px;display:table-cell;vertical-align:top;float:left;" id="parent_colorprice_<?php echo $fleshka->id;?>">
			<div id="show_colorprice_<?php echo $fleshka->id;?>">
				<?php
					$this->renderPartial('pages/single_item_photo', array(
						'fleshka' => $fleshka,
						'my_colorprice' => $photo_colorprice,
						'height' => $height_picture,
						'width' => $width_picture,
						'show_thumb' => 1
					));
				?>
			</div>		
		</div>

		<!-- fleshka colors -->

		<div class="fleshka_colors_div">

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

							$pass_array = serialize($color_);

							$my_color = 'url('.Yii::app()->createUrl('site/color', array('color' => $pass_array)).')';

						}
					?>

					<?php if ($pechat==1) : ?>

						<div class="my_color_icon"
								fleshka_id="<?php echo $fleshka->id; ?>"
								mycolorprice="<?php echo $key; ?>" 
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

		</div>

		<?php
			$calc = Content::model()->find('name="calculation"');

			$calculation = unserialize($calc->content);

			$pricesize2 = $fleshka->pricesize2;
			$pricesize4 = $fleshka->pricesize4;
			$pricesize8 = $fleshka->pricesize8;
			$pricesize16 = $fleshka->pricesize16;
			$pricesize32 = $fleshka->pricesize32;
		?>

		<div class="div_prices">

			<!-- 100 шт -->

			<div style="width:16%;float:left;text-align:center;margin:10px 0 0 10px;">

				<!-- 2 gb-->
				<?php if ($fleshka->pricesize2>1): ?>

					<div class="my_cost_div"><?php echo $pricesize2;?> руб</div>

				<?php endif; ?>
			
				<!-- 4 gb-->
				<?php if ($fleshka->pricesize4>1): ?>

					<div class="my_cost_div"><?php echo $pricesize4;?> руб</div>

				<?php endif; ?>

				<!-- 8 gb-->
				<?php if ($fleshka->pricesize8>1): ?>

					<div class="my_cost_div"><?php echo $pricesize8;?> руб</div>

				<?php endif; ?>

				<!-- 16 gb-->
				<?php if ($fleshka->pricesize16>1): ?>

					<div class="my_cost_div"><?php echo $pricesize16;?> руб</div>

				<?php endif; ?>

				<!-- 32 gb-->
				<?php if ($fleshka->pricesize32>1): ?>

					<div class="my_cost_div"><?php echo $pricesize32;?> руб</div>

				<?php endif; ?>
				
			</div>

			<?php if (!$fleshka->is_special()) : ?>

				<!-- 300 шт -->
				<div style="width:16%;float:left;text-align:center;margin-top:10px;">

					<!-- 2 gb-->
					<?php if ($fleshka->pricesize2>1): ?>

						<?php 
							if ($pricesize2 - $calculation['price300']>0) {

								$pricesize2 -= $calculation['price300'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize2; ?> руб</div>

					<?php endif; ?>
				
					<!-- 4 gb-->
					<?php if ($fleshka->pricesize4>1): ?>

						<?php 
							if ($pricesize4 - $calculation['price300']>0) {

								$pricesize4 -= $calculation['price300'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize4; ?> руб</div>

					<?php endif; ?>

					<!-- 8 gb-->
					<?php if ($fleshka->pricesize8>1): ?>

						<?php 
							if ($pricesize8 - $calculation['price300']>0) {

								$pricesize8 -= $calculation['price300'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize8;?> руб</div>

					<?php endif; ?>

					<!-- 16 gb-->
					<?php if ($fleshka->pricesize16>1): ?>

						<?php 
							if ($pricesize16 - $calculation['price300']>0) {

								$pricesize16 -= $calculation['price300'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize16;?> руб</div>

					<?php endif; ?>

					<!-- 32 gb-->
					<?php if ($fleshka->pricesize32>1): ?>

						<?php 
							if ($pricesize32 - $calculation['price300']>0) {

								$pricesize32 -= $calculation['price300'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize32;?> руб</div>

					<?php endif; ?>

				</div>

				<!-- 500 шт -->
				<div style="width:16%;float:left;text-align:center;margin-top:10px;">

					<!-- 2 gb-->
					<?php if ($fleshka->pricesize2>1): ?>

						<?php 
							if ($pricesize2 - $calculation['price500']>0) {

								$pricesize2 -= $calculation['price500'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize2; ?> руб</div>

					<?php endif; ?>
				
					<!-- 4 gb-->
					<?php if ($fleshka->pricesize4>1): ?>

						<?php 
							if ($pricesize4 - $calculation['price500']>0) {

								$pricesize4 -= $calculation['price500'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize4; ?> руб</div>

					<?php endif; ?>

					<!-- 8 gb-->
					<?php if ($fleshka->pricesize8>1): ?>

						<?php 
							if ($pricesize8 - $calculation['price500']>0) {

								$pricesize8 -= $calculation['price500'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize8; ?> руб</div>

					<?php endif; ?>

					<!-- 16 gb-->
					<?php if ($fleshka->pricesize16>1): ?>

						<?php 
							if ($pricesize16 - $calculation['price500']>0) {

								$pricesize16 -= $calculation['price500'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize16; ?> руб</div>

					<?php endif; ?>

					<!-- 32 gb-->
					<?php if ($fleshka->pricesize32>1): ?>

						<?php 
							if ($pricesize32 - $calculation['price500']>0) {

								$pricesize32 -= $calculation['price500'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize32; ?> руб</div>

					<?php endif; ?>

				</div>

				<!-- 1000 шт -->
				<div style="width:16%;float:left;text-align:center;margin-top:10px;">

					<!-- 2 gb-->
					<?php if ($fleshka->pricesize2>1): ?>

						<?php 
							if ($pricesize2 - $calculation['price1000']>0) {

								$pricesize2 -= $calculation['price1000'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize2; ?> руб</div>

					<?php endif; ?>
				
					<!-- 4 gb-->
					<?php if ($fleshka->pricesize4>1): ?>

						<?php 
							if ($pricesize4 - $calculation['price1000']>0) {

								$pricesize4 -= $calculation['price1000'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize4; ?> руб</div>

					<?php endif; ?>

					<!-- 8 gb-->
					<?php if ($fleshka->pricesize8>1): ?>

						<?php 
							if ($pricesize8 - $calculation['price1000']>0) {

								$pricesize8 -= $calculation['price1000'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize8; ?> руб</div>

					<?php endif; ?>

					<!-- 16 gb-->
					<?php if ($fleshka->pricesize16>1): ?>

						<?php 
							if ($pricesize16 - $calculation['price1000']>0) {

								$pricesize16 -= $calculation['price1000'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize16; ?> руб</div>

					<?php endif; ?>

					<!-- 32 gb-->
					<?php if ($fleshka->pricesize32>1): ?>

						<?php 
							if ($pricesize32 - $calculation['price1000']>0) {

								$pricesize32 -= $calculation['price1000'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize32; ?> руб</div>

					<?php endif; ?>

				</div>

				<!-- pod zakaz -->
				<div style="width:16%;float:left;text-align:center;margin-top:10px;">

					<!-- 2 gb-->
					<?php if ($fleshka->pricesize2>1): ?>

						<?php 
							if ($pricesize2 - $calculation['price_zakaz']>0) {

								$pricesize2 -= $calculation['price_zakaz'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize2; ?> руб</div>

					<?php endif; ?>
				
					<!-- 4 gb-->
					<?php if ($fleshka->pricesize4>1): ?>

						<?php 
							if ($pricesize4 - $calculation['price_zakaz']>0) {

								$pricesize4 -= $calculation['price_zakaz'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize4; ?> руб</div>

					<?php endif; ?>

					<!-- 8 gb-->
					<?php if ($fleshka->pricesize8>1): ?>

						<?php 
							if ($pricesize8 - $calculation['price_zakaz']>0) {

								$pricesize8 -= $calculation['price_zakaz'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize8; ?> руб</div>

					<?php endif; ?>

					<!-- 16 gb-->
					<?php if ($fleshka->pricesize16>1): ?>

						<?php 
							if ($pricesize16 - $calculation['price_zakaz']>0) {

								$pricesize16 -= $calculation['price_zakaz'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize16; ?> руб</div>

					<?php endif; ?>

					<!-- 32 gb-->
					<?php if ($fleshka->pricesize32>1): ?>

						<?php 
							if ($pricesize32 - $calculation['price_zakaz']>0) {

								$pricesize32 -= $calculation['price_zakaz'];
							}
						?>

						<div class="my_cost_div"><?php echo $pricesize32; ?> руб</div>

					<?php endif; ?>

				</div>

			<?php endif; ?>

			<!-- v nalichii -->
			<div style="width:16%;float:left;text-align:center;margin-top:10px;">

				<!-- 2 gb-->
				<?php if ($fleshka->pricesize2>0): ?>

					<div class="my_cost_div"><?php echo ($fleshka->count2>0)?$fleshka->count2:''; ?></div>

				<?php endif; ?>
			
				<!-- 4 gb-->
				<?php if ($fleshka->pricesize4>0): ?>

					<div class="my_cost_div"><?php echo ($fleshka->count4>0)?$fleshka->count4:''; ?></div>

				<?php endif; ?>

				<!-- 8 gb-->
				<?php if ($fleshka->pricesize8>0): ?>

					<div class="my_cost_div"><?php echo ($fleshka->count8>0)?$fleshka->count8:''; ?></div>

				<?php endif; ?>

				<!-- 16 gb-->
				<?php if ($fleshka->pricesize16>0): ?>

					<div class="my_cost_div"><?php echo ($fleshka->count16>0)?$fleshka->count16:''; ?></div>

				<?php endif; ?>

				<!-- 32 gb-->
				<?php if ($fleshka->pricesize32>0): ?>

					<div class="my_cost_div"><?php echo ($fleshka->count32>0)?$fleshka->count32:''; ?></div>

				<?php endif; ?>

			</div>

		</div>

		<div class="zakazat_fleshki" style="float:right;">
			<button class="id_my_button" flesh_id="<?php echo $fleshka->id; ?>">Заказать флешки</button>&nbsp;<span></span>
		</div>

		<?php if (trim($fleshka->description)!='') : ?>
			<!-- <div style="clear:both;"></div> -->
			<div class="my_description" style="padding-top:3px;background:#bcefaa"><?php echo $fleshka->description; ?></div>
		<?php endif; ?>


	</div>

</div>

<?php endif; ?>

<script type="text/javascript">
$(function() {

	<?php if ($fleshka->is_special()) : ?>

		// if it special item, put special logo
		$('#parent_colorprice_<?php echo $fleshka->id; ?>').append('<img style="position:absolute;top:2px;left:260px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/aksiya.gif"/>');

	<?php else : ?>	

		// if not special item, and it's new item, put new logo
		<?php if ($fleshka->is_new==1) : ?>
			$('#parent_colorprice_<?php echo $fleshka->id; ?>').append('<img style="position:absolute;top:2px;left:260px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/new.gif"/>');
		<?php endif; ?>

	<?php endif; ?>

});
</script>