<?php 
	echo $this->element(
		'navigation',
		array(
			'active' => null
		)
	);
?>

<div class="container main-container">
	<?php echo $this->Session->flash(); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="well bs-component">
				<?php 
					echo $this->Form->create(
						'User',
						array(
							'inputDefaults' => array(
								'class' => 'form-control'
							),
							'action' => 'edit',
							'class' => 'form-horizontal'
						)
					);
				?>
					<fieldset>
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<?php 
									echo $this->Gravatar->getGravatar(
										$userData['email'],
										100,
										'mm',
										'g',
										true,
										array(
											'class' => 'img-rounded'
										)
									);
								?>
								<p>Para alterar sua imagem, você deve acessar o <a href="http://br.gravatar.com/" target="_blank">Gravatar</a>, uma forma fácil de manter sua foto em todos os lugares. </p>
							</div>
						</div>

						<div class="form-group">
							<label for="edit-name" class="col-lg-2 control-label">Nome</label>
							<div class="col-lg-10">
								<?php 
									echo $this->Form->input(
										'name',
										array(
											'label' => false,
											'id' => 'edit-name'
										)
									);
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">E-mail</label>
							<div class="col-lg-10">
								<?php 
									echo $this->Form->input(
										'email',
										array(
											'type' => 'email',
											'label' => false,
											'value' => $userData['email'],
											'disabled'
										)
									);
								?>
							</div>
						</div>

						<div class="form-group">
							<label for="edit-old-password" class="col-lg-2 control-label">Senha atual</label>
							<div class="col-lg-10">
								<?php 
									echo $this->Form->input(
										'oldPassword',
										array(
											'type' => 'password',
											'label' => false,
											'id' => 'edit-old-password',
											'required' => false
										)
									);
								?>
							</div>
						</div>

						<div class="form-group">
							<label for="edit-password" class="col-lg-2 control-label">Nova senha</label>
							<div class="col-lg-10">
								<?php 
									echo $this->Form->input(
										'newPassword',
										array(
											'type' => 'password',
											'label' => false,
											'id' => 'edit-password',
											'required' => false
										)
									);
								?>
								
							</div>
						</div>

						<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<button type="submit" class="btn btn-primary">Editar</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>