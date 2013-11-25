<?php if (count($new_items)>0) : 
	$new_item_id = 0; ?>

	<div style="height:370px;">
	<div id="load_new_item"></div>
	</div>
	<div style="clear:both;"></div>

	<?php foreach ($new_items as $relgoodscatalog) : ?>

		<?php $new_item = Descriptionsize::model()->findByPk($relgoodscatalog->goods_id);?>

		<?php 
			if ($new_item_id==0) {
				$new_item_id = $new_item->id;
			}
		?>

		<div class="single_cotainer" style="width:90px;height:90px;margin: 1px 1px 1px 1px">
			<div class="single_fleshka">
			    <a href="javascript:load_item(<?php echo $new_item->id; ?>);">
			    <!--<a href="<?php echo Yii::app()->urlManager->createUrl('/site/single_item', array('id' => $new_item->id));?>">-->
			    	<img width="90" src="data:image/jpeg;base64, <?php echo base64_encode( $new_item->colorprices[0]->photoss[0]->thumbnail ); ?>"/>
			    </a>
			</div>
			<!--<div class="single_text"><center><b><?php echo $new_item->name.' #'.$new_item->id;?></b></center></div>-->
		</div>

	<?php endforeach; ?>

<?php endif; ?>

<script type="text/javascript">

	$(function() {
		load_item(<?php echo $new_item_id; ?>)
	});

	function load_item(id)
	{
		$('#load_new_item').fadeOut('slow', function(){
		    $('#load_new_item').load("<?php echo Yii::app()->urlManager->createUrl('/site/single_new_item');?>", {
		    	id:id
		    }, function(){
		        $('#load_new_item').fadeIn('fast');
		    });
		});		

	}
</script>

