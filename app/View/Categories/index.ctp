<?php
	echo $this->element(
		'navigation',
		array(
			'active' => 3
		)
	);
?>

<div class="container main-container">
	<div
		class="categories"
		data-component="Categories"
		data-url="<?php echo $this->Html->url(array('action' => 'index', 'ext' => 'json')) ?>">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="pull-left panel-title">Categorias</h3>
				<a
					href="<?php echo $this->Html->url(array('action' => 'add')); ?>"
					class="pull-right"
					data-toggle="modal"
					data-target=".modal-categories">

					<span class="glyphicon glyphicon-plus"><!-- Add category button --></span>
				</a>
			</div>

			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>cor</th>
							<th>nome</th>
							<th class="th-head-actions" data-url="<?php echo $this->Html->url(array('controller' => 'categories')) ?>">ações</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<div class="loader-wrapper">
			<img src="img/loader.gif" alt="">
		</div>
	</div>

</div>

<div class="modal fade modal-categories">
	<div class="modal-dialog">
		<div class="modal-content">

		</div>
	</div>
</div>
