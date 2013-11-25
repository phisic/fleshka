
<?php
if (isset($show_hints)) {
	// show hints
	  $hints = Hints::model()->findAll();

	  if (count($hints)>0) {

	    foreach($hints as $hint) {

	      echo '<div style="display:none;" id="hint_'.$hint->id.'">'.$hint->hints.'</div>';

	      $this->widget('bootstrap.widgets.TbButton', array(
	              'label'=>$hint->title,
	              'type'=>'info',
	              'size'=>'small',
	              'htmlOptions'=>array(
	                //'onclick'=>'js:bootbox.alert($("#hint_'.$hint->id.'").html())'
	                'onclick'=>'show_hint('.$hint->id.')'
	              ),
	            ));

	      echo ' ';

	    }
	    echo '<div class="my_hint" style="display:none;"></div>';
	  }
}
?>


<?php if (count($upakovka)==0) : ?>

		По запросу ничего не найдено

<?php else: ?>

<?php
	$width_picture = 300;
	$height_picture = 210;
?>

<div class="div_on_single_fleshka" style="padding-bottom:5px;margin-top:5px;display:table;">

	<ul class="single_item_li shapka">
		<li style="width:300px;"><?php echo $upakovka->name.' #'.$upakovka->id; ?></li>
		<li style="width:120px;">Выбор цвета</li>
		<?php if ($upakovka->is_custom_text==0) : ?>
			<?php if (!$upakovka->is_special()) : ?>
				<li>100 шт</li>
				<li>300 шт</li>
				<li>500 шт</li>
				<li><div>под заказ</div></li>
				<li><div>в наличии</div></li>			
			<?php else : ?>
				<li>Цена</li>
				<li><div>в наличии</div></li>
				<li></li>
				<li></li>
				<li></li>
			<?php endif; ?>
		<?php else : ?>
			<li>Описание</li>
		<?php endif; ?>
	</ul>

	<div class="id_single_fleshka">

		<!-- fleshka photo -->
		<?php
			// if color filtered, apply it
			$photo_colorprice = 0;

			if ($color_id>0) {

				foreach($upakovka->colorprices as $key => $color) {

					if ($color_id == $color->colors->id && $color->id==$color->color_group) {

						$photo_colorprice = $key;
					}
				}
			}
		?>

		<div style="width:300px;display:table-cell;vertical-align:top;float:left;" id="parent_colorprice_<?php echo $upakovka->id;?>">
			<div id="show_colorprice_<?php echo $upakovka->id;?>">
				<?php
					$this->renderPartial('pages/single_item_photo', array(
						'fleshka' => $upakovka,
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

			<?php foreach($upakovka->colorprices as $key => $color) : ?>

				<?php if (count($upakovka->colorprices[$key]->photoss)>0) : ?>

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
						
						foreach($upakovka->colorprices as $key1 => $color1) {

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
								fleshka_id="<?php echo $upakovka->id; ?>"
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

		<?php if ($upakovka->is_custom_text==0) : ?>

			<?php
				$price = $upakovka->price;
				$price300 = 5;
				$price500 = 5;
				$price_zakaz = 5;
			?>

			<div class="div_prices">

				<!-- 100 шт -->

				<div style="width:20%;float:left;text-align:center;margin-top:10px;">

					<?php if ($upakovka->price>0): ?>

						<div class="my_cost_div"><?php echo $price;?> руб</div>

					<?php endif; ?>
							
				</div>

				<?php if (!$upakovka->is_special()) : ?>

					<!-- 300 шт -->
					<div style="width:20%;float:left;text-align:center;margin-top:10px;">

						<?php if ($upakovka->price>0): ?>

							<?php 
								if ($price - $price300>0) {

									$price -= $price300;
								}
							?>

							<div class="my_cost_div"><?php echo $price; ?> руб</div>

						<?php endif; ?>
					
					</div>

					<!-- 500 шт -->
					<div style="width:20%;float:left;text-align:center;margin-top:10px;">

						<?php if ($upakovka->price>0): ?>

							<?php 
								if ($price - $price500>0) {

									$price -= $price500;
								}
							?>

							<div class="my_cost_div"><?php echo $price; ?> руб</div>

						<?php endif; ?>
					
					</div>

					<!-- podzakaz -->
					<div style="width:20%;float:left;text-align:center;margin-top:10px;">

						<?php if ($upakovka->price>0): ?>

							<?php 
								if ($price - $price_zakaz>0) {

									$price -= $price_zakaz;
								}
							?>

							<div class="my_cost_div"><?php echo $price; ?> руб</div>

						<?php endif; ?>
					
					</div>

				<?php endif; ?>

				<!-- v nalichii -->
				<div style="width:20%;float:left;text-align:center;margin-top:10px;">

					<?php if ($upakovka->count>0): ?>

						<div class="my_cost_div"><?php echo ($upakovka->count>0)?$upakovka->count:''; ?></div>

					<?php endif; ?>
				
				</div>

			</div>

		<?php else : ?>

			<div class="div_prices">		
				
				<?php echo nl2br($upakovka->custom_text); ?>

			</div>

		<?php endif; ?>

		<div class="zakazat_fleshki" style="float:right;">
			<button class="id_my_button" flesh_id="<?php echo $upakovka->id; ?>">Заказать флешки</button>&nbsp;<span></span>
		</div>

		<?php if (trim($upakovka->description)!='') : ?>
			<!-- <div style="clear:both;"></div> -->
			<div class="my_description" style="padding-top:3px;background:#bcefaa"><?php echo $upakovka->description; ?></div>
		<?php endif; ?>

	</div>

</div>

<?php endif; ?>

<script type="text/javascript">
$(function() {

	<?php if ($upakovka->is_special()) : ?>

		// if it special item, put special logo
		$('#parent_colorprice_<?php echo $upakovka->id; ?>').append('<img style="position:absolute;top:2px;left:260px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/aksiya.gif"/>');

	<?php else : ?>	

		<?php if ($upakovka->is_new==1) : ?>
			$('#parent_colorprice_<?php echo $upakovka->id; ?>').append('<img style="position:absolute;top:2px;left:260px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/new.gif"/>');
		<?php endif; ?>

	<?php endif; ?>		
});
</script>