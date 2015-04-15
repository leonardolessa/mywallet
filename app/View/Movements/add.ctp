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
				'action' => 'add',
				'class' => 'form-movement-add'
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
								'data-off-color' => 'danger',
								'checked' => true
							)
						)
					?>
				</div>

				<?php

					echo $this->Form->input(
						'Payment.amount',
						array(
							'type' => 'text',
							'label' => 'Valor',
							'class' => 'money form-control input-sm',
							'required' => true
						)
					);

					echo $this->Form->input(
						'Payment.date',
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
							'Payment.paid',
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

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>
						Repetir movimentação?
						<span
							class="glyphicon glyphicon-info-sign"
							data-toggle="tooltip"
							data-placement="bottom"
							data-original-title="Elas serão repetidas mensalmente após a data selecionada.">
						</span>
						<br>
						<input type="checkbox" class="repeat-toggle">
					</label>
					<?php
						echo $this->Form->input(
							'Payment.times',
							array(
								'div' => false,
								'label' => false,
								'options' => array(1 => 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
								'empty' => array(
									'0' => 'Selecione o número de vezes'
								),
								'class' => 'repeat-select form-control input-sm'
							)
						)
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
	MW.i.formMovement = new MW.components.FormMovement({
		form: $('.form-movement-add'),
		action: 'add'
	});
</script>
