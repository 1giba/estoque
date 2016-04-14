<?php
// Verifica se o usuário está logado
include '../verifica_acesso.php';

// Permite apenas o perfil admin
include '../somente_admin.php';

// Caso não passe na URL o id do usuário, gerar um erro
if (empty($_GET['id'])) {
	die('Você deve informar o id do usuario');
}

// Captura a conexão aberta
$con = include '../abre_conexao.php';

// Disponibiliza as funções de operações com banco
include '../operacoes_banco.php';

// Captura o usuário por id
$usuario = selecionaUsuarioPorId($con, $_GET['id']);

// Caso não encontre o usuário, exibir mensagem
if (empty($usuario)) {
	echo '<h1>Usuário não encontrado!</h1>';
	exit;
}

// Disponibiliza as funções relacionadas às mensagens flash
include '../mensagem_flash.php';

// Se vierem variáveis do post...
if ($_POST) {
	// Inicializar variável
	$emailJaCadastrado = false;
	// Verificar se o e-mail do usuário cadastro é diferente do post
	if ($usuario['email'] !== $_POST['email']) {
		// atualiza o e-mail do usuário com o e-mail do post
		$usuario['email'] = $_POST['email'];

		// verifica se o e-mail já não está cadastrado
		$emailJaCadastrado = !empty(selecionaUsuarioPorEmail($con, $usuario['email']));
	}

	// Atualizam os dados
	$usuario['nome'] = $_POST['nome'];
	$usuario['perfil'] = $_POST['perfil'];	

	// Caso o e-mail já esteja sendo utilizado, criar alerta
	if ($emailJaCadastrado) {
		// Armazena a mensagem flash
		flash('E-mail já utilizado, adicione outro.', 'erro');
	// Senão
	} else {
		// Valida as senhas
		if ($_POST['senha'] != $_POST['senha_confirmacao']) {
			// Armazena a mensagem flash
			flash('Senhas não conferem!', 'erro');
		// Caso a atualização for sucesso, redirecionar para a lista com mensagem de sucesso
		} elseif (atualizaUsuario($con, $usuario['id'], $ususario['nome'], $usuario['email'], $usuario['perfil'], !empty($_POST['senha']) ? $_POST['senha'] : '')) {

			// Armazena a mensagem flash
			flash('Usuário alterado com sucesso!', 'sucesso');

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
			echo alerta(); 
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