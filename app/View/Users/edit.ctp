<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 class="modal-title">Editar perfil</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			<div class="well bs-component">
				<?php 
					echo $this->Form->create(
						'User',
						array(
							'action' => 'edit',
							'class' => 'form-horizontal'
						)
					);
				?>
					<fieldset>
						<div class="form-group">
							<label for="edit-name" class="col-lg-2 control-label">Nome</label>
							<div class="col-lg-10">
								<?php 
									echo $this->Form->input(
										'name',
										array(
											'label' => false,
											'class' => 'form-control',
											'id' => 'edit-name'
										)
									);
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">E-mail</label>
							<div class="col-lg-10">
								<input type="text" class="form-control" disabled value="<?php echo $userData['email'] ?>">
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
											'class' => 'form-control',
											'id' => 'edit-old-password'
										)
									);
								?>
							</div>
						</div>

						<div class="form-group">
							<label for="edit-password" class="col-lg-2 control-label">Senha antiga</label>
							<div class="col-lg-10">
								<?php 
									echo $this->Form->input(
										'password',
										array(
											'label' => false,
											'class' => 'form-control',
											'id' => 'edit-password'
										)
									);
								?>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	<button type="submit" class="btn btn-primary">Editar</button>
</div>