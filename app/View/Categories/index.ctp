<?php 
	echo $this->element(
		'navigation',
		array(
			'active' => 3
		)
	);
?>

<div class="container main-container">
	<div class="categories panel panel-default">
		<div class="panel-heading clearfix">
			<h3 class="pull-left panel-title">Categorias</h3>

			<a href="javascript:;" class="pull-right">
				<span class="glyphicon glyphicon-plus"><!-- Add category button --></span>
			</a>
		</div>

		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>cor</th>
						<th>nome</th>
						<th>ações</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<span class="glyphicon glyphicon-stop" style="color: #ccc;"></span>
						</td>
						<td>Salário</td>
						<td></td>
					</tr>
					<tr>
						<td>
							<span class="glyphicon glyphicon-stop" style="color: #ccc;"></span>
						</td>
						<td>Salário</td>
						<td></td>
					</tr>
				</tbody>	
			</table>
		</div>
	</div>

	<div class="loader-wrapper">
		<img src="img/loader.gif" alt="">
	</div>
</div>

<div class="modal fade modal-categories">
	<div class="modal-dialog">
		<div class="modal-content">
			
		</div>
	</div>
</div>