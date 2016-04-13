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

// Inicializar variáveis
$nome   = '';
$email  = '';
$perfil = '';

// Caso vierem variáveis de post
if ($_POST) {
	// Fazer a conexão com o banco de dados
	$con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

	// Verificar se existe erro na conexão
	if (mysqli_connect_errno()) {
		die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
	}

	// Variáveis recebem dados do post
	$nome   = $_POST['nome'];
	$email  = $_POST['email'];
	$perfil = $_POST['perfil'];

	// Verifica se o cliente já está utilizando o e-mail
	$qry = mysqli_query($con, 'SELECT * FROM usuarios WHERE email = \'' .$email . '\'');

	// Caso tenha 1 registro já com esse e-mail, criar alerta
	if (mysqli_num_rows($qry)) {
		$_SESSION['mensagem'] = 'E-mail já utilizado, adicione outro.';
	// Caso não tenha usuário com esse e-mail...
	} else {
		// Caso as senhas forem diferentes, criar alerta
		if ($_POST['senha'] != $_POST['senha_confirmacao']) {
			$_SESSION['mensagem'] = 'Senhas não conferem!';
		// Caso a inclusão for sucesso, redirecionar para a lista com mensagem de sucesso
		} elseif (mysqli_query($con, "INSERT INTO usuarios (nome, email, senha, perfil) VALUES ('{$nome}', '{$email}', '{$_POST['senha']}', '{$perfil}')")) {
			$_SESSION['mensagem'] = 'Usuário inserido com sucesso';

			header("Location: usuarios_listar.php");
			exit;
		}
	}
}
?>
<html>
	<head>
		<title>Usuários :: inserir</title>
	</head>
	<body>
		<h1>Novo Usuário</h1>
		<?php 
			if (!empty($_SESSION['mensagem'])){
				echo "<h2 style='color: red;'>{$_SESSION['mensagem']}</h2>";

				unset($_SESSION['mensagem']);
			} 
		?>
		<hr>
		<form method="post" action="usuarios_inserir.php">
			<label>Nome:</label>
			<input type="text" name="nome" length="100" required="required" value="<?php echo $nome; ?>"><br>
			<label>E-mail:</label>
			<input type="text" name="email" length="255" required="required" value="<?php echo $email; ?>"><br>
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255" required="required"><br>
			<label>Confirme a senha:</label>
			<input type="password" name="senha_confirmacao" length="255" required="required"><br>
			<label>Perfil:</label>
			<select name="perfil">
				<option value="admin" <?php if ($perfil === 'admin') { echo 'selected="selected"'; } ?>>Administrador</option>
				<option value="user" <?php if ($perfil === 'user') { echo 'selected="selected"'; } ?>>Funcionário</option>
			</select><hr>
			<input type="submit" value="Inserir">
			<input type="button" value="Cancelar" onclick="javascript:window.location='usuarios_listar.php'">
		</form>
	</body>
</html>