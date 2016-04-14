<?php

// Disponibiliza a classe
include '../classes/Mensagem.php';

// Instancia a classe
$m = new Mensagem();

// Se vierem os dados do post
if ($_POST) {
	// Disponibiliza a classe
	include '../classes/Conexao.php';

	// Instancia a classe
	$conexao = new Conexao();

	// Captura a conexão aberta
	$con = $conexao->getCon();

	// Disponibiliza a classe
	include '../classes/Usuario.php';

	// Instancia a classe
	$u = new Usuario($con);

	// Captura o usuário por e-mail
	$usuario = $u->selecionaUsuarioPorEmail($_POST['email']);
	// Valida as senhas, cria alerta
	if (empty($usuario) || $_POST['senha'] !== $usuario['senha']) {
		// Armazena a mensagem flash
		$m->flash('Usuário/Senha inválidos!', 'erro');
	// Senha ok!
	} else {		
		// Disponibiliza a classe
		include '../classes/Acesso.php';

		// Instancia a classe
		$acesso = new Acesso();

		// Define o usuário logado
		$acesso->setUsuario($usuario);

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
			// Exibe mensagem flash se houver
			echo $m->alerta();
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