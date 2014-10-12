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
		data-component="movements" 
		data-url="<?php echo $this->Html->url(array('controller' => 'movements', 'action' => 'index', 'ext' => 'json')) ?>"
	>
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="pull-left panel-title">Movimentações</h3>
			</div>
		
			<panel class="panel-body">
				<div class="row">
					<div class="col-md-3 col-sm-3">
						<div class="dropdown">
							<a href="javascript:;" data-toggle="dropdown" class="well-sm well filter-well">	
								Filtrar
							</a>

							<ul class="dropdown-menu">
								<li role="presentation" class="active">
									<a role="menuitem" tabindex="-1" href="#">Todos</a>
								</li>
								<li role="presentation">
									<a role="menuitem" tabindex="-1" href="#">Despesas</a>
								</li>
								<li role="presentation">
									<a role="menuitem" tabindex="-1" href="#">Receitas</a>
								</li>
							</ul>
						</div>
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
						<div class="dropdown pull-right">
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
			</panel>
			<div class="table-responsive">
				<table class="table table-striped table-hover table-movements">
					<thead>
						<tr>
							<th class="th-head-type">tipo</th>
							<th class="th-head-date">data</th>
							<th>descrição</th>
							<th>categoria</th>
							<th>valor</th>
							<th class="th-head-paid">&nbsp;</th>
							<th class="th-head-actions">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>	
				</table>
			</div>
		</div>
	</div>

	<div class="loader-wrapper">
		<img src="img/loader.gif" alt="">
	</div>
</div>

<div class="modal fade modal-movements">
	<div class="modal-dialog">
		<div class="modal-content">
			
		</div>
	</div>
</div>