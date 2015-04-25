<div class="external-body">
	<div class="row">
		<div class="col-md-12">
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
						'label' => 'Entrar'
					)
				);
			?>

			<section>
				<p class="text-center">
					<?php
						echo $this->Html->link(
							'Esqueceu sua senha?',
							array(
								'controller' => 'users',
								'action' => 'reset'
							)
						);
					?>
				</p>
				<p class="text-center text-muted text-small">
					Não tem uma conta ainda?
					<?php
						echo $this->Html->link(
							'Inscreva-se',
							array(
								'controller' => 'users',
								'action' => 'add'
							)
						);
					?>
				</p>
			</section>
		</div>
	</div>
</div>
