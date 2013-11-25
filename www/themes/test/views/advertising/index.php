<?php
$this->layout = '//layouts/admin';
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'bordered',
	'dataProvider'=>$model->search(),
	'template'=>"{items}",
	'columns'=>array(
		'id',
		'text_advertising',
        array(
            'header' => 'Рисунок',
            'type' => 'raw',
            'value' => 'Chtml::tag("img", array("src" => Yii::app()->request->baseUrl."/images/".$data->picture))'
        ),
		'url',
        array(
            'header' => 'В новом окне',
            'value' => '($data->blank==1?"Да":"Нет")'
        ),
        array(
            'header' => 'Актив',
            'value' => '($data->is_active==1?"Да":"Нет")'
        ),
        array(
	        'class' => 'bootstrap.widgets.TbButtonColumn',
	        'template' => '{update} {delete}',
	    ),
	),	
));


$this->widget('zii.widgets.jui.CJuiButton', array(
	'name'=>'submit',
	'caption'=>'Добавить',
	// you can easily change the look of the button by providing the correct class
	// ui-button-error, ui-button-primary, ui-button-success
	'htmlOptions' => array('class'=>'ui-button-primary'),
	'onclick'=>new CJavaScriptExpression('function(){ 
		click_it();
	}'),
));
?>

<script type="text/javascript">
function click_it()
{
	window.location="<?php echo Yii::app()->createUrl("advertising/update"); ?>";
}
</script>