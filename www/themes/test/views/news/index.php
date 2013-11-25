<?php
$this->layout = '//layouts/admin';
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$news->search(),
	'template'=>"{items}",
	'columns'=>array(
		'id',
		'title',
        array(
            'header' => 'Новости',
            'value' => 'mb_substr($data->news, 0, 100)',
            'htmlOptions'=>array('height'=>'60px'),
        ),
        array(
        	'header' => 'Создан',
        	'value' => 'date("d.m.Y", strtotime($data->date_created))',
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
	window.location="<?php echo Yii::app()->createUrl("news/create"); ?>";
}
</script>