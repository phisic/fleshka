<!-- file uploader -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/fileuploader/fileuploader.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/fileuploader/fileuploader.css">

<style type="text/css">
	.single_fleshka_thumb {
	    width: 100px;
	    margin: 3px 5px 0 0;
	}

	.current_file_upload {
	    display: none;
	}

</style>

<span id="insert_new"></span>

<?php if (count($upakovka->colorprices[$my_colorprice]->photoss)>0) : ?>

	<?php foreach ($upakovka->colorprices[$my_colorprice]->photoss as $key => $photo) : ?>
	  
		<div class="single_fleshka_thumb" photos_id="<?php echo $photo->id; ?>">
		    <a photo_id="<?php echo $photo->id; ?>">
		    	<img src="data:image/jpeg;base64, <?php echo base64_encode( $photo->thumbnail ); ?>" alt=""/>
		    </a>
		</div>

	<?php endforeach; ?>

<?php endif; ?>

<div style="clear:both;"></div>

<div class="current_file_upload well">

	<input type="hidden" value="0" id="photos_id">

	<span id="update_new" style="float:left;"></span>

	&nbsp;

	<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Удалить фото',
			'type'=>'danger',
			'size'=>'mini',
			'htmlOptions'=>array(
				'onclick'=>'js:bootbox.confirm("Вы уверены?",
				function(confirmed){
					if (confirmed==true) {
						delete_the_photo();
					}
				})'
			),
		));
	?>

</div>

<script type="text/javascript">

	var photos_id = 0;

	$(function() {

		$('.single_fleshka_thumb').click(function() {

			photos_id = $(this).attr('photos_id');

			$('.single_fleshka_thumb').css('border', '1px solid #E9E9E9');

			$(this).css('border', '2px solid blue');

			var fleshka_id = $(this).attr('fleshka_id');

			var mycolorprice = $(this).attr('mycolorprice');

			var colorprice_id = $(this).attr('colorprice_id');

			$('.current_file_upload').show();

			$('#photos_id').attr('value', photos_id);
		});

		$(':file').change(function(){
		    var file = this.files[0];
		    name = file.name;
		    size = file.size;
		    type = file.type;
		    if (!(type=='image/jpeg' || type=='image/png' || type=='image/bmp' || type=='image/gif')) {

		    	alert('пожалуйста, приложите JPEG, PNG, BMP или GIF файлов');

		    	$('#new_file')[0].reset();

		    }
		    //your validation
		});

        var uploader = new qq.FileUploader({
            element: document.getElementById('insert_new'),
            action: "<?php echo Yii::app()->createUrl('fleshka/uploadPhoto');?>",
            params: {
            	photos_id: 0,
				fleshka_id: <?php echo $upakovka->id; ?>,
				color_id: <?php echo $upakovka->colorprices[$my_colorprice]->color_id; ?>
            },
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            onComplete: function()
            {
                //close_selection();
                reload_current_color();
            },
            showMessage: function(message){ 
            }            
        });

        var uploader1 = new qq.FileUploader({
            element: document.getElementById('update_new'),
            action: "<?php echo Yii::app()->createUrl('fleshka/uploadPhoto');?>",
			onSubmit: function() {
			        uploader1.setParams({
			        	photos_id: photos_id,
						fleshka_id: <?php echo $upakovka->id; ?>,
						color_id: <?php echo $upakovka->colorprices[$my_colorprice]->color_id; ?>
			        });
			    },            
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            onComplete: function()
            {
                //close_selection();
                reload_current_color();
            },
            showMessage: function(message){ 
            }            
        });

        $('.qq-upload-button').css('width', '110px');
        $('#update_new .qq-upload-button').css('background', 'url("js/fileuploader/images/update.gif")');
        $('.qq-upload-list').remove();

	});

    function close_selection()
    {
        if (new_image==1) {
            var ias = $('img#thumbnail').imgAreaSelect({ instance: true });
            ias.setOptions({ hide: true });
            ias.update();
        }
        
    }

	function delete_the_photo()
	{
		$.post('<?php echo Yii::app()->createUrl('fleshka/deletePhoto'); ?>', {
			photos_id: photos_id
		}, function() {

			reload_current_color();

		});

		return false;
	}

	function reload_current_color()
	{
		$('.current_color').load('<?php echo Yii::app()->createUrl('fleshka/upakovkaShowPhoto'); ?>', {
			upakovka_id: <?php echo $upakovka->id; ?>,
			mycolorprice: <?php echo $my_colorprice; ?>,
			colorprice_id: <?php echo $colorprice_id; ?>
		});		
	}

</script>
