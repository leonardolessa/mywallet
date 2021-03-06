<?php
	echo $this->element(
		'navigation',
		array(
			'active' => 2
		)
	)
?>

<div class="main-container container">
	<div
		class="movements"
		data-component="Movements"
		data-url="<?php echo $this->Html->url(array('action' => 'index', 'ext' => 'json')) ?>">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="pull-left panel-title">Movimentações</h3>
			</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-md-3 col-sm-3">
						<div class="fake-element"></div>
					</div>

					<div class="col-md-6 text-center col-sm-6">
						<ul class="pagination no-margin-vertical" data-url="<?php echo $this->Html->url(array('controller' => 'movements', 'action' => 'date', 'ext' => 'json')) ?>">
							<li><a href="javascript:;" class="previous">«</a></li>
							<li>
								<a href="javascript:;" class="current">
									<span class="month"></span> de <span class="year"></span>
								</a>
							</li>
							<li><a href="javascript:;" class="next">»</a></li>
						</ul>
					</div>

					<div class="col-md-3 col-sm-3">
						<div class="dropdown add-wrapper">
							<a
								href="<?php echo $this->Html->url(array('action' => 'add')); ?>"
								class="well-sm well well-add"
								data-toggle="modal"
								data-target=".modal-movements">

								<span class="glyphicon glyphicon-plus"><!-- Add movements button --></span>
								Adicionar
							</a>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-movements" data-order='[[ 1, "desc" ]]'>
						<thead>
							<tr>
								<th class="th-head-type">tipo</th>
								<th class="th-head-date">data</th>
								<th>descrição</th>
								<th>categoria</th>
								<th>valor</th>
								<th class="th-head-paid no-sort">&nbsp;</th>
								<th class="th-head-actions no-sort" data-url="<?php echo $this->Html->url(array('controller' => 'movements')) ?>">&nbsp;</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="row balance-wrapper">
			<div class="col-md-6">
				<div class="balance panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Saldo mensal</h3>
					</div>

					<div class="panel-body">
						<div class="wrapper-col text-left labels">
							<p>Receitas</p>
							<p>Despesas</p>
						</div>
						<div class="wrapper-col text-right">
							<p class="total-incoming"></p>
							<p class="total-expenses"></p>
						</div>
						<div class="wrapper-col pull-right total-balance-month">
							Total   <span class="total"></span>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Saldo total</h3>
					</div>
					<div class="panel-body">
						<div class="total-balance pull-right"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="loader-wrapper">
			<img src="img/loader.gif" alt="">
		</div>
	</div>

</div>

<div class="modal fade modal-movements">
	<div class="modal-dialog">
		<div class="modal-content">

		</div>
	</div>
</div>
