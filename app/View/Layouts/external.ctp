<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<title>mywallet</title>

	<?php 
		echo $this->Html->css('bootstrap.min.css');
		echo $this->Html->css('styles.css');
	?>
</head>
<body>
	<div class="content-container">
		<div class="external-page">
			<div class="external-header">
				<div class="logo text-center">
					<a href="javascript:;">MYWALLET</a>
				</div>
			</div>
			<?php echo $this->fetch('content'); ?>		
		</div>

	</div>
	
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<?php 
		echo $this->Html->script('bootstrap.min'); 
		echo $this->Html->script('script.min')
	?>

	<script src="//localhost:35729/livereload.js"></script>
</body>
</html>