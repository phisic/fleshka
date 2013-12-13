<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<?php $keywords = Content::model()->find('name="keywords"'); ?>
	<?php $description = Content::model()->find('name="description"'); ?>

	<meta name="keywords" content="<?php echo  $keywords->content;?>"/>
    <meta name="description" content="<?php echo $description->content; ?>"/>

	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />

	<?php Yii::app()->bootstrap->init(); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<!-- yandex map -->
	<script type="text/javascript" src="http://api-maps.yandex.ru/1.1/index.xml?key=<?php echo Yii::app()->params['yandex_map_api']; ?>"></script>
    <script type="text/javascript">
        window.onload = function () {
            var map = new YMaps.Map(document.getElementById("<?php echo Yii::app()->params['yandex_map_api']; ?>"));
            map.setCenter(new YMaps.GeoPoint(37.751071,55.752805), 17);
            map.addControl(new YMaps.Zoom());
            map.addControl(new YMaps.TypeControl());
            map.addControl(new YMaps.ScaleLine());
            // Создает метку в центре Москвы
            var placemark = new YMaps.Placemark(new YMaps.GeoPoint(37.751071,55.752805));
			// Устанавливает содержимое балуна
			placemark.name = "www.fleshka.ru";
			placemark.description = "продажа флешек с логотипом оптом, <br/>г. Москва, улица Электродная, дом 2, строение 25";
			//Значок метки
			placemark.setIconContent("www.fleshka.ru");
			// Добавляет метку на карту
			map.addOverlay(placemark);
        }
    </script>
    <!-- /yandex map -->

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jqueryui/jquery-ui-1.8.21.custom.min.js"></script>

</head>

<style type="text/css">
	html,body{background-color:#3986BC;}
</style>

<body id="top">

<?php

// *** define visitors count ***
@session_start();
//выделяем уникальный идентификатор сессии
$id = session_id();

if ($id!="")
{
 //текущее время
 $CurrentTime = time();
 //через какое время сессии удаляются
 $LastTime = time() - 600;
 //файл, в котором храним идентификаторы и время
 $base = Yii::getPathOfAlias('webroot').'/dogovor/session.txt';

 $file = @file($base);

 $is_sid_in_file = 0;

 if ($file) {


    $k = 0;
    for ($i = 0; $i < sizeof($file); $i++) {
    $line = explode("|", $file[$i]);
    if ($line[1] > $LastTime) {
    $ResFile[$k] = $file[$i];
    $k++;
    }
    }

    if (isset($ResFile)) {

        for ($i = 0; $i<sizeof($ResFile); $i++) {
        $line = explode("|", $ResFile[$i]);
        if ($line[0]==$id) {
            $line[1] = trim($CurrentTime)."\n";
            $is_sid_in_file = 1;
        }
        $line = implode("|", $line); $ResFile[$i] = $line;
        }

        $fp = fopen($base, "w");
        for ($i = 0; $i<sizeof($ResFile); $i++) { fputs($fp, $ResFile[$i]); }
        fclose($fp);

    }
 }

 if (!$is_sid_in_file) {
  $fp = fopen($base, "a-");
  $line = $id."|".$CurrentTime."\n";
  fputs($fp, $line);
  fclose($fp);
 }
}
// *** /define visitors count ***

$na_sayte = 'Сейчас на сайте: '.sizeof(file($base));

include('SxGeo.php');
$SxGeo = new SxGeo('SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);

$ip = $_SERVER['REMOTE_ADDR'];

$city = $SxGeo->get($ip);

$work_city = '';

if ($city['country']=='RU') {
	$work_city = 'Привет "'.$city['city'].'" мы работаем с вами. ';
}

unset($SxGeo);

?>

<div class="main header">
  <div class="left">
  	<img width="200" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/header.png" onclick="home();" style="cursor:pointer;" alt=""/>
  </div>
  <?php
	$phone1 = Content::model()->find('name="phone1"');
	$phone2 = Content::model()->find('name="phone2"');
  ?>
  <div class="right">
      <div class="phone">
        <!--<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/phones.jpg" alt=""/>-->
		<?php echo $phone1->content; ?>
		<br/>
		<?php echo $phone2->content; ?>
     </div>

	<div class="top_menu_text" style="height:12px;">
		<?php echo $work_city;//. $na_sayte; ?>
	</div>

  </div>

	<div class="reklama"></div>

  <!-- <div class="mid">Всегда в наличии <strong>60 000</strong> флешек</div> -->
  <div class="clear"></div>
</div>

<!-- show catalog menu -->
<div class="top_menu">

	<div style="display: table;margin: 0 auto;line-height: 80%;">

		<?php

			$catalogs = Catalogs::model()->findAll(array('condition' => '`show`=1 and is_delete=0',
						'order' => '`index` ASC'));

			$ind = 1;
			$index_accordion = 0;
			date_default_timezone_set('Russia');
			$today = date('Y-m-d');

			// define printable catalogs count
			$count_of_catalogs = 1;
			foreach($catalogs as $key => $catalog) {

				// check if catalog printable
				$print_catalog = true;
				if ($catalog->date_apply==1) {

					if (!($today>=$catalog->from_date && $today<=$catalog->to_date)) {
						$print_catalog = false;
					}
				}

				// skip catalog if its'nt printable
				if ($print_catalog==false) continue;

				$count_of_catalogs++;
			}

			$ind = 0;
			foreach($catalogs as $key => $catalog) {

				// check if catalog printable
				$print_catalog = true;
				if ($catalog->date_apply==1) {

					if (!($today>=$catalog->from_date && $today<=$catalog->to_date)) {
						$print_catalog = false;
					}
				}

				// skip catalog if its'nt printable
				if ($print_catalog==false) continue;

				/*if ($ind==round($count_of_catalogs/2)) {
					echo '<div style="clear:both;"></div>';
				}*/

				// check if category selected before
				if (Yii::app()->session['catalog_id']==$catalog->id) {

					$index_accordion = $key;
				}

				// fleshkas
				$relgoodscatalogs = Relgoodscatalog::model()->with('descriptionsize')
							->findAll('descriptionsize.trash=0 and catalog_id=:id',array(':id' => $catalog->id));

				// upakovkas
				$relgoodscatalogs1 = Relgoodscatalog::model()->with('descriptionprice')
							->findAll('descriptionprice.trash=0 and catalog_id=:id',array(':id' => $catalog->id));

				$count_fleshka = count($relgoodscatalogs) + count($relgoodscatalogs1);

				// fleshkas in stock
				$relgoodscatalogs = Relgoodscatalog::model()->with('descriptionsize')
							->findAll('descriptionsize.trash=0 and instock=1 and catalog_id=:id',array(':id' => $catalog->id));

				// upakovkas in stock
				$relgoodscatalogs1 = Relgoodscatalog::model()->with('descriptionprice')
							->findAll('descriptionprice.trash=0 and instock=1 and catalog_id=:id',array(':id' => $catalog->id));

				$count_fleshka_nal = count($relgoodscatalogs) + count($relgoodscatalogs1);

				$count_fleshka_zakaz = $count_fleshka - $count_fleshka_nal;

				echo '<div class="items '.(Yii::app()->session['catalog_id']==$catalog->id?'items_selected':'').'"
						onclick="location.href=\''.Yii::app()->urlManager->createUrl('/site/all_item', array('id' => $catalog->id, 'type' => 'in_stock')).'\';">';
					echo '<center><img style="margin-top:2px;" src="'.Yii::app()->theme->baseUrl.'/img/flash/'.$catalog->image.'" alt="'.$catalog->name.'"/></center>';
					echo '<div class="top_menu_text">'.$catalog->name.'</div>';
				echo '</div>';

				$ind++;
			}

			// zaprosi
			/*echo '<div class="items '.(Yii::app()->session['catalog_id']==0?'items_selected':'').'"
					onclick="location.href=\''.Yii::app()->urlManager->createUrl('/site/korzinka').'\';">';
				echo '<center><img style="margin-top:2px;" src="'.Yii::app()->theme->baseUrl.'/img/flash/orderfl.png" alt="Запрос" style="f_left" width="63"/></center>';
				echo '<div class="top_menu_text">Запрос</div>';
			echo '</div>';
*/
		?>

	</div>

</div>

<div id="moving_top_menu" style="z-index:1000;width: 104%;margin-left: -24px;">

	<div class="top_menu" id="hidden_top_menu" style="display:none;background:rgb(235, 235, 235);">

		<div style="display:table;margin: 0 auto;line-height: 80%">

			<?php

				$ind = 0;
				$index_accordion = 0;
				date_default_timezone_set('Russia');
				$today = date('Y-m-d');

				foreach($catalogs as $key => $catalog) {

					// check if catalog printable
					$print_catalog = true;
					if ($catalog->date_apply==1) {

						if (!($today>=$catalog->from_date && $today<=$catalog->to_date)) {
							$print_catalog = false;
						}
					}

					// skip catalog if its'nt printable
					if ($print_catalog==false) continue;

					// divide top menu items to keep balance
					if ($ind==round($count_of_catalogs/2)) {
						echo '<div style="clear:both;"></div>';
					}

					echo '<div class="items '.(Yii::app()->session['catalog_id']==$catalog->id?'items_selected':'').'" style="height:31px;margin: 3px 10px 5px 5px;"
						onclick="location.href=\''.Yii::app()->urlManager->createUrl('/site/all_item', array('id' => $catalog->id, 'type' => 'in_stock')).'\';">';
						echo '<div class="top_menu_text" style="margin-top:5px;">'.$catalog->name.'</div>';
					echo '</div>';

					$ind++;

				}

				/*// zaprosi
				echo '<div class="items '.(Yii::app()->session['catalog_id']==0?'items_selected':'').'" style="height:27px;margin: 3px 10px 5px 5px;"
					onclick="location.href=\''.Yii::app()->urlManager->createUrl('/site/korzinka').'\';">';
					echo '<div class="top_menu_text" style="margin-top:5px;">Запрос</div>';
				echo '</div>';*/
			?>

		</div>

	</div>
	<!-- /show catalog menu -->

	<div style="clear:both;"></div>

	<?php
	$this->widget('bootstrap.widgets.TbNavbar', array(
		'type'=>'null', // null or 'inverse'
		'brand'=>'',
		'fixed' => 'false',
		'brandUrl'=>'#',
		'collapse'=>true, // requires bootstrap-responsive.css
		'items'=>array(
			'<form class="navbar-search pull-left" action="'.Yii::app()->urlManager->createUrl('/site/single_item').'">
				<input name="id" type="text" class="search-query span2" style="margin-left:-35px;width:240px;" placeholder="Поиск..." value="'.(isset(Yii::app()->session['searched_word'])?Yii::app()->session['searched_word']:'').'">
			</form>',

			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'items'=>array(
					//array('label'=>'Home', 'url'=>'#', 'active'=>true),
					array('label'=>'Каталог флешек в PDF', 'items'=> array(
						array('label'=>'Специальные предложения', 'url'=>Yii::app()->urlManager->createUrl('/site/catalog', array('type' => 'special'))),
						array('label'=>'В наличии', 'url'=>Yii::app()->urlManager->createUrl('/site/catalog', array('type' => 'in_stock'))),
						array('label'=>'На заказ', 'url'=>Yii::app()->urlManager->createUrl('/site/catalog', array('type' => 'to_order'))),
					)),
					//array('label'=>'Условия продажи', 'url'=>Yii::app()->urlManager->createUrl('/site/selling_rules'), 'active' => (Yii::app()->getGlobalState('top_menu')=='selling'?true:false)),
				    array('label'=>'Стандартный договор', 'url'=>Yii::app()->urlManager->createUrl('/site/dogovor')),
					array('label'=>'Статьи', 'url'=> Yii::app()->urlManager->createUrl('/site/news')),
					array('label'=>'Скачать презентацию', 'url'=>Yii::app()->urlManager->createUrl('/site/presentation')),

					array('label'=>'Контакты', 'url'=> Yii::app()->urlManager->createUrl('/site/contacts'), 'active' => (Yii::app()->getGlobalState('top_menu')=='contact'?true:false)),
					array('label'=>'Добавить запрос', 'url'=> Yii::app()->urlManager->createUrl('/site/korzinka'), 'active' => (Yii::app()->getGlobalState('top_menu')=='korzinka'?true:false)),

				),
			),

			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'htmlOptions'=>array('class'=>'pull-right my_custom_icon'),
				'items'=>array(
					array('label'=>'', 'url'=>'javascript:show_top_menu1()'),
				),
			),

		),
	));
	?>

</div>

	<?php
		// if(isset($this->breadcrumbs)) {
		// 	$this->widget('zii.widgets.CBreadcrumbs', array(
		// 		'links'=>$this->breadcrumbs,
		// 	));
		// }
	?>

	<div id="pagewrap">
		<?php echo $content; ?>

		<p id="back-top">
			<a href="#top"><span></span></a>
		</p>
	</div>

	<div class="clear"></div>

	<div class="footer">
		Наш адрес: г. Москва, ул. Электродная, д.2 стр.25.
		<p>© 2007–2023 Компания «100 заказов»</p>
		<p style="float:right"><a href="http://yandex.ru/cy?base=0&amp;host=fleshka.ru"><img src="http://www.yandex.ru/cycounter?fleshka.ru" width="88" height="31" alt="Яндекс цитирования" border="0" /></a>&nbsp;
<!--Openstat-->
<span id="openstat2349032"></span>
<script type="text/javascript">
var openstat = { counter: 2349032, image: 5081, color: "458efc", next: openstat };
(function(d, t, p) {
var j = d.createElement(t); j.async = true; j.type = "text/javascript";
j.src = ("https:" == p ? "https:" : "http:") + "//openstat.net/cnt.js";
var s = d.getElementsByTagName(t)[0]; s.parentNode.insertBefore(j, s);
})(document, "script", document.location.protocol);
</script>
<!--/Openstat--></p>
	</div><!-- footer -->

	<!-- page -->


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter10322905 = new Ya.Metrika({id:10322905,
                    webvisor:true,
                    clickmap:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/10322905" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>

<script type="text/javascript">

var pics = new Array();

var scroll_on_process = 0;

var svet_obyom = 'Вам нужно выбрать интересующие цвета и объемы флешек';
var svet = 'Выберите интересующие вас цвета';
var obyom = 'Выберите интересующие вас объемы';
var zakazat = '← вы можете задать вопрос и отправить заказ менеджеру.';

$(function() {

	// save window width to session
	$.post('<?php echo Yii::app()->createUrl('site/saveWindowWidth'); ?>', {
		windowWidth: $(window).width()
	});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
		$('#back-top').hide();

	// if monitor wide, increase widht of top menu items
	if ($(window).width()>1200) {

		$('.top_menu .items').css('width', '135');
	}

	// show_chat
	show_chat();

	$('#chat_button').click(function() {

		if ($.trim($('#chat_name').val())=='' || $.trim($('#chat_email').val())=='' || $.trim($('#chat_text').val())=='') {
			$('#chat_error').html('Пожалуйста, заполните все поля');
			return false;
		}

		if (!IsEmail($('#chat_email').val())) {
			$('#chat_error').html('Пожалуйста, введите действительный email');
			return false;
		}
		$('#chat_error').html('');

		$.post('<?php echo Yii::app()->createUrl('site/sendChatEmail'); ?>', {
			chat_name: $.trim($('#chat_name').val()),
			chat_email: $.trim($('#chat_email').val()),
			chat_text: $.trim($('#chat_text').val()),
		}, function() {
			$('#chat_content').html('<div class="text">Спасибо. Менеджер свяжется с вами в ближайшее время.</div>');
		});

	});

	// flash size checkbox button
	$('#my_flash_content div.my_unpressed').live('click', function() {

		$(this).toggleClass('my_pressed');

		check_zakazat(this);
	});

	//show_reklama();

	// change picture on mouse over
	$('.single_fleshka_thumb a').live("mouseover", function(){

		var fleshka_id = $(this).attr('fleshka_id');

		$('#big_image_'+fleshka_id).html($(this).html());

	});

	// change pictures on mouser over and clicking
	$('.fleshka_colors_div div.my_color_icon').bind('mouseover', color_mouse_over).live('click', function() {

	    var tt = $(this).html();

	    var ok_content = '<center><i class="icon-ok"></i></center>';

	    if (tt==ok_content) {

	      $(this).html('<i class="icon-vector-path-square"></i>');

	    } else {

	      $(this).html(ok_content);
	    }

	    check_zakazat(this);

	});

	// if zakazat button pressed
	$('#my_flash_content div.zakazat_fleshki button').live('click', function(){

		var colors = new Array();

		var volumes = new Array();

		$('#my_flash_content .fleshka_colors_div div.my_color_icon .icon-ok').each(function(index) {

			colors[index] = $(this).parent().parent().attr('colorprice_id');
		});

		$('#my_flash_content .my_pressed').each(function(index) {

			volumes[index] = $(this).attr('fleshka_volume');

		});

		var the_flesh_id = $(this).attr('flesh_id');

		var url = "<?php echo Yii::app()->urlManager->createUrl('/site/korzinka'); ?>";
		var form = $('<form action="' + url + '" method="post">' +
		  '<input type="text" name="colors" value="' + colors + '" />' +
		  '<input type="text" name="volumes" value="' + volumes + '" />' +
		  '<input type="text" name="flesh_id" value="' + the_flesh_id + '" />' +
		  '</form>');
		$('body').append(form);
		$(form).submit();

	});

});

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function check_zakazat(elem)
{
	$('#my_flash_content div.zakazat_fleshki').remove();
	$('#my_flash_content .label-info').remove();

	// add empty zakazat div
	if ($(elem).parent().parent().find('div.zakazat_fleshki').length==0) {

		// empty div for zakaz
		$(elem).parent().parent().find('div.div_prices').after($('.div_zakazat_fleshki').html());

	}

	// if both color and volume selected, show full zakazat
    if ($(elem).parent().parent().find('i.icon-ok').length>0 && $(elem).parent().parent().find('.my_pressed').length>0) {

		$(elem).parent().parent().find('div.zakazat_fleshki span').html(zakazat);

		// show zakazat submit button
		$(elem).parent().parent().find('div.zakazat_fleshki .id_my_button').show();

		return true;

    }

    // unbind mouseover when at least one color selected
    if ($(elem).parent().parent().find('i.icon-ok').length>0) {
		$('div.my_color_icon', $(elem).parent('.fleshka_colors_div')).unbind('mouseover');
    }

    // rebind mouseover when no color selected
    if ($(elem).parent().parent().find('i.icon-ok').length==0) {
    	$('div.my_color_icon', $(elem).parent('.fleshka_colors_div')).bind('mouseover', color_mouse_over);
    }

	// if color selected, and no volume info, show full zakazat
    if ($(elem).parent().parent().find('i.icon-ok').length>0 && $(elem).parent().parent().find('.my_unpressed').length==0) {

		$(elem).parent().parent().find('div.zakazat_fleshki span').html(zakazat);

		// show zakazat submit button
		$(elem).parent().parent().find('div.zakazat_fleshki .id_my_button').show();

		return true;

    }

    // if color selected and volume not selected, show choose volume
    if ($(elem).parent().parent().find('i.icon-ok').length>0 && $(elem).parent().parent().find('.my_pressed').length==0) {

    	$(elem).parent().parent().find('div.zakazat_fleshki span').html(obyom);

		// hide zakazat submit button
    	$(elem).parent().parent().find('div.zakazat_fleshki .id_my_button').hide();

    	return true;

    }

    // if color not selected and volum selected, show choose color
    if ($(elem).parent().parent().find('i.icon-ok').length==0 && $(elem).parent().parent().find('.my_pressed').length>0) {

    	$(elem).parent().parent().find('div.zakazat_fleshki span').html(svet);

		// hide zakazat submit button
    	$(elem).parent().parent().find('div.zakazat_fleshki .id_my_button').hide();

    	return true;

    }

    // else show choose color and volume
	$(elem).parent().parent().find('div.zakazat_fleshki span').html(svet_obyom);

	// hide zakazat submit button
	$(elem).parent().parent().find('div.zakazat_fleshki .id_my_button').hide();

}

// change pictures when color mouse over
function color_mouse_over()
{

	var colorprice = $(this).attr('mycolorprice');
	var fleshka_id = $(this).attr('fleshka_id');
	var width_picture = $(this).attr('width_picture');
	var height_picture = $(this).attr('height_picture');
	var show_thumb = $(this).attr('show_thumb');

	if (pics[fleshka_id+'_'+colorprice] == undefined) {
		// not found
      	$.post("<?php echo Yii::app()->urlManager->createUrl('/site/show_all_image'); ?>", {
				fleshka_id: fleshka_id,
				colorprice: colorprice,
				width_picture: width_picture,
				height_picture: height_picture,
				show_thumb: show_thumb
      		}, function(data) {
				$('#show_colorprice_'+fleshka_id).html(data);
				pics[fleshka_id+'_'+colorprice] = data;
				return true;
		});
	} else {
	  // access the foo property using result[0].foo
	  $('#show_colorprice_'+fleshka_id).html(pics[fleshka_id+'_'+colorprice]);

	  return true;
	}

}

$(window).resize(function() {
	if ($(window).width()<1200) {
		$('.reklama').hide();
	} else {
		$('.reklama').show();
	}
});

function show_reklama()
{
	if ($(window).width()>1200) {

		$('.reklama').load('<?php echo Yii::app()->createUrl('advertising/show'); ?>');
	}

}

function show_hint(id_hint)
{
	$('.my_hint').html($('#hint_'+id_hint).html());
	$('.my_hint').show();
}


// scroll top menu
var scrollingDiv = $("#moving_top_menu");
var show_top_menu_status = 0;

$(window).scroll(function(){

    var y = $(this).scrollTop();
//console.log($(window).height());
console.log(y);
    // up button
	if (y > 100) {
		$('#back-top').fadeIn();

	} else {
		$('#back-top').fadeOut();
	}
	// up button

    <?php if (Yii::app()->session['catalog_id']!=0) : ?>

	    if (y > 340 && show_top_menu_status==0){

	    	//show_top_menu_status = 1;
	    	//show_top_menu(show_top_menu_status);

	    }
	    if (y <= 340 && show_top_menu_status==1){

	    	//show_top_menu_status = 0;
	    	//show_top_menu(show_top_menu_status);
	    }

    <?php endif; ?>
});

function show_top_menu1()
{
	var hide_status = $( "#hidden_top_menu" ).css('display');
	if (hide_status==='none') {

		$('.my_custom_icon li a').html('<img style="width:15px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/b_up.png" />');
		$( "#hidden_top_menu" ).show('blind', {}, 800);

	} else {

		$('.my_custom_icon li a').html('<img style="width:15px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/b_down.png" />');
		$( "#hidden_top_menu" ).hide('blind', {}, 800);
	}
}

function show_top_menu(show)
{
	if (show==1) {

		var position = scrollingDiv.position();
		var marginTop = position.top;

		$('.my_custom_icon li a').html('<img style="width:15px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/b_up.png" />');

        scrollingDiv.css('position', 'fixed');
        var width = $('.bootstrap-widget').css('width');
        //scrollingDiv.css('width', width);
        scrollingDiv.css('width', '102%');
		scrollingDiv.css('marginTop', '-'+(marginTop+2)+'px');

		$( "#hidden_top_menu" ).show('blind', {}, 800);

	} else {

		$('.my_custom_icon li a').html('');

		$('#hidden_top_menu').hide();
        scrollingDiv.css('position', 'relative');
        scrollingDiv.css('marginTop', "0px");
        scrollingDiv.css('width', '104%');
	}
}

function change_margin(i)
{
	scrollingDiv.css('marginTop', '-'+i+'px');
}

function home()
{
	location.href="<?php echo Yii::app()->request->baseUrl; ?>";
}

function show_chat()
{
	if ($('#chat_content').css('display')==='none') {

		$('.chat').css('height', '350px');
		$('.chat').css('top', '370px');
		$('#chat_content').show();
		$('.chat_sign').html('-');

		// fit chat to screen
		$('.chat').css('top', ($(window).height()-343)+'px');

	} else {

		var height = $(window).height();

		$('.chat').css('height', '30px');
		$('.chat').css('top', (height-30)+'px');
		$('#chat_content').hide();
		$('.chat_sign').html('+');

		// fit chat to screen
		$('.chat').css('top', ($(window).height()-30)+'px');

	}

	$('.chat').show();

}

var chat = {};

chat.fetchMessages = function() {
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('site/customerChat'); ?>",
		type: 'post',
		data: { method: 'fetch'},
		success: function(data) {
			$('#div_chat').html(data);
			var n = $('#div_chat').height();
    		$('#div_chat').animate({ scrollTop: n },'50');
		}
	});
}

<?php if ($chat_status) : ?>
	// sync if chat is available
	chat.interval = setInterval(chat.fetchMessages, 5000);
<?php endif; ?>

chat.entry = $('#chat_entry');

chat.throwMessage = function (message) {

	if ($.trim(message).length != 0) {

		$.ajax({
			url: "<?php echo Yii::app()->createUrl('site/customerChat'); ?>",
			type: 'post',
			data: { method: 'throw', message: message},
			success: function(data) {
				chat.fetchMessages;
				chat.entry.val('');
			}
		});
	}
}

chat.entry.bind('keydown', function(e) {
	if (e.keyCode === 13 && e.shiftKey === false) {
		chat.throwMessage($(this).val());
		e.preventDefault();
	}
})

</script>
