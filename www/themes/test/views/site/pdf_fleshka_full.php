<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/pdf.css" />

<table style="background:#3986bc;width:100%;">
	<tr>
		<td>
			<img width="200" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/header.jpg"/>
		</td>
		<td align="right">
		  <?php
			$phone1 = Content::model()->find('name="phone1"');
			$phone2 = Content::model()->find('name="phone2"');
		  ?>
			<div class="phone">
				<?php echo $phone1->content; ?>
				<br/>
				<?php echo $phone2->content; ?>
			</div>

		</td>
	<tr>
</table>

<?php if (count($fleshkas)>0) : ?>

  <?php foreach($fleshkas as $fleshka ) :?>


		<?php
			$width_picture = 500;
			$height_picture = 300;
		?>

		<table>

			<tr>
				<td style="width:180px;"><b><?php echo $fleshka->name.' #'.$fleshka->id; ?></b></td>
				<td style="width:80px;"><b>Выбор цвета</b></td>
				<td style="width:100px;"><b>Выбор объема</b></td>
				<td style="width:100px;"><b>100 шт</b></td>
				<td style="width:100px;"><b>300 шт</b></td>
				<td style="width:100px;"><b>500 шт</b></td>
				<td style="width:100px;"><b>1000 шт</b></td>
				<td style="width:100px;"><b>под заказ</b></td>
				<td><b>в наличии</b></td>
			</tr>

			<tr>

				<!-- 1. rasm -->
				<td>

					<?php if (count($fleshka->colorprices[0]->photoss)>0) : ?>

						<?php $photo = $fleshka->colorprices[0]->photoss[0]; ?>

						<img width="250" src="<?php echo Yii::app()->urlManager->createUrl('/site/picture/'.$photo->id.'.jpg'); ?>"/>

					<?php endif; ?>

				</td>

				<!-- 3. vibor sveta -->
				<td>

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

									 $pass_array = base64_encode(serialize($color_));

										$my_color = 'url('.Yii::app()->createUrl('site/color', array('color' => $pass_array)).')';

									}
								?>

								<?php if ($pechat==1) : ?>

									<?php if (count($color_)==1) : ?>

										<div class="my_color_icon"
												style="width:<?php echo $width; ?>px;
														height:<?php echo $height; ?>px;
														background:<?php echo $my_color; ?>;">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</div>

									<?php else : ?>

										<div class="my_color_icon"
												style="width:<?php echo $width; ?>px;
														height:<?php echo $height; ?>px;">
														<img src="<?php echo Yii::app()->createUrl('site/color', array('color' => $pass_array)); ?>" alt=""/>
										</div>

									<?php endif ?>

								<?php endif; ?>


							<?php endif;?>

						<?php endforeach; ?>

					</div>

				</td>


				<!-- 3. vibor obyom -->
				<td>

					<div class="div_flesh_buttons" style="width:80px;">

							<!-- 2 gb-->
							<?php if ($fleshka->pricesize2>0): ?>

								<div>2 Gb</div>

							<?php endif; ?>

							<!-- 4 gb-->
							<?php if ($fleshka->pricesize4>0): ?>

								<div>4 Gb</div>

							<?php endif; ?>

							<!-- 8 gb-->
							<?php if ($fleshka->pricesize8>0): ?>

								<div>8 Gb</div>

							<?php endif; ?>

							<!-- 16 gb-->
							<?php if ($fleshka->pricesize16>0): ?>

								<div>16 Gb</div>

							<?php endif; ?>

							<!-- 32 gb-->
							<?php if ($fleshka->pricesize32>0): ?>

								<div>32 Gb</div>

							<?php endif; ?>

					</div>

				</td>




				<?php
					$calc = Content::model()->find('name="calculation"');

					$calculation = unserialize($calc->content);

					$pricesize2 = $fleshka->pricesize2;
					$pricesize4 = $fleshka->pricesize4;
					$pricesize8 = $fleshka->pricesize8;
					$pricesize16 = $fleshka->pricesize16;
					$pricesize32 = $fleshka->pricesize32;
				?>


				<td>

				<!-- 100 шт -->

					<div style="float:left;text-align:center;margin:10px 0 0 10px;">

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

				</td>



				<td>

					<!-- 300 шт -->
					<div style="float:left;text-align:center;margin-top:10px;">

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

				</td>



				<td>

					<!-- 500 шт -->
					<div style="float:left;text-align:center;margin-top:10px;">

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

				</td>

				<td>

					<!-- 1000 шт -->
					<div style="float:left;text-align:center;margin-top:10px;">

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

				</td>

				<td>

					<!-- pod zakaz -->
					<div style="float:left;text-align:center;margin-top:10px;">

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

				</td>



				<td>


					<!-- v nalichii -->
					<div style="float:left;text-align:center;margin-top:10px;">

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

				</td>

			</tr>

		</table>

		<?php if (trim($fleshka->description)!='') : ?>
			<!-- <div style="clear:both;"></div> -->
			<!-- <div class="my_description" style="padding-top:3px;background:#ECEFA9"><?php echo $fleshka->description; ?></div> -->
		<?php endif; ?>

	<?php endforeach; ?>

<?php endif; ?>

<?php
	Yii::app()->setGlobalState('top_menu', 'contact');

	$contact = Content::model()->find('name="contact"');

	echo $contact->content;
?>