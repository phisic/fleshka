<?php foreach ($popular_items as $popular_item) : ?>
  
	<div class="single_cotainer">
		<div class="single_fleshka">
		    <a href="<?php echo Yii::app()->urlManager->createUrl('/site/single_item', array('id' => $popular_item->fleshka_id));?>">
		    	<img src="data:image/jpeg;base64, <?php echo base64_encode( $popular_item->descriptionsize->colorprices[0]->photoss[0]->thumbnail ); ?>"/>
		    </a>
		</div>
		<div class="single_text"><center><b><?php echo $popular_item->descriptionsize->name.' #'.$popular_item->fleshka_id;?></b></center></div>
	</div>

<?php endforeach; ?>