<?php
$this->layout = '//layouts/admin';
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$catalogs,
	'template'=>"{items}",
	'columns'=>array(
		'id',
		'name',
		'header',
		'index',
		'show',

        array(
            'header' => 'Рисунок',
            'type' => 'raw',
            'value' => 'Chtml::tag("img", array("src" => Yii::app()->theme->baseUrl."/img/flash/".$data->image, "width" => 100))',
        ),
		'description',
		'from_date',
		'to_date',
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
		add_new_catalog();
	}'),
));
?>

<script type="text/javascript">
function add_new_catalog()
{
	window.location="<?php echo Yii::app()->createUrl("catalogs/update"); ?>";
}
</script>