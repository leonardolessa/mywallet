<?php
	echo $this->element(
		'navigation',
		array(
			'active' => 1
		)
	);
?>

<div class="container main-container">
	<div class="row">
		<div class="col-md-8 widget">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Últimas movimentações</h3>
				</div>
				<div class="panel-body">
					<div class="loader-wrapper">
						<img src="img/loader.gif" alt="">
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4 widget">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Despesas/Receitas</h3>
				</div>

				<div
					class="panel-body"
					data-component="WidgetOverview"
					data-url="<?php echo $this->Html->url(array('controller' => 'movements', 'action' => 'overview', 'ext' => 'json')) ?>">
					<div class="loader-wrapper">
						<img src="img/loader.gif" alt="">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Categorias</h3>
				</div>

				<div class="panel-body">
					<div class="loader-wrapper">
						<img src="img/loader.gif" alt="">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
