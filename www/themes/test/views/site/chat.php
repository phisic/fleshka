<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>

<div style="width:100px;height:500px;float:left;border:1px solid;" id="chat_list_column">
</div>

<div style="width:100%;height:500px;">
	<div class="my_text" style="overflow-y:scroll;height:270px;width:280px;" id="div_chat">
	</div>
<input type="text" name="chat_email" placeholder="Введите текст, нажмите Enter" class="my_text" id="chat_entry" style="width:300px;display:none;">
</div>

<!--        Script by hscripts.com          -->
<!--        copyright of HIOX INDIA         -->
<!-- more scripts @ http://www.hscripts.com -->
<script type="text/javascript">

$(function() {
	reload_chat_list();
});

var timer;

function titlebar(val)
{
	var masg = '';
	var msg  = "Новая чат";
	var speed = 500;
	var pos = val;

	var msg1  = "    ****** "+msg+" ******";
	var msg2  = "    ------- "+msg+" -------";

	if(pos == 0){
		masg = msg1;
		pos = 1;
	}
	else if(pos == 1){
		masg = msg2;
		pos = 0;
	}

	document.title = masg;
	timer = window.setTimeout("titlebar("+pos+")",speed);
}

//titlebar(2);

check_status = setInterval(function() {

	$.ajax({
		url: "<?php echo Yii::app()->createUrl('site/customerChatStatus'); ?>",
		success: function(data) {
			if ($.trim(data)==='1') {
				console.log('title');
				titlebar(1);
				reload_chat_list();
			} else {
				console.log('no title');
				clearTimeout(timer);
				document.title = "Чат";
			}
		}
	});

}, 5000);

var chat = {};

var current_hash = '';

chat.interval = setInterval(function() {see_chat(current_hash)}, 5000);

function see_chat(hash)
{
	$('.'+hash).remove();

	if (hash=='') return false;
	current_hash = hash;

	$.ajax({
		url: "<?php echo Yii::app()->createUrl('site/customerChat'); ?>",
		type: 'post',
		data: { method: 'fetch', hash: hash},
		success: function(data) {
			$('#div_chat').html(data);
			$('#chat_entry').show();
			var n = $('#div_chat').height();
    		$('#div_chat').animate({ scrollTop: n },'50');			
		}
	});
}

chat.entry = $('#chat_entry');

chat.throwMessage = function (message) {

	if (current_hash!='') {
		if ($.trim(message).length != 0) {

			$.ajax({
				url: "<?php echo Yii::app()->createUrl('site/customerChat'); ?>",
				type: 'post',
				data: { method: 'throw', message: message, hash: current_hash},
				success: function(data) {
					see_chat(current_hash);
					chat.entry.val('');
				}
			});		
		}
	}
}

chat.entry.bind('keydown', function(e) {
	if (e.keyCode === 13 && e.shiftKey === false) {
		chat.throwMessage($(this).val());
		e.preventDefault();
	}
})

function reload_chat_list()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('site/reloadChatList'); ?>",
		type: 'post',
		success: function(data) {
			$('#chat_list_column').html(data);
		}
	});		

}

</script>
<!--     Script by hscripts.com     -->