<?php
// Disponibiliza a classe
include '../classes/Acesso.php';

// Instancia a classe
$acesso = new Acesso();

// Verifica se o usuário está logado
$acesso->verificaLogin();

// Permite apenas o perfil admin
if (!$acesso->isAdmin()) {
	echo '<h1>Acesso não permitido</h1>';
	echo '<p><a href="../index.php">Voltar</a></p>';
	exit;
}

// Caso não passe na URL o id do usuário, gerar um erro
if (empty($_GET['id'])) {
	die('Você deve informar o id do usuario');
}

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

// Captura o usuário por id
$usuario = $u->selecionaUsuarioPorId($_GET['id']);

// Caso não encontre o usuário, exibir mensagem
if (empty($usuario)) {
	echo '<h1>Usuário não encontrado!</h1>';
	exit;
}

// Disponibiliza a classe
include '../classes/Mensagem.php';

// Instancia a classe
$m = new Mensagem();

// Se vierem variáveis do post...
if ($_POST) {
	// Inicializar variável
	$emailJaCadastrado = false;
	// Verificar se o e-mail do usuário cadastro é diferente do post
	if ($usuario['email'] !== $_POST['email']) {
		// atualiza o e-mail do usuário com o e-mail do post
		$usuario['email'] = $_POST['email'];

		// verifica se o e-mail já não está cadastrado
		$emailJaCadastrado = !empty($u->selecionaUsuarioPorEmail($usuario['email']));
	}

	// Atualizam os dados
	$usuario['nome'] = $_POST['nome'];
	$usuario['perfil'] = $_POST['perfil'];	

	// Caso o e-mail já esteja sendo utilizado, criar alerta
	if ($emailJaCadastrado) {
		// Armazena a mensagem flash
		$m->flash('E-mail já utilizado, adicione outro.', 'erro');
	// Senão
	} else {
		// Valida as senhas
		if ($_POST['senha'] != $_POST['senha_confirmacao']) {
			// Armazena a mensagem flash
			$m->flash('Senhas não conferem!', 'erro');
		// Caso a atualização for sucesso, redirecionar para a lista com mensagem de sucesso
		} elseif ($u->atualizaUsuario($usuario['id'], $usuario['nome'], $usuario['email'], $usuario['perfil'], !empty($_POST['senha']) ? $_POST['senha'] : '')) {

			// Armazena a mensagem flash
			$m->flash('Usuário alterado com sucesso!', 'sucesso');

			// Redireciona para a listagem de usuários
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
		<?php 
			// Exibe mensagem flash se houver
			echo $m->alerta(); 
		?>
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