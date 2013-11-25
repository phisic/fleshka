<?php
$this->layout = '//layouts/admin';
?>
<div style="width:200px;float:left;">
	<input type="text" id="filter" placeholder="Поиск..." style="width:150px;"><br/>
	<div id="all_list" style="height:500px;overflow-y:auto;">
		<ul>
		<?php foreach($fleshkas as $fleshka) : ?>

			<li class="fleshka_list" fleshka_id="<?php echo $fleshka->id; ?>"><?php echo $fleshka->name.' #'.$fleshka->id; ?></li>

		<?php endforeach; ?>
		</ul>
	</div>
</div>

<div id="specialoffer" style="float:left;margin-left:20px;height:500px;overflow-y:auto;">

</div>

<script type="text/javascript">

	var $all_list = $('#all_list').html();

	$(function() {

		$('#specialoffer').load('<?php echo Yii::app()->createUrl('fleshka/specialShow'); ?>');

		$('#filter').keyup(function() {

			$('#all_list').html($all_list);

			var filter = $('#filter').val().toLowerCase();

			if (filter!='') {

				$('.fleshka_list').hide();

				$('.fleshka_list').filter(function(index) {
					
					var text = $(this).text().toLowerCase();

					if (text.indexOf(filter)>=0) {
						return true;
					}
					
				}).show();

			} else {
				$('#all_list').html($all_list);
			}
		});

		$('.fleshka_list').live('mouseover', list_mouse_over).live('click', function() {

			var fleshka_id = $(this).attr('fleshka_id');

	      	$.post("<?php echo Yii::app()->urlManager->createUrl('/fleshka/specialAdd'); ?>", {
					fleshka_id: fleshka_id,
	      		}, function() {
					$('#specialoffer').load('<?php echo Yii::app()->createUrl('fleshka/specialShow'); ?>');
			});

		});
			
	});

	function list_mouse_over()
	{
		$('.fleshka_list i').remove();

		$(this).append('<i class="icon-plus-sign" style="float:right;"></i>');
	}

</script>