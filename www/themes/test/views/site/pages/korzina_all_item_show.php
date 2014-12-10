<style type="text/css">
.right_korzina {
    overflow: hidden;
    min-height: 50px;
    padding-left: 20px;
}

.left_korzina {
    float: left;
    width: 400px;
    min-height: 50px;
}

.inside_ul{
  list-style: none;
}

.inside_ul li {
  display: inline;
}

.outsite_ul {
  list-style: none;
}

.date {
  font-style: italic;
  font-size: 12px;
  text-align: right;
}

</style>

<!--
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/jqueryui/css/jquery.ui.all.css">
-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jqueryui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jqueryui/jquery.ui.datepicker.js"></script>

<!-- show new order in head -->
<div id="id_div_filtr" style="display:none;">

    <div style="float:left;"><h3>Корзина</h3></div>

    <?php if (isset(Yii::app()->session['user_id'])) : ?>

      <?php 
        $current_user = Yii::app()->session['user'];
        $username = $current_user->username;
      ?>

      <div style="float:right; margin: 6px 8px 0 0px;">
        <b><?php echo $username; ?></b>
        <a href="<?php echo Yii::app()->createUrl('/site/managerLogout', array('order_id'=>$order_id)); ?>">Выход</a>
      </div>

    <?php else : ?>

      <div style="float:right; margin: 6px 8px 0 0px;">
        <?php
          $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'primary',
            'label'=>'Новый оптовый запрос', 
            'id' => 'new_korzina',
            'size' => 'small')); 
        ?>
      </div>
    <?php endif; ?>

</div>

<?php
// show hints
  $hints = Hints::model()->findAll();

  if (count($hints)>0) {

    foreach($hints as $hint) {

      echo '<div style="display:none;" id="hint_'.$hint->id.'"><b>'.$hint->title.'</b><br/>'.$hint->hints.'</div>';

      $this->widget('bootstrap.widgets.TbButton', array(
              'label'=>$hint->title,
              'type'=>'info',
              'size'=>'small',
              'htmlOptions'=>array(
                //'onclick'=>'js:bootbox.alert($("#hint_'.$hint->id.'").html())'
                'onclick'=>'show_hint('.$hint->id.')'
              ),
            ));

      echo ' ';

    }

    echo '<div class="my_hint" style="display:none;"></div>';
  }
?>

<div style="clear:both;height:10px;"></div>

<?php
  if ($order_id!='0') {
    $order = Morder::model()->find('order_id="'.$order_id.'"');
  }
?>


<div class="left_korzina">

  <div style="padding-left:10px;background:#BCEFA9;border-radius:5px;display:table;">
      <form enctype="multipart/form-data" method="POST" action="<?php echo Yii::app()->createUrl('site/save_orders'); ?>" id="korzina_form">

<!--

        <b>Опции заказа:</b>

        <div id="interval_div">
          Срок сдачи заказа: 
          <a href="#" id="id_ot"><?php echo (count($order)>0&&$order->date_expire!=''?date('d.m.Y', strtotime($order->date_expire)):'от') ?></a><span id="ot_div"></span><input type="hidden" name="id_ot_text" id="id_ot_text">
          -
          <a href="#" id="id_do"><?php echo (count($order)>0&&$order->date_expire!=''?date('d.m.Y', strtotime($order->date_expire_to)):'до') ?></a><span id="do_div"></span><input type="hidden" name="id_do_text" id="id_do_text">
        </div>

        <p>
          Способ доставки: 
          <select name="delivery" id="delivery">
            <option value="0" <?php echo (count($order)>0&&$order->delivery=='0'?'selected':'') ?>>Курьером</option>
            <option value="1" <?php echo (count($order)>0&&$order->delivery=='1'?'selected':'') ?>>Самовывоз</option>
         </select>
       </p>
-->
        <?php if (count($order)>0) : ?>

          <?php if ($order->company=='' && !isset(Yii::app()->session['user_id'])) : ?>
              <p><b>Данные о вашей компании</b></p>
              Спасибо за ваш заказ! Пока вы ожидаете ответа менеджера, заполните данные о вашей компании.
              <ul class="outsite_ul">
                <li>
                  <div style="float:left;width:100px;"><b>Email:</b></div><div><?php echo $order->email; ?></div>
                </li>
                <li>
                  <?php if (isset($error['company'])) echo '<div class="error">'.$error['company'].'</div>'; ?>                  
                  <div style="float:left;width:100px;"><b>Название:</b></div><div><input name="company" value="" type="text"></div>
                </li>
                <li>
                  <?php if (isset($error['phone'])) echo '<div class="error">'.$error['phone'].'</div>'; ?>
                  <div style="float:left;width:100px;"><b>Телефон:</b></div><div><input name="phone" value="" type="text"></div>
                </li>
                <li>
                  <?php if (isset($error['address'])) echo '<div class="error">'.$error['address'].'</div>'; ?>                  
                  <div style="float:left;width:100px;"><b>Адрес:</b></div><div><input name="address" value="" type="text"></div>
                </li>            
              </ul>
              <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">

              <?php
              $this->widget('bootstrap.widgets.TbButton', array(
                'icon'=>'icon-ok-sign',
                'htmlOptions'=>array('class'=>'pull-right'),
                'label'=>'Сохранить данные', 
                'id' => 'save_data',
                'size' => 'small')); 
              ?>
          <?php else: ?>

            <p><b>Данные о компании</b></p>
            <ul class="outsite_ul">
              <li>
                <div style="float:left;width:100px;"><b>Email:</b></div><div><?php echo $order->email; ?></div>
              </li>

              <?php if ($order->company!='') : ?>

                <li>
                  <div style="float:left;width:100px;"><b>Название:</b></div><div><?php echo $order->company; ?></div>
                </li>
                <li>
                  <div style="float:left;width:100px;"><b>Телефон:</b></div><div><?php echo $order->phone; ?></div>
                </li>
                <li>
                  <div style="float:left;width:100px;"><b>Адрес:</b></div><div><?php echo $order->address; ?></div>
                </li>
              <?php endif; ?>
            </ul>

          <?php endif; ?>

        <?php else : ?>
         <p><b>Комментарий к заказу</b></p>
         <textarea name="comment" class="comment" style="height: 76px;width:365px;margin-right:10px;"><?php echo (isset($error['comment_value'])?$error['comment_value']:''); ?></textarea>
         <p><b>Ваш email</b></p>
         <?php if (isset($error['email'])) echo '<div class="error">'.$error['email'].'</div>'; ?>
         <input name="email" value="<?php echo (isset($error['email_value'])?$error['email_value']:''); ?>" type="text" class="email">
         <p>на него к вам придет ответ нашего менеджера</p>
         <?php if (isset($error['code'])) echo '<div class="error">'.$error['code'].'</div>'; ?>
         <p><img src="/site/captcha"> <input name="code" style="width:75px;" type="text"></p>
         <p>введите код с картинки</p>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
          'icon'=>'icon-hand-right',
          'htmlOptions'=>array('class'=>'pull-right'),
          'label'=>'Отправить заказ', 
          'id' => 'send_order',
          'size' => 'small')); 
        ?>
      <?php endif; ?>

      </form>
  </div>

  <?php if (count($order)>0) : ?>
    <br/>
    <p><b>Общение с менеджером</b></p>
    <?php 
      $comments = $order->comments;

      if (count($comments)>0) {
        $i = 1;
        foreach($comments as $comment) : ?>
          <div style="padding:0 0 5px 10px;background:<?php echo ($i%2==1)?'#ECEFA9':'#BCEFA9'; ?>;border-radius:5px;display:table;width:400px;">
            <?php 
              if ($comment->manager_id>0) {
                $user = User::model()->findByPk($comment->manager_id);
                $user_info = '<span style="display:none;">,<br/>email: '.$user->email.($user->phone!=''?', <br/>телефон: '.$user->phone:'').($user->skype!=''?', <br/>skype: '.$user->skype:'').($user->icq!=''?', <br/>icq: '.$user->icq:'').'</span>';
              }
            ?>            
            <p class="date"><?php echo get_rus_date($comment->date_created).($comment->manager_id>0?', менеджер '.$user->fio.$user_info.' <a href="javascript:void(0);" class="click_user">Еще</a>':', '.$order->company); ?></p>
            <?php echo $comment->comment; ?>
          </div>

        <?php 
        $i++;
        endforeach; 
      }
    ?>
  <?php endif; ?>

  <?php if (count($order)>0) : ?>

    <?php
      // define manager of customer
      $manager_id = (isset(Yii::app()->session['user_id'])?Yii::app()->session['user_id']:0);
    ?>
    <form method="POST" action="<?php echo Yii::app()->createUrl('site/reply_comment'); ?>" id="reply_form">  
      <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
      <input type="hidden" name="manager_id" value="<?php echo $manager_id; ?>">
      <textarea name="comment" class="comment" style="height: 76px;width:400px;"></textarea>
      <?php
      $this->widget('bootstrap.widgets.TbButton', array(
        'icon'=>'icon-hand-right',
        'htmlOptions'=>array('class'=>'pull-right'),
        'label'=>'Ответить', 
        'id' => 'reply_comment',
        'size' => 'small')); 
      ?>
    </form>
  <?php endif; ?>

  <br/>
  <p><b>Нанесение лого:</b></p>
  <?php
    if ($order_id!='0') {

      $logos = Logos::model()->findAll('order_id="'.$order_id.'"');

      if (count($logos)>0) {
        foreach ($logos as $logo) {
          echo '<a href="'.Yii::app()->createAbsoluteUrl('site/file_download',array('name'=>$logo->logo_name)).'" title="Скачать файл">'.$logo->logo_name.'</a><br/>';
          //echo '<img src="'.Yii::app()->request->baseUrl.'/logos/'.$logo->logo_name.'" width="100"/>';
        }
      }

    } else {

      $logos = Yii::app()->session['korzina_logos'];

      if (count($logos)>0) {
        foreach ($logos as $logo) {
          echo '<a href="'.Yii::app()->createAbsoluteUrl('site/file_download',array('name'=>$logo)).'" title="Скачать файл">'.$logo.'</a><br/>';
          //echo '<img src="'.Yii::app()->request->baseUrl.'/logos/'.$logo.'" width="100"/>';
        }
      }

    }

  ?>

  <br/><br/>

    <div>
      <form enctype="multipart/form-data" method="POST" action="<?php echo Yii::app()->createUrl('site/uploadLogo'); ?>">
        <input type="hidden" name="upload_file"/>
        <input name="uploadedfile" type="file" /><br />
        <input type="submit" value="Загрузить" />
      </form>
    </div>
</div>

<div class="right_korzina">
  <?php

  $fleshkas = Yii::app()->session['korzina_fleshkas'];

  if (count($fleshkas)>0) {

    foreach($fleshkas as $id_fleshka => $key) {

    	$fleshka = Descriptionsize::model()->findByPk($id_fleshka);

      if (count($fleshka)>0) {

    	 $this->renderPartial('pages/korzina_single_item_show', array('fleshka'=>$fleshka, 'order_id' => $order_id));
      }

      $upakovka = Descriptionprice::model()->findByPk($id_fleshka);

      if (count($upakovka)>0) {

       $this->renderPartial('pages/korzina_single_item_show1', array('upakovka'=>$upakovka, 'order_id' => $order_id));
      }

    }
  } else {
    echo 'Корзина пуста';
  }
  ?>

</div>


<!--<div style="clear:both;"></div>-->

<p><center>
  <?php
    $this->widget('bootstrap.widgets.TbButton', array(
      'type'=>'primary',
      'label'=>'Добавить флешек в запрос', 
      'id' => 'add_another',
      'size' => 'small')); 
  ?>
</center></p>

<?php

function get_rus_date($date)
{
    // get russian date
    $date = strtotime($date);
    $month = date('n', $date);
    switch ($month){
        case 1: $m='января'; break;
        case 2: $m='февраля'; break;
        case 3: $m='марта'; break;
        case 4: $m='апреля'; break;
        case 5: $m='мая'; break;
        case 6: $m='июня'; break;
        case 7: $m='июля'; break;
        case 8: $m='августа'; break;
        case 9: $m='сентября'; break;
        case 10: $m='октября'; break;
        case 11: $m='ноября'; break;
        case 12: $m='декабря'; break;
    }

    $year = '';
    if (date('Y')!=date('Y', $date)) {
      $year = date('Y', $date).', ';
    }
    $result = $year.date('j', $date).' '.$m.' '.date('G:i', $date);
    return $result;
}
?>

<script type="text/javascript">

var order_id = "<?php echo $order_id; ?>";

$(function() {

  //$('.bootstrap-widget-header').css('height', '48px');
  $('.bootstrap-widget-header:first').html($('#id_div_filtr').html());

  var a_ot = $('#id_ot').html();
  var a_do = $('#id_do').html();
  if (a_ot!='от') {
    $('#id_ot_text').val(a_ot);
  }
  if (a_ot!='до') {
    $('#id_do_text').val(a_do);
  }

var $ot = $("<input type='text' />").hide().datepicker({
    dateFormat:'dd.mm.yy',
    defaultDate: "<?php echo count($order)>0?date('d.m.Y', ($order->date_expire!=''?strtotime($order->date_expire):time())):'';?>",
    onSelect: function(dateText, inst) {
       $('#id_ot').html(dateText);
       $('#id_ot_text').val(dateText);
    }
}).appendTo('#ot_div');

var $mdo = $("<input type='text' />").hide().datepicker({
    dateFormat:'dd.mm.yy',
    defaultDate: "<?php echo count($order)>0?date('d.m.Y', ($order->date_expire_to!=''?strtotime($order->date_expire_to):time())):'';?>",
    onSelect: function(dateText, inst) {
       $('#id_do').html(dateText);
       $('#id_do_text').val(dateText);
    }
}).appendTo('#do_div');

$("#id_ot").click(function(e) {
    if ($ot.datepicker('widget').is(':hidden')) {
        $ot.show().datepicker('show').hide();
        $ot.datepicker("widget").position({
            my: "left top",
            at: "right top",
            of: this
        });
    } else {
        $ot.hide();
    }
    return false;
    //e.preventDefault();
});

$("#id_do").click(function(e) {
    if ($mdo.datepicker('widget').is(':hidden')) {
        $mdo.show().datepicker('show').hide();
        $mdo.datepicker("widget").position({
            my: "left top",
            at: "right top",
            of: this
        });
    } else {
        $mdo.hide();
    }
    return false;
    //e.preventDefault();
});


    // select choosen colors
    var ok_content = '<center><i class="icon-ok"></i></center>';

    <?php 
    $colors = Yii::app()->session['korzina_color'];
    if (count($colors)>0) : ?>
      <?php foreach($colors as $key => $color) : ?>

        $('#my_color_icon_<?php echo $key;?>').html(ok_content);

      <?php endforeach; ?>
    <?php endif; ?>

    // select choosen volumes
    <?php 
    $volumes = Yii::app()->session['korzina_volume'];
    if (count($volumes)>0) : ?>
      <?php foreach($volumes as $key => $volume) : ?>

        $('div[fleshka_volume=<?php echo $key;?>]').toggleClass('my_pressed');

      <?php endforeach; ?>
    <?php endif; ?>

    $('.my_color_icon').live('click', function() {
      var colorprice_id = $(this).attr('colorprice_id');

      var add = 1;
      if ($(this).find('i.icon-ok').length>0) {
        var add = 0;
      } 

      $.post("<?php echo Yii::app()->createUrl('/site/korzina_add_color'); ?>", {
        colorprice_id: colorprice_id,
        add: add,
        order_id: order_id
      });
    });

    $('.my_unpressed').live('click', function() {

      var volume = $(this).attr('fleshka_volume');

      var add = 1;
      if ($(this).hasClass('my_pressed')) {
        var add = 0;
      } 

      $.post("<?php echo Yii::app()->createUrl('/site/korzina_add_volume'); ?>", {
        volume: volume,
        add: add,
        order_id: order_id
      });
    });

    $('#add_another').click(function() {

      location.href = "<?php echo Yii::app()->createAbsoluteUrl('site'); ?>";
    });

    $('#new_korzina').click(function() {

      location.href = "<?php echo Yii::app()->createAbsoluteUrl('site/new_korzinka'); ?>";
    });

    $('#send_order').click(function() {

      $('#korzina_form').submit();
    });

    $('#save_data').click(function() {

      $('#korzina_form').submit();
    });

    $('#reply_comment').click(function() {
      $('#reply_form').submit();
    });

    $('.click_user').click(function() {

      $(this).parent().find('span').show();
      $(this).remove();
    });

});

function delete_korzina_flesh(fleshka_id)
{
  var order_id = "<?php echo $order_id; ?>";

  $.post("<?php echo Yii::app()->createUrl('/site/korzina_delete_fleshka'); ?>", {
    fleshka_id: fleshka_id,
    order_id: order_id
  }, function() {

    $('#div_all_korzina_single_fleshka_'+fleshka_id).remove();
  });

}


</script>
