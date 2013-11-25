<?php
$this->layout = '//layouts/admin';
?>

<form enctype="multipart/form-data" method="POST">
	<input type="hidden" name="upload_file"/>
	Выберите файл для загрузки: <input name="uploadedfile" type="file" /><br />
	<input type="submit" value="Загрузить" />
</form>

<?php
echo $content->content;
?>

<?php if ($error!='') : ?>
	<br/>
	<span class="label label-important"><?php echo $error; ?></span>
<?php endif; ?>
