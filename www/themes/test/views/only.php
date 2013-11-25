<script src="js/infinitecarousel/jquery-1.7.1.min.js"></script>
<script src="js/infinitecarousel/jquery.infinitecarousel3.min.js"></script>
<!--<script type="text/javascript" src="easing.js"></script>-->
<link rel="stylesheet" href="js/infinitecarousel/infinitecarouser.css"/>

	<ul id="carousel">
		<li><a href="javascript:window.open('http://100zakazov.ru', '_blank')"><img width="520" height="150" alt="" src="images/1.jpg" /></a><p>Текст о рекламе <strong><em>HTML</em></strong>.</p></li>
		<li><a target="_blank" href="http://100zakazov.ru"><img width="520" height="150" alt="" src="images/2.jpg" /></a></li>
		<li><a target="_blank" href="http://100zakazov.ru"><img width="520" height="150" alt="" src="images/3.jpg" /></a></li>
		<li><a target="_blank" href="http://100zakazov.ru"><img width="520" height="150" alt="" src="images/4.jpg" /></a></li>
	</ul>

<script>
$(function(){
	$('#carousel').infiniteCarousel({
		imagePath: 'js/infinitecarousel/images/',
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
