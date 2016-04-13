<?php
// Caso o usuário não esteja logado, redireciona para o login
session_start();
if (empty($_SESSION['usuario'])) {
	header("Location: ../usuarios/login.php");
	exit;
}

// Caso o usuário não tenha o perfil admin, retorna para o index
if ($_SESSION['usuario']['perfil'] !== 'admin') {
	echo '<h1>Acesso não permitido</h1>';
	echo '<p><a href="../index.php">Voltar</a></p>';
	exit;
}

// Caso não passe na URL o id do usuário, gerar um erro
if (empty($_GET['id'])) {
	die('Você deve informar o id do usuario');
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
	// Inicializar variável
	$num = 0;
	// Verificar se o e-mail do usuário cadastro é diferente do post
	if ($usuario['email'] !== $_POST['email']) {
		// atualiza o e-mail do usuário com o e-mail do post
		$usuario['email'] = $_POST['email'];		
		// Consultar se o e-mail do post foi cadastrado com outro usuário
		$qry = mysqli_query($con, 'SELECT * FROM usuarios WHERE email = \'' . $usuario['email'] . '\'');
		// Armazena se encontrou usuário com e-mail 
		$num = mysqli_num_rows($qry);
	}

	// Atualizam os dados
	$usuario['nome'] = $_POST['nome'];
	$usuario['perfil'] = $_POST['perfil'];	

	// Caso o e-mail já esteja sendo utilizado, criar alerta
	if ($num) {
		$_SESSION['mensagem'] = 'E-mail já utilizado, adicione outro.';
	// Senão
	} else {
		// Monta Update
		$sql = "UPDATE usuarios SET nome='{$usuario['nome']}', email='{$usuario['email']}', perfil='{$usuario['perfil']}'";
		if ($_POST['senha'] && $_POST['senha_confirmacao']) {
			$sql .= ", senha='{$_POST['senha']}'";
		}
		$sql .= " WHERE id={$usuario['id']}";

		// Valida as senhas
		if ($_POST['senha'] != $_POST['senha_confirmacao']) {
			$_SESSION['mensagem']= 'Senhas não conferem!';
		// Caso a atualização for sucesso, redirecionar para a lista com mensagem de sucesso
		} elseif (mysqli_query($con, $sql)) {
			$_SESSION['mensagem'] = 'Usuário alterado com sucesso';
			header('Location: usuarios_listar.php');
			exit;
		}
	}
}
?>
<html>
	<head>
		<title>Usuários :: Alterar</title>
	</head>
	<body>
		<h1>Alterar Usuário</h1>
		<h3>Usuário #<?php echo $usuario['id']; ?></h3>
		<?php if ($_SESSION['mensagem']) { ?>
			<h3 style="color:red"><?php echo $_SESSION['mensagem']; ?></h3>
			<?php unset($_SESSION['mensagem']); ?>
		<?php } ?>
		<hr>
		<form method="post" action="usuarios_alterar.php?id=<?php echo $usuario['id']; ?>">
			<input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
			<label>Nome:</label>
			<input type="text" name="nome" length="100" required="required" value="<?php echo $usuario['nome']; ?>"><br>
			<label>E-mail:</label>
			<input type="text" name="email" length="255" required="required" value="<?php echo $usuario['email']; ?>"><br>
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255"><br>
			<label>Confirme a senha:</label>
			<input type="password" name="senha_confirmacao" length="255"><br>
			<label>Perfil:</label>
			<select name="perfil">
				<option value="admin" <?php if ($usuario['perfil'] === 'admin') { echo 'selected="selected"'; } ?>>Administrador</option>
				<option value="user" <?php if ($usuario['perfil'] === 'user') { echo 'selected="selected"'; } ?>>Funcionário</option>
			</select><hr>
			<input type="submit" value="Alterar">
			<input type="button" value="Cancelar" onclick="javascript:window.location='usuarios_listar.php'">
		</form>
	</body>
</html>