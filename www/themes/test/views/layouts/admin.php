<?php

	if (isset(Yii::app()->session['logoff']) && Yii::app()->session['logoff']==1) {

		unset($_SERVER['PHP_AUTH_USER']);
		unset($_SERVER['PHP_AUTH_PW']);

		unset(Yii::app()->session['logoff']);
	}

	$username = $_SERVER['PHP_AUTH_USER'];
	$password = $_SERVER['PHP_AUTH_PW'];

	$check = User::model()->checkUser($username, $password);

	if (!$check) {
		unset($_SERVER['PHP_AUTH_USER']);
		unset($_SERVER['PHP_AUTH_PW']);
	}

	if ( !isset($_SERVER['PHP_AUTH_USER']) ) {

		header('WWW-Authenticate: Basic realm="You Shall Not Pass"');
		header('HTTP/1.0 401 Unauthorized');
		exit;

	}

?>

<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />

	<title>Админка</title>
</head>


<body>
<?php
$this->widget('bootstrap.widgets.TbNavbar', array(
	'type'=>null, // null or 'inverse'
	'brand'=>'',
	'fixed' => 'false',
	'brandUrl'=>'#',
	'collapse'=>true, // requires bootstrap-responsive.css
	'items'=>array(
		array(
			'class'=>'bootstrap.widgets.TbMenu',
			'items'=>array(
				array('label'=>'Заказы', 'url'=>Yii::app()->urlManager->createUrl('/admin/orders'), 'active' => (Yii::app()->getGlobalState('top_menu')=='orders'?true:false)),
				array('label'=>'Флешки', 'url' => Yii::app()->urlManager->createUrl('/fleshka'), 'active' => (Yii::app()->getGlobalState('top_menu')=='fleshka'?true:false)),
				array('label'=>'Упаковки', 'url' => Yii::app()->urlManager->createUrl('/fleshka/upakovka'), 'active' => (Yii::app()->getGlobalState('top_menu')=='upakovka'?true:false)),

				array('label'=>'Категория флешек', 'items'=> array(
					array('label'=>'Категория флешек', 'url' => Yii::app()->urlManager->createUrl('/catalogs'), 'active' => (Yii::app()->getGlobalState('top_menu')=='catalogs'?true:false)),
					array('label'=>'Подсказки', 'url' => Yii::app()->urlManager->createUrl('/catalogs/hints'), 'active' => (Yii::app()->getGlobalState('top_menu')=='hints'?true:false)),
					array('label'=>'Специальные предложения', 'url' => Yii::app()->urlManager->createUrl('/fleshka/special'), 'active' => (Yii::app()->getGlobalState('top_menu')=='special'?true:false)),
					array('label'=>'Популярные флешки', 'url' => Yii::app()->urlManager->createUrl('/fleshka/popular'), 'active' => (Yii::app()->getGlobalState('top_menu')=='popular'?true:false)),
					array('label'=>'Калькуляция', 'url' => Yii::app()->urlManager->createUrl('/fleshka/calculation'), 'active' => (Yii::app()->getGlobalState('top_menu')=='calculation'?true:false)),
				)),
				//array('label'=>'Пользователы', 'url' => Yii::app()->urlManager->createUrl('/admin/users')),
				array('label'=>'Контент', 'items'=> array(
					array('label'=>'Статьи', 'url' => Yii::app()->urlManager->createUrl('/news/index'), 'active' => (Yii::app()->getGlobalState('top_menu')=='news'?true:false)),
					array('label'=>'Контакты', 'url'=>Yii::app()->urlManager->createUrl('/admin/contacts'), 'active' => (Yii::app()->getGlobalState('top_menu')=='contacts'?true:false)),
					array('label'=>'Телефоны', 'url'=>Yii::app()->urlManager->createUrl('/admin/phones'), 'active' => (Yii::app()->getGlobalState('top_menu')=='phones'?true:false)),
					array('label'=>'Мета контрол', 'url'=>Yii::app()->urlManager->createUrl('/admin/meta_control'), 'active' => (Yii::app()->getGlobalState('top_menu')=='meta_control'?true:false)),
					array('label'=>'Список Email', 'url'=>Yii::app()->urlManager->createUrl('/admin/emails'), 'active' => (Yii::app()->getGlobalState('top_menu')=='emails'?true:false)),
				)),
				array('label'=>'Условия продажи', 'items'=> array(
				     array('label'=>'Условия продажи', 'url'=>Yii::app()->urlManager->createUrl('/admin/selling_rules'), 'active' => (Yii::app()->getGlobalState('top_menu')=='selling_rules'?true:false)),
				     array('label'=>'Стандартный договор', 'url'=>Yii::app()->urlManager->createUrl('/admin/dogovor'), 'active' => (Yii::app()->getGlobalState('top_menu')=='dogovor'?true:false)),
				     array('label'=>'Презентация', 'url'=>Yii::app()->urlManager->createUrl('/admin/presentation'), 'active' => (Yii::app()->getGlobalState('top_menu')=='presentation'?true:false)),
				)),
				array('label'=>'Реклама', 'url'=>Yii::app()->urlManager->createUrl('/advertising'), 'active' => (Yii::app()->getGlobalState('top_menu')=='advertising'?true:false)),
			),
		),
		array(
			'class'=>'bootstrap.widgets.TbMenu',
			'htmlOptions'=>array('class'=>'pull-right'),
			'items'=>array(
				array('label'=>'Выход', 'url'=>Yii::app()->urlManager->createUrl('/admin/logout'), 'icon' => 'icon-off'),
				array('label'=>'На сайт', 'url'=>Yii::app()->urlManager->createUrl('/site'), 'icon' => 'icon-home', 'linkOptions'=>array('target'=>'_blank')),
			),
		),
	),
));
?>

<div id="content">

<?php
	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => $this->title,
    //'headerIcon' => 'icon-home',
    'content' => $content
));
?>

</div><!-- content -->
</body>
</html>
