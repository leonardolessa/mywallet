<h2>Você pode resetar sua senha através desse link:</h2>
<?php 
	echo FULL_BASE_URL.$this->Html->url(
		array(
			'controller' => "users",
			'action' => 'password', $token
		)
	);
?>