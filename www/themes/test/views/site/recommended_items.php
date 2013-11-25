<?php

$all_catalog = '';
foreach($fleshka->relgoodscatalogs as $catalog) {

	if ($all_catalog=='') {
		$all_catalog = $catalog->catalog_id;
	} else {
		$all_catalog .= ','.$catalog->catalog_id;
	}
	
}

$width = Yii::app()->session['windowWidth'];
$limit = intval($width/220);

$sql = 'select descriptionprice.id as my_id 
		from descriptionprice
	 	where trash=0 and instock=1
		order by rand()
		limit '.$limit;

//echo $sql;
$items = Yii::app()->db->createCommand($sql)->query();

foreach ($items as $item) {
	if ($item['my_id']==$fleshka->id) continue;
	$recommended_items[] = Descriptionprice::model()->findByPk($item['my_id']);
}

?>
<?php if (count($recommended_items)>0) : ?>

	<?php foreach ($recommended_items as $item) : ?>
	  
		<div class="single_cotainer">
			<div class="single_fleshka">
			    <a href="<?php echo Yii::app()->urlManager->createUrl('/site/single_item', array('id' => $item->id));?>">
			    	<img src="data:image/jpeg;base64, <?php echo base64_encode( $item->colorprices[0]->photoss[0]->thumbnail ); ?>"/>
			    </a>
			</div>
			<div class="single_text"><center><b><?php echo $item->name.' #'.$item->id;?></b></center></div>
		</div>

	<?php endforeach; ?>
<?php endif; ?>