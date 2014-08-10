<?php
/* @var $this SiteController */

$this->layout = '//layouts/column1';

?>

<?php
  $width = 30;
  $height = 20;

  $colors[0] = '#FFFFFF';
  $colors[1] = '#FF0000';
  $colors[2] = '#0000FF';
  $colors[3] = '#008000';
  $colors[4] = '#FFFF00';
  $colors[5] = '#000000';
  $colors[6] = '#8B00FF';
  $colors[7] = '#87CEEB';
  $colors[8] = '#734A12';
  $colors[9] = '#808080';

switch ($my_type) {

	case 'in_stock':
		$show_type = 'в наличии';
		break;

	case 'to_order':
		$show_type = 'на заказ';
		break;

	default:
		$show_type = 'все';
		break;
}

?>

<div id="id_div_filtr" style="display:none;">

		<div style="float:left;line-height: 80%;">
			<h3><?php echo $catalog->name.'('.$show_type.')';?></h3>
			<div style="clear:both;"></div>
		</div>

		<div id="my_filtr_div" style="float:left;margin-top:5px;"><span style="float:left;">Фильтр по цвету: </span>

		    <div class="my_color_icon"
		      style="width:<?php echo $width; ?>px;
		              height:<?php echo $height; ?>px;"
		              onclick="location.href='<?php echo Yii::app()->urlManager->createUrl('/site/all_item', array('id' => $catalog->id, 'type' => $my_type)); ?>';">
		      <center>Все</center>
		    </div>

		  <?php foreach($colors as $key => $color) : ?>

		    <div class="my_color_icon div_my_id_color_<?php echo $key+1; ?>"
		      style="width:<?php echo $width; ?>px;
		              height:<?php echo $height; ?>px;
		              background:<?php echo $color; ?>;"
	          onclick="location.href='<?php echo Yii::app()->urlManager->createUrl('/site/all_filter_item', array('id' => $catalog->id, 'type' => $my_type, 'color_id' => ($key+1))); ?>';">
		    </div>

		  <?php endforeach; ?>

		&nbsp;


		</div>
		<?php if ($catalog->id!=1) : ?>
				<div class="head_text" style="float:left;margin-top:15px;">
					<a href="<?php echo Yii::app()->urlManager->createUrl('/site/all_item', array('id' => $catalog->id, 'type' => 'in_stock')); ?>" <?php echo (Yii::app()->session['type']=='in_stock'?'class="head_text_selected"':''); ?>>В наличии</a>
					<a href="<?php echo Yii::app()->urlManager->createUrl('/site/all_item', array('id' => $catalog->id, 'type' => 'to_order')); ?>" <?php echo (Yii::app()->session['type']=='to_order'?'class="head_text_selected"':''); ?>>На заказ</a>
				</div>
		<?php endif; ?>
</div>

<?php

	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => '',
    //$catalog->name.'('.$show_type.')',
    'id' => 'my_flash_content',
    //'headerIcon' => 'icon-home',
    'content' => $this->renderPartial('pages/all_item_show',
	array(
		'relgoodscatalogs' => $relgoodscatalogs, 
	    	'color_id' => $color_id, 
    		'catalog' => $catalog,
		'limit' => $limit,
		'limitAjax' => $limitAjax,
	    	'relgoodscatalog_upakovkas' => $relgoodscatalog_upakovkas
    	), true),
));
?>

<div class="last_div"></div>

<div class="div_zakazat_fleshki" style="display:none;">
	<div class="zakazat_fleshki">
		<button class="id_my_button">Заказать флешки</button>&nbsp;<span></span>
	</div>
</div>


<script type="text/javascript">

$(function() {

	$('.bootstrap-widget-header').css('height', '58px');
	$('.bootstrap-widget-header').html($('#id_div_filtr').html());

	$('#my_filtr_div .my_color_icon').click( function() {

		var color_id = $(this).attr('color_id');

	});

	<?php if ($color_id > 0) : ?>

		$('.div_my_id_color_<?php echo $color_id ?>').html('<i class="icon-ok" style="float:left;"></i>');

	<?php endif; ?>

});

</script>
