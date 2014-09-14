<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		mywallet
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('styles');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="app">
	<header class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a href="javascript:;" class="navbar-brand">mywallet</a>

				<button type="button" data-toggle="collapse" data-target="#navbar-menu" class="navbar-toggle">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<nav class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
							User
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu">
							<li>
								<?php 
									echo $this->Html->link(
										'Sair',
										array(
											'controller' => 'users',
											'action' => 'logout'
										)
									);
								?>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>		
	</header>

	<?php echo $this->fetch('content'); ?>

	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<?php 
		echo $this->Html->script('bootstrap.min'); 
		echo $this->Html->script('script.min');
	?>
	<script src="//localhost:35729/livereload.js"></script>
</body>
</html>
