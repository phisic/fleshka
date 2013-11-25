<?php if (count($news)>0) : ?>

	<?php foreach ($news as $key => $content) : ?>		

		<h4><?php echo $content->title; ?></h4>

		<?php echo nl2br($content->news); ?>

		<br/>

	<?php endforeach; ?>

<?php else : ?>	

	Пока нет никаких новостей

<?php endif; ?>	

<br/><br/>