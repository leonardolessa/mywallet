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
				'action' => 'add'
			)
		);
	?>

		<div class="mb-15">
			<input type="checkbox" class="switch" value="1" name="data[Movement][type]" data-size="large" data-on-text="Receita" data-off-text="Despesa" data-on-color="success" data-off-color="danger" checked>
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
					'label' => 'Valor'
				)
			);
		?>

		<div class="mb-15">
			<label class="control-label">Efetivado</label>
			<div class="break"></div>
			<input type="checkbox" class="switch" value="1" name="data[Movement][paid]" data-size="large" data-on-text="<span class='glyphicon glyphicon-thumbs-up'></span>" data-off-text="<span class='glyphicon glyphicon-thumbs-down'></span>">
		</div>

		<?php
			echo $this->Form->input(
				'category_id'
			);
		?>

		<div class="form-group text-right">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary">Adicionar</button>
		</div>

	</form>
</div>

<script>
	$('.switch').bootstrapSwitch();
</script>