<?php
// Caso o usuário não esteja logado, redireciona para o login
session_start();
if (empty($_SESSION['usuario'])) {
	header("Location: ../usuarios/login.php");
	exit;
}

// Caso não passe na URL o id do usuário, gerar um erro
if (empty($_GET['id'])) {
	throw new Exception('Não possui id de alteração');
}

// Fazer a conexão com o banco de dados
$con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

// Verificar se existe erro na conexão
if (mysqli_connect_errno()) {
	die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
}

// Consulta usuário para alteração de dados
$qry = mysqli_query($con, 'SELECT * FROM usuarios WHERE id = ' . $_GET['id']);
$usuario = mysqli_fetch_array($qry);

// Caso não encontre o usuário, exibir mensagem
if (empty($usuario)) {
	echo '<h1>Usuário não encontrado!</h1>';
	exit;
}

// Se vierem variáveis do post...
if ($_POST) {
	// Valida as senhas
	if ($_POST['senha'] !== $_POST['senha_confirmacao']) {
		$_SESSION['mensagem'] = 'Senhas não conferem!';
	// Caso a atualização for sucesso, redireciona para a lista e exibe mensagem de sucesso
	} elseif (mysqli_query($con, "UPDATE usuarios SET senha='{$_POST['senha']}' WHERE id={$usuario['id']}")) {
		$_SESSION['mensagem'] = 'Usuário alterado com sucesso';
		header('Location: usuarios_listar.php');
		exit;
	}
}
?>
<html>
	<head>
		<title>Usuários :: Alterar Senha</title>
	</head>
	<body>
		<h1>Alterar Senha</h1>
		<h3>Usuário #<?php echo $usuario['nome'] . ' - ' . $usuario['email'] . ' [' . $usuario['perfil'] . ']'; ?></h3>
		<?php if ($_SESSION['mensagem']) { ?>
			<h3 style="color:red"><?php echo $_SESSION['mensagem']; ?></h3>
			<?php unset($_SESSION['mensagem']); ?>
		<?php } ?>
		<hr>
		<form method="post" action="alterar_senha.php?id=<?php echo $usuario['id']; ?>">
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255" required="required"><br>
			<label>Confirme a senha:</label>
			<input type="password" name="senha_confirmacao" length="255" required="required"><hr>
			<input type="submit" value="Alterar Senha">
			<input type="button" value="Cancelar" onclick="javascript:window.location='../index.php'">
		</form>
	</body>
</html>