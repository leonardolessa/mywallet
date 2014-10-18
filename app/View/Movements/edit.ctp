<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Adicionar Movimentação</h4>
</div>
<div class="modal-body">
	<?php 
		echo $this->Form->create(
			'Movement',
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
				'class' => 'form-movement-edit'
			)
		);
	?>

		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="mb-15">
					<?php
						echo $this->Form->input(
							'type',
							array(
								'type' => 'checkbox',
								'div' => false,	
								'label' => false,
								'class' => 'switch',
								'data-size' => 'large',
								'data-on-text' => 'Receita',
								'data-off-text' => 'Despesa',
								'data-on-color' => 'success',
								'data-off-color' => 'danger'
							)
						);

						echo $this->Form->input('id');
					?>
				</div>
			
				<?php 
			
					echo $this->Form->input(
						'amount',
						array(
							'type' => 'text',
							'label' => 'Valor',
							'class' => 'money form-control input-sm',
							'required' => true
						)
					);
			
					echo $this->Form->input(
						'date',
						array(
							'type' => 'text',
							'label' => 'Data',
							'class' => 'datepicker form-control input-sm'
						)
					);
				?>
			</div>
			
			
			<div class="col-md-6 col-xs-12">
				<div class="mb-15">
					<div class="break"></div>
					<?php
						echo $this->Form->input(
							'paid',
							array(
								'class' => 'switch',
								'type' => 'checkbox',
								'div' => false,
								'label' => false,
								'value' => '1',
								'data-size' => 'large',
								'data-on-text' => '<span class=\'glyphicon glyphicon-thumbs-up\'></span>',
								'data-off-text' => '<span class=\'glyphicon glyphicon-thumbs-down\'></span>',
								'escape' => false
							)
						)
					?>
				</div>
				
				<?php
					echo $this->Form->input(
						'category_id',
						array(
							'label' => 'Categoria',
							'empty' => 'Selecione uma categoria',
							'required' => true
						)
					);

					echo $this->Form->input(
						'description',
						array(
							'label' => 'Descrição'
						)
					);
				
					echo $this->Form->input(
						'user_id',
						array(
							'type' => 'hidden',
							'value' => $userData['id']
						)
					)
				?>
			</div>
		</div>

		<div class="form-group text-right">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary">Adicionar</button>
		</div>

	</form>
</div>

<script>
	MW.i.formMovement = new MW.components.FormMovement({
		form: $('.form-movement-edit'),
		action: 'edit'
	});
</script>