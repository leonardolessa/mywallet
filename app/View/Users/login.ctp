<div class="page-signin">
	<div class="signin-header">
		<section class="logo text-center">
			<a href="javascript:;">MYWALLET</a>
		</section>
	</div>

	<div class="signin-body">
		<div class="container">
			<div class="form-container">				
				<?php 
					echo $this->Form->create(
						'User', 
						array(
							'action' => 'login',
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
								'placeholder' => 'E-mail Address',
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
								'placeholder' => 'Password',
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
							'label' => 'Sign In'
						)
					);
				?>

				<section>
					<p class="text-center">
						<a href="#">Forgot your password?</a>
					</p>
					<p class="text-center text-muted text-small">
						Don't have an account yet? <a href="#">Sign up!</a>
					</p>
				</section>
			</div>
		</div>
	</div>
</div>