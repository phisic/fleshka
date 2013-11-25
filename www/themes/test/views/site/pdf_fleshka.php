
<?php if (count($fleshkas)>0) : ?>

  <?php foreach($fleshkas as $fleshka ) :?>

		<?php if (count($fleshka->colorprices[0]->photoss)>0) : ?>

				<?php $photo = $fleshka->colorprices[0]->photoss[0]; ?>

		    	<!-- <img src="data:image/jpeg;base64, <?php echo base64_encode( $photo->thumbnail ); ?>"/> -->
		    	<img src="<?php echo Yii::app()->urlManager->createUrl('/site/picture/'.$photo->id.'.jpg'); ?>" alt=""/>

			  	<?php echo '#'.$fleshka->id; ?>

		<?php endif; ?>

	<?php endforeach; ?>

<?php endif; ?>
