<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$popular,//->search(),
	'template'=>"{items}",
	//'filter'=>$specialoffer,
	'columns'=>array(
        array(
            'header' => 'Наименование',
            'value' => '$data->descriptionsize->name." #".$data->descriptionsize->id',
        ),

		//'description',
		//'header',
        array(
	        'class' => 'bootstrap.widgets.TbButtonColumn',
	        'template' => '{udalit}',
            'buttons'=>array
                (
                    'udalit' => array
                    (
                        'label'=>'Удалить',
                        'url'=>'$data->id_popular',
                        'icon'=>'icon-remove',
                    ),
                ),                            

	    ),
	),			
));

?>
<script type="text/javascript">

$(function() {

	$('.icon-remove').click(function(){

		var id = $(this).parent().attr('href');

		$.post('<?php echo Yii::app()->createUrl('fleshka/popularDelete'); ?>', {

			id:id
		}, function() {

			$('#specialoffer').load('<?php echo Yii::app()->createUrl('fleshka/popularShow'); ?>');
		});
		return false;
	});
});

</script>