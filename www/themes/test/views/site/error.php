<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle= 'Ошибка 404 — страница не найдена';
?>

<?php
	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'Ошибка 404 — страница не найдена',
    'id' => 'my_flash_content',
    //'headerIcon' => 'icon-home',
    'content' => '<h2>Ошибка 404 — страница не найдена</h2>'
));
?>
