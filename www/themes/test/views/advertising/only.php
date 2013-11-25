<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/infinitecarousel/jquery.infinitecarousel3.min.js"></script>
<!--<script type="text/javascript" src="easing.js"></script>-->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/infinitecarousel/infinitecarouser.css"/>

	<?php if (count($advertising)>0) : ?>

		<ul id="carousel">
			<?php foreach($advertising as $adv) : ?>
					<li>
						<a href="javascript:window.open('<?php echo $adv->url; ?>', '<?php echo ($adv->blank==1)?'_blank':'_self'; ?>')">
							<img width="520" height="150" alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $adv->picture; ?>" alt=""/>
						</a>
						<p><?php echo $adv->text_advertising; ?></p>
					</li>
			<?php endforeach; ?>
		</ul>		
	<?php endif; ?>

<script type="text/javascript">
$(function(){
	$('#carousel').infiniteCarousel({
		imagePath: '<?php echo Yii::app()->request->baseUrl; ?>/js/infinitecarousel/images/',
		// transitionSpeed:300,
		// displayTime: 6000,
		// internalThumbnails: false,
		// thumbnailType: 'buttons',
		// customClass: 'myCarousel',
		// progressRingColorOpacity: '0,0,0,.9',
		// progressRingBackgroundOn: false,
		// margin: 10,
		// easeLeft: 'easeOutExpo',
		// easeRight:'easeOutQuart',
		// inView: 1,
		// advance: 1,
		 autoPilot: true,
		// prevNextInternal: true,
		 autoHideCaptions: true
	});

});
</script>
