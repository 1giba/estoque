<?php
// Disponibiliza a classe
include '../classes/Acesso.php';

// Instancia a classe
$acesso = new Acesso();

// Verifica se o usuário está logado
$acesso->verificaLogin();

// Caso não passe na URL o id do usuário, gerar um erro
if (empty($_GET['id'])) {
	throw new Exception('Não possui id de alteração');
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

// Captura usuário pelo id
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
	// Valida as senhas
	if ($_POST['senha'] !== $_POST['senha_confirmacao']) {
		// Armazena a mensagem flash
		$m->flash('Senhas não conferem!', 'erro');
	// Caso a atualização for sucesso, redireciona para a lista e exibe mensagem de sucesso
	} elseif ($u->atualizaSenha($usuario['id'], $_POST['senha'])) {
		// Armazena a mensagem flash
		$m->flash('Senha alterada com sucesso', 'sucesso');

		// Redireciona para o menu principal
		header('Location: ../index.php');
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
		<?php 
			// Exibe mensagem flash se houver
			echo $m->alerta(); 
		?>
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