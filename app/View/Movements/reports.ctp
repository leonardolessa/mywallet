<?php
	echo $this->element(
		'navigation',
		array(
			'active' => 4
		)
	);
?>


<div class="container main-container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default" data-component="ReportTabs" data-url="<?php echo $this->Html->url(array('controller' => 'payments', 'action' => 'generalReport')) ?>">
				<div class="panel-heading">
					<h2 class="panel-title">Relatórios</h2>
				</div>

				<div class="panel-body" >
					<ul class="nav nav-tabs">
						<li>
							<a href="#general" data-toggle="reportGeneral">Geral</a>
						</li>
						<li class="sec-level">
							<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle">Categorias <span class="caret"></span></a>
							<ul class="dropdown-menu categories-list" data-url="<?php echo $this->Html->url(array('controller' => 'categories', 'action' => 'index', 'ext' => 'json')) ?>">

							</ul>
						</li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane" id="general">
							<div class="graphic"></div>
						</div>
						<div class="tab-pane" id="categories">
							<div class="graphic"></div>
						</div>
						<div class="loader-wrapper tab-loader">
							<img src="../img/loader.gif" alt="">
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
