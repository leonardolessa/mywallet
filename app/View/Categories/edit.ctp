<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Adicionar Categoria</h4>
</div>
<div class="modal-body">
	<?php
		echo $this->Form->create(
			'Category',
			array(
				'inputDefaults' => array(
					'div' => array(
						'class' => 'form-group'
					),
					'label' => array(
						'class' => 'control-label'
					),
					'class' => 'form-control input-sm'
				),
				'action' => 'edit',
				'class' => 'form-category-edit'
			)
		);

		echo $this->Form->hidden('id');
	?>

		<div class="row">
			<div class="col-md-12">
				<?php
					echo $this->Form->input(
						'name',
						array(
							'label' => 'Nome',
							'required' => true
						)
					);

				?>
				<div class="form-group color-picker input-group">
					<span class="input-group-addon"><i></i></span>
					<?php
						echo $this->Form->input(
							'color',
							array(
								'label' => false,
								'div' => false,
								'required' => true
							)
						);
					?>
				</div>

			</div>
		</div>

		<div class="form-group text-right">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary">Adicionar</button>
		</div>

	</form>
</div>

<script>
	MW.i.formCategory = new MW.components.FormCategory({
		form: $('.form-category-edit'),
		action: 'edit'
	});
</script>
