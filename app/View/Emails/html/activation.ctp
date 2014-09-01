<h2>You have to activate your account through this link:</h2>
<?php 
	echo FULL_BASE_URL.$this->Html->url(
		array(
			'controller' => "users",
			'action' => 'activate', $token
		)
	);
?>