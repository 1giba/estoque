<?php
// Verifica se o usuário está logado
include '../verifica_acesso.php';

// Permite apenas o perfil admin
include '../somente_admin.php';

// Inicializar variáveis
$nome   = '';
$email  = '';
$perfil = '';

// Disponibiliza as funções relacionadas às mensagens flash
include '../mensagem_flash.php';

// Caso vierem variáveis de post
if ($_POST) {
	// Captura a conexão aberta
	$con = include '../abre_conexao.php';

	// Disponibiliza as funções de operações com banco
	include '../operacoes_banco.php';

	// Variáveis recebem dados do post
	$nome   = $_POST['nome'];
	$email  = $_POST['email'];
	$perfil = $_POST['perfil'];

	// Verifica se o cliente já está utilizando o e-mail
	$emailJaCadastrado = !empty(selecionaUsuarioPorEmail($con, $email));

	// Caso tenha 1 registro já com esse e-mail, criar alerta
	if ($emailJaCadastrado) {
		// Armazena a mensagem flash
		flash('E-mail já utilizado, adicione outro.', 'erro');
	// Caso não tenha usuário com esse e-mail...
	} else {
		// Caso as senhas forem diferentes, criar alerta
		if ($_POST['senha'] != $_POST['senha_confirmacao']) {
			// Armazena a mensagem flash
			flash('Senhas não conferem!', 'erro');
		// Caso a inclusão for sucesso, redirecionar para a lista com mensagem de sucesso
		} elseif (insereUsuario($con, $nome, $email, $perfil, $_POST['senha'])) {

			// Armazena a mensagem flash
			flash('Usuário inserido com sucesso!', 'sucesso');

			// Redireciona para a listagem de usuários
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
		    // Exibe mensagem flash se houver
			echo alerta(); 
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