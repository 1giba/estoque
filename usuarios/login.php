<?php

// Disponibiliza as funções relacionadas às mensagens flash
include '../mensagem_flash.php';

// Se vierem os dados do post
if ($_POST) {
	// Captura a conexão aberta
	$con = include '../abre_conexao.php';

	// Disponibiliza as funções de operações com banco
	include '../operacoes_banco.php';

	// Captura o usuário por e-mail
	$usuario = selecionaUsuarioPorEmail($con, $_POST['email']);
	// Valida as senhas, cria alerta
	if (empty($usuario) || $_POST['senha'] !== $usuario['senha']) {
		// Armazena a mensagem flash
		flash('Usuário/Senha inválidos!', 'erro');
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
			// Exibe mensagem flash se houver
			echo alerta();
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