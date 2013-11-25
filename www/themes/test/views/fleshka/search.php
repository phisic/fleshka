<div class="well">
<b>Поисковые фразы:</b>

<?php 
$searches = '';
$i = 1;
if (count($fleshka->searches)>0) {

	foreach($fleshka->searches as $search) {

		if ($i==1) {

			$searches = $search->word;

		} else {

			$searches .= ', '.$search->word;
		}
		
		$i++;
	}
}
?>

<input type="text" value="<?php echo $searches; ?>" style="width:300px;" id="search_word">

	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>'Изменить',
		'id' => 'save_search',
		'size' => 'mini')); 
	?>

</div>

<script type="text/javascript">

	$(function() {

		$('#save_search').click(function() {
			save_search();
		})
	});

	function save_search()
	{
		var fleshka_id = <?php echo $fleshka->id; ?>;

		var word = $('#search_word').val();

		$.post('<?php echo Yii::app()->createUrl('fleshka/save_search') ?>', {
			fleshka_id: fleshka_id,
			word: word
		}, function() {

			//load_search(fleshka_id);
		});
	}

	function load_search(fleshka_id)
	{
		var fleshka_id = <?php echo $fleshka->id; ?>;

		$('#div_search').load('<?php echo Yii::app()->createUrl('fleshka/search'); ?>', {
			fleshka_id: fleshka_id
		});
	}

</script>