<?php
	require 'config.php';

	if(!empty($_POST['email'])) {
		$email = $_POST['email'];

		$sql = "SELECT * FROM usuarios WHERE email = :email";
		$sql = $pdo->prepare($sql);
		$sql->bindValue(":email", $email);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$sql = $sql->fetch();
			$id = $sql['id'];

			$token = md5(time().rand(0, 99999).rand(0, 99999));

			$sql = "INSERT INTO usuarios_token (id_usuario, hash, expired_in) VALUES(:id_usuario, :hash, :expired_in)";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id_usuario", $id);
			$sql->bindValue(":hash", $token);
			$sql->bindValue(":expired_in", date('Y-m-d H:i', strtotime('+2 days')));
			$sql->execute();

			$link = "http://localhost/projects/forgot-password/redefine.php?token=".$token;
			$message = "Click on the link to redefine your password:<br/>".$link;
			$subject = "Redefining password";
			$headers = 'From: giorgicb@gmail.com'."\r\n".'X-Mailer: PHP/'.phpversion();

			//mail($email, $subject, $message, $headers);

			echo $message;
			exit;
		}
	}
?>

<form method="POST">
	Qual seu email?<br/>
	<input type="email" name="email"><br/><br/>
	<input type="submit" value="Enviar">
</form>