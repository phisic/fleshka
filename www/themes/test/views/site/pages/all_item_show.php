<?php

if (isset($catalog)) {
  $hints = HintsFleshka::model()->findAll('id_catalog='.$catalog->id);

  if (count($hints)>0) {

    foreach($hints as $hint) {

      if (count($hint->hints)>0) {

        echo '<div style="display:none;" id="hint_'.$hint->hints->id.'"><b>'.$hint->hints->title.'</b><br/>'.$hint->hints->hints.'</div>';

        $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>$hint->hints->title,
                'type'=>'info',
                'size'=>'small',
                'htmlOptions'=>array(
  //                'onclick'=>'js:bootbox.alert($("#hint_'.$hint->hints->id.'").html())'
                  'onclick'=>'show_hint('.$hint->hints->id.')'
                ),
              ));

        echo ' ';

      } 
    }

    echo '<div class="my_hint" style="display:none;"></div>';

  }
}

$last_flesh_id = 0;

// show fleshkas
if (count($relgoodscatalogs)>0) {

  foreach($relgoodscatalogs as $relgoodscatalog ) {

  	$fleshka = Descriptionsize::model()->findByPk($relgoodscatalog->goods_id);

    $this->renderPartial('pages/single_item_show', array('fleshka'=>$fleshka, 'color_id' => $color_id));

  	$last_flesh_id = $fleshka->id;
  }
} 

// show upakovkas
if (count($relgoodscatalog_upakovkas)>0) {

  foreach($relgoodscatalog_upakovkas as $relgoodscatalog ) {

    $upakovka = Descriptionprice::model()->findByPk($relgoodscatalog->goods_id);

    $this->renderPartial('pages/single_item_show1', array('upakovka'=>$upakovka, 'color_id' => $color_id));
  }  
} 

if (count($relgoodscatalogs)==0 && count($relgoodscatalog_upakovkas==0)) {
  echo 'К сожалению, по вашему запросу ничего не найдено';
}
?>

<script>

$(function() {

  //$('.div_on_single_fleshka:odd').addClass('even_single_item');  

  last_flesh_id = <?php echo $last_flesh_id; ?>;
  limit = <?php echo $limit ?  $limit : $_POST['limit']?>;
  limit_ajax = <?php echo $limitAjax ? $limitAjax : $_POST['limit_ajax'] ?>;


  $('#loading').remove();

});

var lastScrollTop = 0;

$(window).scroll(function(event){

   var st = $(this).scrollTop();
   if (st > lastScrollTop && scroll_on_process==0){
       // downscroll code

       if ($('.last_div').position().top<=(st+$(window).height()))
       {

          scroll_on_process = 1;

          elem = $('#my_flash_content');

          elem.append('<div id="loading"><img style="width:100px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/loading.gif"/></div>');

          $.post("<?php echo Yii::app()->urlManager->createUrl('/site/ajax_show_items'); ?>", {
            id: last_flesh_id,
	    limit: limit,
	    limit_ajax: limit_ajax,
            color_id: <?php echo $color_id; ?>
          }, function(data) {
              if (data=="0") {
                $('#loading').remove();
                return false;
              }
                elem.append(data);
                scroll_on_process = 0;
		  limit+=limit_ajax;
          });
       }

   } else {
      // upscroll code
   }
   lastScrollTop = st;
});

</script>
