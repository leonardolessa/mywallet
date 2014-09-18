<?php 
	echo $this->element(
		'navigation',
		array(
			'active' => 2
		)
	)
?>

<div class="main-container container">	
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<h3 class="pull-left">Movimentações</h3>
			<div class="add-btns pull-right ">
				<button type="button" class="btn btn-default btn-income">Receita</button>
				<button type="button" class="btn btn-default btn-outgoing">Despesa</button>
			</div>
		</div>

		<panel class="body">
			
		</panel>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<td>Tipo</td>
						<td>Data</td>
						<td>Descrição</td>
						<td>Categoria</td>
						<td>Valor</td>
						<td>#</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span class="glyphicon glyphicon-plus-sign income"></span></td>
						<td>03/10/2014</td>
						<td>descrição da receita</td>
						<td><span class="glyphicon glyphicon-stop" style="color: #ccc;"></span>Categoria</td>
						<td>R$ 200,00</td>
						<td></td>
					</tr>
					<tr>
						<td><span class="glyphicon glyphicon-minus-sign outgoing"></span></td>
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