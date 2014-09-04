<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>mywallet</title>

	<?php 
		echo $this->Html->css('bootstrap-sass/bootstrap/bootstrap');
		echo $this->Html->css('main.css');
	?>
</head>
<body>
	<div class="content-container">
		
		<?php echo $this->fetch('content'); ?>		

	</div>

	<?php echo $this->Html->script('bootstrap.min'); ?>
</body>
</html>