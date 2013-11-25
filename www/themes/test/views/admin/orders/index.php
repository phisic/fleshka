<?php
$this->layout = '//layouts/admin';
?>

<form action="<?php echo Yii::app()->createUrl('admin/orders'); ?>" method="POST" id="order_search_form">
Поиск
<input type="text" name="search" id="search" value="" style="width:500px;">

<?php
$this->widget('bootstrap.widgets.TbButton', array(
  'label'=>'Ok',
  'id' => 'search_it',
  'size' => 'small')); 
?>
</form>


<?php if (isset($term)) : ?>
		<center>Поиск <b><?php echo $term; ?></b></center>
<?php endif; ?>	
 
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$orders,
	'template'=>"{items}",
	'columns'=>array(
        array(
            'header' => 'Создан',
            'value' => 'date("d.m.Y", strtotime($data->date_created))'
        ),
		'id',
        array(
            'header' => 'Менеджер',
            'value' => '$data->getManagers()',
        ),
		'email',
		'company',		
		'phone',
		'address',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'Chtml::link("Просмотр", array("/site/korzinka", "order_id" => $data->order_id), array("target" => "_blank"))',
        ),		

        array(
	        'class' => 'bootstrap.widgets.TbButtonColumn',
	        'template' => '{delete}',
            'buttons'=>array
                (
                    'delete' => array
                    (
                        'label'=>'Удалить',
                        'url'=>'Yii::app()->createUrl("admin/deleteOrder", array("id"=>$data->id))',
                        'icon'=>'icon-remove',
                    ),                    
                ),                            	        
	    ),

	),	
));

?>

<script type="text/javascript">

$(function () {

	$('#search_it').click(function() {

		$('#order_search_form').submit();
	});
});
</script>