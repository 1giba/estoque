<?php
// Verifica se o usuário está logado
include '../verifica_acesso.php';

// Caso não passe na URL o id do usuário, gerar um erro
if (empty($_GET['id'])) {
	throw new Exception('Não possui id de alteração');
}

// Captura a conexão aberta
$con = include '../abre_conexao.php';

// Disponibiliza as funções de operações com banco
include '../operacoes_banco.php';

// Captura usuário pelo id
$usuario = selecionaUsuarioPorId($_GET['id']);

// Caso não encontre o usuário, exibir mensagem
if (empty($usuario)) {
	echo '<h1>Usuário não encontrado!</h1>';
	exit;
}

// Disponibiliza as funções relacionadas às mensagens flash
include '../mensagem_flash.php';

// Se vierem variáveis do post...
if ($_POST) {
	// Valida as senhas
	if ($_POST['senha'] !== $_POST['senha_confirmacao']) {
		// Armazena a mensagem flash
		flash('Senhas não conferem!', 'erro');
	// Caso a atualização for sucesso, redireciona para a lista e exibe mensagem de sucesso
	} elseif (atualizaSenha($con, $usuario['id'], $_POST['senha'])) {
		// Armazena a mensagem flash
		flash('Usuário alterado com sucesso', 'sucesso');

		// Redireciona para a listagem de usuários
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
		<?php 
			// Exibe mensagem flash se houver
			echo alerta(); 
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