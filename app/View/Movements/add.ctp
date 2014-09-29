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
					'class' => 'form-control'
				),
				'action' => 'add',
				'class' => 'form-movement-add',
			)
		);
	?>

		<div class="mb-15 text-center">
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
				'description',
				array(
					'label' => 'Descrição'
				)
			);

			echo $this->Form->input(
				'amount',
				array(
					'type' => 'text',
					'label' => 'Valor',
					'class' => 'money form-control',
					'data-prefix' => 'R$ ',
					'data-thousands' => '.',
					'data-decimal' => ','
				)
			);

			echo $this->Form->input(
				'date',
				array(
					'type' => 'text',
					'label' => 'Data',
					'class' => 'datepicker form-control'
				)
			);
		?>

		<div class="mb-15">
			<label class="control-label">Pago</label>
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
					'label' => 'Categoria'
				)
			);
		?>

		<div class="form-group text-right">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary">Adicionar</button>
		</div>

	</form>
</div>

<script>
	MW.i.formMovement = new MW.components.FormMovement({
		form: $('.form-movement-add')
	});
</script>