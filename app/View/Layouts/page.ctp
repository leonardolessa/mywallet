<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>mywallet - <?php echo $title; ?></title>

	<?php 
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('styles.css');
	?>
</head>
<body>
	<div class="container">
		
		<?php echo $this->fetch('content'); ?>		

	</div>

	<?php echo $this->Html->script('bootstrap.min'); ?>
</body>
</html>