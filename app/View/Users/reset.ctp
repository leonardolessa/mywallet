
<div class="external-body">
	<div class="info text-center">
		<p class="text-small">
			Adicione o endereço de e-mail que você usou para se cadastrar. Nós iremos mandar para você um e-mail com um link para resetar sua senha.
		</p>
	</div>

	<?php 
		echo $this->Form->create(
			'User', 
			array(
				'action' => 'reset',
				'class' => 'form-horizontal',
				'autocomplete' => 'off'
			)
		);
	?>

	<div class="form-group">
		<?php echo $this->Session->flash(); ?>
	</div>

	<div class="form-group">
		<span class="glyphicon glyphicon-envelope"></span>
		<?php  
			echo $this->Form->input(
				'email',
				array(
					'type' => 'email',
					'class' => 'form-control input-lg text-center',
					'placeholder' => 'Endereço de e-mail',
					'label' => false
				)
			);
		?>
	</div>
	
	<?php
		echo $this->Form->end(
			array(
				'div' => array(
					'class' => 'form-group'
				),
				'class' => 'btn btn-lg btn-primary text-center btn-block',
				'label' => 'Enviar'
			)
		);
	?>
</div>