<?php 
if (isset($contact_page) && $contact_page==1) {
	$content .= '<div id="'.Yii::app()->params['yandex_map_api'].'" style="width:600px;height:400px"></div>';
}
?>

<?php
	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => $title,
    //'headerIcon' => 'icon-home',
    'content' => $content
));
?>

<script type="text/javascript">

	$(function() {
		document.title = "<?php echo $title; ?>";
	});

</script>
