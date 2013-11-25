<?php
$this->layout = '//layouts/admin';
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$hints->search(),
	'template'=>"{items}",
	'columns'=>array(
		'id',
		'title',
		'hints',
        // array(
        //     'header' => 'Catalogs',
        //     'type' => 'raw',
        //     'value' => '$data->getCatalogs()',
        //     'htmlOptions' => array('style' => 'width:200px;'),
        // ),
        array(
	        'class' => 'bootstrap.widgets.TbButtonColumn',
	        'template' => '{update} {delete}',
            'buttons'=>array
                (
                    'update' => array
                    (
                        'label' => 'Редактировать',
                        'url'=>'Yii::app()->createUrl("catalogs/createHints", array("id"=>$data->id))',
                        'icon' => 'icon-edit',
                    ),
                    'delete' => array
                    (
                        'label'=>'Удалить',
                        'url'=>'Yii::app()->createUrl("catalogs/deleteHints", array("id"=>$data->id))',
                        'icon'=>'icon-remove',
                    ),                    
                ),                            	        
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
		add_new_hints();
	}'),
));
?>

<script type="text/javascript">
function add_new_hints()
{
	window.location="<?php echo Yii::app()->createUrl("catalogs/createHints"); ?>";
}
</script>