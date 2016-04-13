<?php
// Inicializa a sessão
session_start();

// Se vierem os dados do post
if ($_POST) {
	// Fazer conexão com o banco de dados
	$con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

	// Verificar se existe erro na conexão
	if (mysqli_connect_errno()) {
		die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
	}	

	// Consultar o usuário pelo e-mail
	$qry = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '{$_POST['email']}'");
	// Armazena as informações do usuário em array
	$usuario = mysqli_fetch_array($qry);
	// Valida as senhas, cria alerta
	if (!mysqli_num_rows($qry) || $_POST['senha'] !== $usuario['senha']) {
		$_SESSION['mensagem'] = 'Usuário/Senha inválidos!';
	// Senha ok!
	} else {		
		// Joga os dados do usuário na sessão
		$_SESSION['usuario'] = $usuario;
		// Volta para o menu principal
		header('Location: ../index.php');
		exit;
	}
}
?>
<html>
	<head>
		<title>Controle de Estoque</title>
	</head>
	<body>
		<h1>Acesso ao Sistema</h1>
		<?php 
			if (!empty($_SESSION['mensagem'])){
				echo "<h2 style='color: red;'>{$_SESSION['mensagem']}</h2>";

				unset($_SESSION['mensagem']);
			}
		?>
		<hr>
		<form method="post" action="login.php">
			<label>Informe o e-mail:</label>
			<input type="email" name="email" length="255" required="required"><br>
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255" required="required"><hr>
			<input type="submit" value="Login">
		</form>
	</body>
</html>