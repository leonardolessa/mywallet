<div class="navbar-wrapper">
	<aside class="navbar navbar-app">
		<nav class="navbar-collapse collapse" id="navbar-menu">
			
			<ul class="nav navbar-nav">
				<li class="active">
					<?php 
						echo $this->Html->link(
							'<span class="glyphicon glyphicon-home"></span>
							Dashboard',
							array(
								'controller' => 'pages',
								'action' => 'display',
								'home'
							),
							array(
								'escape' => false
							)
						);
					?>
				</li>

				<li>
					<?php 
						echo $this->Html->link(
							'<span class="glyphicon glyphicon-tags"></span>
							Categorias',
							array(
								'controller' => 'categories',
								'action' => 'index',
							),
							array(
								'escape' => false
							)
						);
					?>
				</li>
			</ul>
		</nav>
	</aside>
</div>