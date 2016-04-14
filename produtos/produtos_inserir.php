<?php
// Verifica se o usuário está logado
include '../verifica_acesso.php';

// Se vierem os dados de post
if ($_POST) {
	// Captura a conexão aberta
	$con = include '../abre_conexao.php';

	// Disponibiliza as funções de operações com banco
	include '../operacoes_banco.php';

	// Caso o produto seja incluido com sucesso, criar alerta e redirecionar para a lista
	if (insereProduto($con, $_POST['nome'])) {
		// Disponibiliza as funções relacionadas às mensagens flash
		include '../mensagem_flash.php';
		
		// Armazena a mensagem flash
		flash('Produto inserido com sucesso', 'sucesso');

		// Redireciona para a listagem de produtos
		header("Location: produtos_listar.php");
		exit;
	}
}
?>
<html>
	<head>
		<title>Produtos :: Inserir</title>
	</head>
	<body>
		<h1>Incluir Produto</h1>
		<hr>
		<form method="post" action="produtos_inserir.php">
			<label>Nome:</label>
			<input type="text" name="nome" length="100" required="required"><br>
			<label>Quantidade:</label>
			0<hr>
			<input type="submit" value="Inserir">
			<input type="button" value="Cancelar" onclick="javascript:window.location='produtos_listar.php'">
		</form>
	</body>
</html>