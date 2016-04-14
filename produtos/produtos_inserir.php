<?php
// Disponibiliza a classe
include '../classes/Acesso.php';

// Instancia a classe
$acesso = new Acesso();

// Verifica se o usuário está logado
$acesso->verificaLogin();

// Se vierem os dados de post
if ($_POST) {
	// Disponibiliza a classe
	include '../classes/Conexao.php';

	// Instancia a classe
	$conexao = new Conexao();

	// Captura a conexão aberta
	$con = $conexao->getCon();

	// Disponibiliza a classe
	include '../classes/Produto.php';

	// Instancia a classe
	$p = new Produto($con);

	// Caso o produto seja incluido com sucesso, criar alerta e redirecionar para a lista
	if ($p->insereProduto($_POST['nome'])) {
		// Disponbiliza a classe
		include '../classes/Mensagem.php';

		// Instancia a classe
		$m = new Mensagem();

		// Armazena a mensagem flash
		$m->flash('Produto inserido com sucesso', 'sucesso');

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