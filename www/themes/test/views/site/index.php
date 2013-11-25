<?php
/* @var $this SiteController */

$this->layout = '//layouts/column1';

$this->pageTitle=Yii::app()->name;

$model = 1;

?>

<?php
// $this->widget('bootstrap.widgets.TbBox', array(
//     'title' => 'Категория флешек',
//     //'headerIcon' => 'icon-home',
//     'content' => $this->renderPartial('categories', array('model'=>$model), true)
// ));
?>

<?php
// $this->widget('bootstrap.widgets.TbBox', array(
//     'title' => 'Специальные предложения',
//     //'headerIcon' => 'icon-home',
//     'content' => $this->renderPartial('new_items', array('new_items'=>$new_items), true)
// ));
?>

<?php
// $this->widget('bootstrap.widgets.TbBox', array(
//     'title' => 'Популярные флешки',
//     //'headerIcon' => 'icon-home',
//     'content' => $this->renderPartial('popular_items', array('popular_items'=>$popular_items), true)
// ));
?>

<?php
	$relgoodscatalogs = Relgoodscatalog::model()->with('descriptionsize')
			->findAll(array('condition' => 'descriptionsize.trash=0 and instock=1 and catalog_id=:id', 
				'params' => array(':id' => 1),
				'order' => 'descriptionsize.index ASC'));

	$relgoodscatalog_upakovkas = Relgoodscatalog::model()->with('descriptionprice')
			->findAll(array('condition' => 'descriptionprice.trash=0 and instock=1 and catalog_id=:id', 
				'params' => array(':id' => 1),
				'order' => 'descriptionprice.index ASC'));

	$catalog = Catalogs::model()->findByPk(1);

	$color_id = 0;

	$this->renderPartial('all_item', array(
		'relgoodscatalogs' => $relgoodscatalogs,
		'relgoodscatalog_upakovkas' => $relgoodscatalog_upakovkas,
		'catalog' => $catalog,
		'my_type' => 'in_stock',
		'color_id' => $color_id
	));
?>