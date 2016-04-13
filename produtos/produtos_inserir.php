<?php
// Caso o usuário não esteja logado, redireciona para o login
session_start();
if (empty($_SESSION['usuario'])) {
	header("Location: ../usuarios/login.php");
	exit;
}

// Se vierem os dados de post
if ($_POST) {
	// Fazer a conexao com o banco de dados
	$con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

	// Verificar se existe erro na conexão
	if (mysqli_connect_errno()) {
		die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
	}

	// Caso o produto seja incluido com sucesso, criar alerta e redirecionar para a lista
	if (mysqli_query($con, "INSERT INTO produtos (nome) VALUES ('{$_POST['nome']}')")) {
		$_SESSION['mensagem'] = 'Produto inserido com sucesso';
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