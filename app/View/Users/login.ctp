<div class="form-signin">
	<?php 
		echo $this->Form->create(
			'User', 
			array('action' => 'login'
		)); 
	?>
	
	<h2 class="form-signin-heading">Please sign in</h2>
	
	<?php $this->Session->flash(); ?>

	<?php 
		echo $this->Form->input(
			'email',
			array(
				'type' => 'email',
				'class' => 'form-control',
				'placeholder' => 'E-mail Address',
				'label' => false
			)
		);

		echo $this->Form->input(
			'password',
			array(
				'type' => 'password',
				'class' => 'form-control',
				'placeholder' => 'Password',
				'label' => false
			)
		);

		echo $this->Form->end(
			array(
				'class' => 'btn btn-lg btn-primary btn-block',
				'label' => 'Sign In'
			)
		);
	?>
</div>