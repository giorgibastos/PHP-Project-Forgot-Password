<?php

require 'config.php';

if(!empty($_GET['token'])) {
	$token = $_GET['token'];

	$sql = "SELECT * FROM usuarios_token WHERE hash = :hash AND used = 0 AND expired_in > NOW()";
	$sql = $pdo->prepare($sql);
	$sql->bindValue(":hash", $token);
	$sql->execute();

	if($sql->rowCount() > 0) {
		$sql = $sql->fetch();
		$id = $sql['id_usuario'];

		if(!empty($_POST['password'])) {
			$password = $_POST['password'];

			$sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":senha", md5($password));
			$sql->bindValue(":id", $id);
			$sql->execute();

			$sql = "UPDATE usuarios_token SET used = 1 WHERE hash = :hash";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":hash", $token);
			$sql->execute();

			echo "Password changed successfully";
			exit;
		}

		?>
			<form method="POST">
				Digite a nova senha:<br/><br/>
				<input type="password" name="password" /><br/><br/>
				<input type="submit" value="Mudar Senha">
			</form>

		<?php
	} else {
		echo "Invalid token or already used";
		exit;
	}
}

?>