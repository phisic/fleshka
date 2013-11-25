<?php 
//echo count($fleshka->colorprices);
while (count($fleshka->colorprices[$my_colorprice]->photoss)==0 && $my_colorprice<count($fleshka->colorprices)) {
	$my_colorprice++;
}
?>

<?php if (count($fleshka->colorprices[$my_colorprice]->photoss)>0) :?>

	<div style="width:<?php echo $width;?>px;height:<?php echo $height; ?>px;/*border: 1px solid #E9E9E9;*/" id="big_image_<?php echo $fleshka->id;?>">
		<!-- <img src="data:image/jpeg;base64, <?php echo base64_encode( $fleshka->colorprices[$my_colorprice]->photoss[0]->thumbnail);?>"/> -->
		<img src="<?php echo Yii::app()->urlManager->createUrl('/site/picture/'.$fleshka->colorprices[$my_colorprice]->photoss[0]->id.'.jpg'); ?>" alt=""/>
	</div>

<?php endif; ?>

<?php if (isset($show_thumb) && $show_thumb==1) :?>

	<?php if (count($fleshka->colorprices[$my_colorprice]->photoss)>1) : ?>

		<?php foreach ($fleshka->colorprices[$my_colorprice]->photoss as $key => $photo) : ?>
		  
			<div class="single_fleshka_thumb">
			    <a fleshka_id="<?php echo $fleshka->id; ?>">
			    	<!-- <img src="data:image/jpeg;base64, <?php echo base64_encode( $photo->thumbnail ); ?>"/> -->
			    	<img src="<?php echo Yii::app()->urlManager->createUrl('/site/picture/'.$photo->id.'.jpg'); ?>" alt=""/>
			    </a>
			</div>

		<?php endforeach; ?>

	<?php endif; ?>

<?php endif;?>
