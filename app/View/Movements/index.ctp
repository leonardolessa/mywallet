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
						<ul class="pagination no-margin-vertical">
							<li><a href="javascript:;" class="back">«</a></li>
							<li>
								<a href="javascript:;" class="current">
									<span class="month">Setembro</span> de <span class="year">2014</span>
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
				<table class="table table-bordered table-striped table-hover table-movements">
					<thead>
						<tr>
							<td class="td-head-type">Tipo</td>
							<td class="td-head-date">Data</td>
							<td>Descrição</td>
							<td>Categoria</td>
							<td>Valor</td>
							<td>#</td>
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