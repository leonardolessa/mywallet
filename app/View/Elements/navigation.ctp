<div class="navbar-wrapper">
	<aside class="navbar navbar-app">
		<nav class="navbar-collapse collapse" id="navbar-menu">
			<ul class="nav navbar-nav">
				<li <?php if($active == 1) echo 'class="active"'; ?>>
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

				<li <?php if($active == 2) echo 'class="active"'; ?>>
					<?php 
						echo $this->Html->link(
							'<span class="glyphicon glyphicon-list-alt"></span>
							Movimentações',
							array(
								'controller' => 'movements',
								'action' => 'index',
							),
							array(
								'escape' => false
							)
						);
					?>
				</li>

				<li <?php if($active == 3) echo 'class="active"'; ?>>
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

				<li <?php if($active == 4) echo 'class="active"'; ?>>
					<?php 
						echo $this->Html->link(
							'<span class="glyphicon glyphicon-stats"></span>
							Relatórios',
							array(
								'controller' => 'pages',
								'action' => 'display',
								'reports'
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