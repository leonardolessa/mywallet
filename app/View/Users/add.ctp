<div class="external-body">				
	<?php 
		echo $this->Form->create(
			'User', 
			array(
				'action' => 'add',
				'class' => 'form-horizontal',
				'autocomplete' => 'off'
			)
		);
	?>

	<div class="form-group">
		<?php echo $this->Session->flash(); ?>
	</div>

	<div class="form-group">
		<span class="glyphicon glyphicon-user"></span>
		<?php  
			echo $this->Form->input(
				'name',
				array(
					'type' => 'text',
					'class' => 'form-control input-lg text-center',
					'placeholder' => 'Nome',
					'label' => false
				)
			);
		?>
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
	<div class="form-group">
		<span class="glyphicon glyphicon-lock"></span>
		<?php 
			echo $this->Form->input(
				'password',
				array(
					'type' => 'password',
					'class' => 'form-control input-lg text-center',
					'placeholder' => 'Senha',
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
				'label' => 'Cadastrar'
			)
		);
	?>

	<section>
		<p class="text-center text-muted text-small">
			Já tem uma conta?
			<?php 
				echo $this->Html->link(
					'Logar-se',
					array(
						'controller' => 'users',
						'action' => 'login'
					)
				); 
			?>
		</p>
	</section>
</div>