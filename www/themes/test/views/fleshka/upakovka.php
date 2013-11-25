<?php
$this->layout = '//layouts/admin';
?>

<div style="width:200px;float:left;">
	<input type="text" id="filter" placeholder="Поиск..." style="width:150px;"><br/>
	<div id="all_list" style="height:600px;overflow-y:auto;">
		<ul>
			<li class="fleshka_list" fleshka_id="0">Создать</li>

			<?php foreach($upakovkas as $upakovka) : ?>

				<li class="fleshka_list" fleshka_id="<?php echo $upakovka->id; ?>"><?php echo $upakovka->name.' #'.$upakovka->id; ?></li>

			<?php endforeach; ?>
		</ul>
	</div>
</div>

<div id="edit_fleshka" style="float:left;margin-left:20px;height:600px;overflow-y:auto;width:850px;">

</div>

<script type="text/javascript">

	var $all_list = $('#all_list').html();

	$(function() {

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

			$('.fleshka_list').css('background', 'white');

			$(this).css('background', 'blue');

			var fleshka_id = $(this).attr('fleshka_id');

			load_fleshka(fleshka_id);
		});
			
	});

	function load_fleshka(upakovka_id)
	{

		$('#edit_fleshka').load('<?php echo Yii::app()->createUrl('fleshka/upakovkaEdit'); ?>', {
			id:upakovka_id
		});

	}

	function reload_all_list()
	{
		// reload list 
		$('#all_list').load('<?php echo Yii::app()->createUrl('fleshka/reloadUpakovka'); ?>',
			function () {
				$all_list = $('#all_list').html();
			});
	}

	function list_mouse_over()
	{
		$('.fleshka_list i').remove();

		$(this).append('<i class="icon-edit" style="float:right;"></i>');
	}

</script>