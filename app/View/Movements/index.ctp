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
		data-url="<?php echo $this->Html->url(array('controller' => 'movements', 'action' => 'index')) ?>"
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
							<li><a href="javascript:;">«</a></li>
							<li><a href="javascript:;">Setembro</a></li>
							<li><a href="javascript:;">»</a></li>
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
						<tr>
							<td class="td-type">
								<span class="glyphicon glyphicon-upload income"></span>
							</td>
							<td>03/10/2014</td>
							<td>descrição da receita</td>
							<td><span class="glyphicon glyphicon-stop" style="color: #ccc;"></span>Categoria</td>
							<td>R$ 200,00</td>
							<td></td>
						</tr>
						<tr>
							<td><span class="glyphicon glyphicon-download outgoing"></span></td>
							<td>03/10/2014</td>
							<td>descrição da despesa</td>
							<td><span class="glyphicon glyphicon-stop" style="color: #C00;"></span>Categoria</td>
							<td>R$ 200,00</td>
							<td></td>
						</tr>
					</tbody>	
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-movements">
	<div class="modal-dialog">
		<div class="modal-content">
			
		</div>
	</div>
</div>