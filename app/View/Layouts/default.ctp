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
		echo $this->Html->css('bootstrap-switch.min');
		echo $this->Html->css('bootstrap-colorpicker.min');
		echo $this->Html->css('styles');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
</head>
<body class="app">
	<header class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<?php
					echo $this->Html->link(
						$this->Html->image(
							"logo.png",
							array(
								'alt' => 'logo',
								'class' => 'logo'
							)
						). ' mywallet',
						array(
							'controller' => 'pages',
							'action' => 'display',
							'home'
						),
						array(
							'class' => 'navbar-brand',
							'escape' => false
						)
					);
				?>

				<button type="button" data-toggle="collapse" data-target="#navbar-menu" class="navbar-toggle">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<nav class="navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
							<?php
								echo $this->Gravatar->getGravatar(
									$userData['email'],
									25,
									'mm',
									'g',
									true,
									array(
										'class' => 'img-rounded profile-image'
									)
								);
								echo $userData['name'];
							?>
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu">
							<li>
								<?php
									echo $this->Html->link(
										'Editar perfil',
										array(
											'controller' => 'users',
											'action' => 'edit',
											$userData['id']
										)
									);
								?>
							</li>
							<li class="divider"></li>
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

	<div class="alert alert-on alert-dismissable"></div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script>
		var ROOTURL = "<?php echo $this->Html->url('/', true); ?>"
	</script>
	<?php
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('jquery.validate.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('bootstrap-switch.min');
		echo $this->Html->script('bootstrap-colorpicker.min');
		echo $this->Html->script('script.min');
	?>
	<script src="//localhost:35729/livereload.js"></script>
</body>
</html>
