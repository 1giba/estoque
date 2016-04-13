<?php
// Caso o usuário não esteja logado, redireciona para o login
session_start();
if (empty($_SESSION['usuario'])) {
	header("Location: ../usuarios/login.php");
	exit;
}

// Fazer conexão com o banco de dados
$con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

// Verificar se existe erro na conexão
if (mysqli_connect_errno()) {
	die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
}

// Consulta principal de produtos
$sql  = "SELECT * FROM produtos";

// Caso venha o nome, adicionar no SQL
if (!empty($_GET['nome'])) {
	$sql .= " WHERE nome LIKE '%{$_GET['nome']}%'";
}

// Executar consulta
$qry = mysqli_query($con, $sql);

// Inicializar produtos
$produtos = [];

// Iterar no resultado da consulta de produtos
while ($row = mysqli_fetch_array($qry)) {
	// Adicionar dados do produto no array
	$produtos[] = $row;
}
?>
<html>
	<head>
		<title>Produtos :: Listar</title>
	</head>
	<body>
		<h1>Listar Produtos</h1>
		<?php if (!empty($_SESSION['mensagem'])) { ?>
			<h3 style="color:green"><?php echo $_SESSION['mensagem']; ?></h3>
			<?php unset($_SESSION['mensagem']); ?>
		<?php } ?>
		<hr>
		<form method="get" action="produtos_listar.php">
			<label>Procurar por nome:</label>
			<input type="text" name="nome" length="100">
			<input type="submit" value="Buscar">
			<input type="reset" value="Limpar">			
		</form>
		<hr>
		<p><a href="produtos_inserir.php">Inserir Produto</a>&nbsp;<a href="../index.php">Voltar</a></p>
		<table border="1">
			<tr>
				<td>Id</td>
				<td>Produto</td>
				<td>Quantidade</td>
				<td>Ações</td>
			<tr>
			<?php foreach ($produtos as $produto) { ?>
				<tr>
					<td><?php echo $produto['id']; ?></td>
					<td><?php echo $produto['nome']; ?></td>
					<td><?php echo $produto['quantidade']; ?></td>
					<td><a href="produtos_alterar.php?id=<?php echo $produto['id']; ?>">Alterar</a></td>
				</tr>
			<?php }	?>
		</table>
	</body>
</html>