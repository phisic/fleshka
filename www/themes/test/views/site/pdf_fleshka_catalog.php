<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/pdf-catalog.css" />

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
		</tr>



</table>
 <table style="width:100%;">
 <tr>
		<td  align="center" style="font-size:26px;color:#005EBB; font-family:Arial;">
           <?php echo $catalog_name; ?>

		</td>
        </tr>

</table>
<div class="fleshkas_list">
<?php if (count($fleshkas)>0) : ?>

  <?php foreach($fleshkas as $fleshka ) :?>


		<?php
			$width_picture = 500;
			$height_picture = 200;
		?>

		<div class="item_class" >
		<table width="100%">

			<tr class="item_header">
				<td style="width:200px;"><b><?php echo $fleshka->name.' #'.$fleshka->id; ?></b></td>
				<td><b>Доступные цвета</b></td>
				<td ><b>Доступные объемы</b></td>
				</tr>

			<tr>

				<!-- 1. rasm -->
				<td valign="top">

					<?php if (count($fleshka->colorprices[0]->photoss)>0) : ?>

						<?php $photo = $fleshka->colorprices[0]->photoss[0]; ?>

						<img  height="<?php  echo $height_picture;?>" src="<?php echo Yii::app()->urlManager->createUrl('/site/picture/'.$photo->id.'.jpg'); ?>"/>

					<?php endif; ?>

				</td>

				<!-- 3. vibor sveta -->
				<td valign="top" align="left">



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

									$width = 60;
									$height = 40;


									if (count($color_)==1) {

										$my_color = $color_[0];

									} else {

									 $pass_array = base64_encode(serialize($color_));

										$my_color = 'url('.Yii::app()->createUrl('site/color', array('color' => $pass_array)).')';

									}
								?>

								<?php if ($pechat==1) : ?>

									<?php if (count($color_)==1) : ?>

										<span class="my_color_icon"
												style="width:<?php echo $width; ?>px;
														height:<?php echo $height; ?>px;
														background:<?php echo $my_color; ?>;">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</span>

									<?php else : ?>

										<span class="my_color_icon"
												style=" width:<?php echo $width; ?>px;
														height:<?php echo $height; ?>px;">
														<img src="<?php echo Yii::app()->createUrl('site/color', array('color' => $pass_array)); ?>" alt=""/>
										</span>

									<?php endif ?>

								<?php endif; ?>


							<?php endif;?>

						<?php endforeach; ?>



				</td>


				<!-- 3. vibor obyom -->
				<td valign="top">



							<!-- 2 gb-->
							<?php if ($fleshka->pricesize2>0): ?>

								<span class="flash_size">2Gb</span>

							<?php endif; ?>

							<!-- 4 gb-->
							<?php if ($fleshka->pricesize4>0): ?>

								<span class="flash_size">4Gb</span>

							<?php endif; ?>

							<!-- 8 gb-->
							<?php if ($fleshka->pricesize8>0): ?>

								<span class="flash_size">8Gb</span>

							<?php endif; ?>

							<!-- 16 gb-->
							<?php if ($fleshka->pricesize16>0): ?>

								<span class="flash_size">16Gb</span>

							<?php endif; ?>

							<!-- 32 gb-->
							<?php if ($fleshka->pricesize32>0): ?>

								<span class="flash_size">32Gb</span>

							<?php endif; ?>



				</td>


			</tr>

		</table>
        </div>


	<?php endforeach; ?>

<?php endif; ?>
</div>
<p style="clear:both">
<?php
	Yii::app()->setGlobalState('top_menu', 'contact');

	$contact = Content::model()->find('name="contact"');

	echo $contact->content;
?>
</p>