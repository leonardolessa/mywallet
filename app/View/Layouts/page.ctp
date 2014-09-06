<!DOCTYPE html>
<html lang="pt-BR">
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
	
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min'); ?>
</body>
</html>