<div class="external-body">				
	<?php 
		echo $this->Form->create(
			'User', 
			array(
				'action' => 'password',
				'class' => 'form-horizontal',
				'autocomplete' => 'off'
			)
		);
	?>
	
	<?php 
		echo $this->Form->input(
			'token',
			array(
				'type' => 'hidden',
				'value' => $token
			)
		);
	?>

	<div class="form-group">
		<?php echo $this->Session->flash(); ?>
	</div>
	
	<div class="form-group">
		<span class="glyphicon glyphicon-lock"></span>
		<?php 
			echo $this->Form->input(
				'password',
				array(
					'type' => 'password',
					'class' => 'form-control input-lg text-center',
					'placeholder' => 'Nova senha',
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
				'label' => 'Entrar'
			)
		);
	?>
</div>