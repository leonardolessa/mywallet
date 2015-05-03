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
				<div class="panel-body" data-component="WidgetMovements" data-url="<?php echo $this->Html->url(array('controller' => 'movements', 'action' => 'index', 'ext' => 'json')) ?>">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-movements widget-table">
							<thead>
								<tr>
									<th class="th-head-type">tipo</th>
									<th class="th-head-date">data</th>
									<th>descrição</th>
									<th>categoria</th>
									<th>valor</th>
									<th class="th-head-paid">&nbsp;</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<div class="loader-wrapper table-loader">
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
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Categorias</h3>
				</div>

				<div
					class="panel-body"
					data-component="WidgetCategories"
					data-url="<?php echo $this->Html->url(array('controller' => 'categories', 'action' => 'index', 'ext' => 'json')) ?>">

					<div class="table-responsive">
						<table class="table table-striped table-hover widget-table">
							<thead>
								<tr>
									<th>cor</th>
									<th>nome</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>

					<div class="loader-wrapper table-loader">
						<img src="img/loader.gif" alt="">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
