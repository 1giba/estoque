<?php
// Caso o usuário não esteja logado, redireciona para o login
session_start();
if (empty($_SESSION['usuario'])) {
	header("Location: ../usuarios/login.php");
	exit;
}

// Caso não passe na URL o id do produto, gerar exceção
if (empty($_GET['id'])) {
	throw new Exception('Não possui id de alteração');
}

// Fazer conexão com o banco de dados
$con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

// Verificar se existe erro na conexão
if (mysqli_connect_errno()) {
	die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
}

// Consultar os dados do produto
$qry = mysqli_query($con, 'SELECT * FROM produtos WHERE id = ' . $_GET['id']);
// Executar a consulta
$produto = mysqli_fetch_array($qry);

// Caso não encontre o produto, exibir mensagem
if (empty($produto)) {
	echo '<h1>Produto não encontrado!</h1>';
	exit;
}

// Se vierem dados do post...
if ($_POST) {
	// Atualizar o nome do produto
	if (mysqli_query($con, "UPDATE produtos SET nome='{$_POST['nome']}' WHERE id={$produto['id']}")) {
		// Criar mensagem de alerta
		$_SESSION['mensagem'] = 'Produto alterado com sucesso';
		// Redirecionar para a lista e exibir mensagem
		header('Location: produtos_listar.php');
		exit;
	}
}

// Inicializar variável de estoque
$estoques = [];
// Consultar movimento de estoque
$qry2 = mysqli_query($con, "SELECT e.*, u.nome as nome_usuario FROM estoques e INNER JOIN usuarios u ON u.id = e.usuario_id WHERE e.produto_id = {$produto['id']} ORDER BY e.criado_em DESC");
// Iterar nos registros da consulta
while ($row = mysqli_fetch_array($qry2)) {
	// Armazenar dados da movimentação no array
	$estoques[] = $row;
}
?>
<html>
	<head>
		<title>Produtos :: Alterar</title>
	</head>
	<body>
		<h1>Alterar Produto</h1>
		<h3>Produto #<?php echo $produto['id']; ?></h3>
		<hr>
		<form method="post" action="produtos_alterar.php?id=<?php echo $produto['id']; ?>">
			<label>Nome:</label>
			<input type="text" name="nome" length="100" required="required" value="<?php echo $produto['nome']; ?>"><br>
			<label>Quantidade:</label>
			<?php echo $produto['quantidade']; ?><hr>
			<input type="submit" value="Atualizar">
			<input type="button" value="Cancelar" onclick="javascript:window.location='produtos_listar.php'">
		</form>

		<h3>Movimento Estoque</h3>
		<table border="1">
			<tr>
				<td>Data</td>
				<td>Usuário</td>
				<td>Quantidade</td>
			</tr>
		<?php foreach ($estoques as $estoque) { ?>
			<?php 
				$class = '';
				if ($estoque['quantidade'] > 0) {
					$class = 'style="color:green"';
				} elseif ($estoque['quantidade'] < 0) {
					$class = 'style="color:red"';
				}
			?>
			<tr <?php echo $class; ?>>
				<td><?php echo date('d/m/Y H:i:s', strtotime($estoque['criado_em'])); ?></td>
				<td><?php echo $estoque['nome_usuario']; ?></td>
				<td><?php 
					if ($estoque['quantidade'] > 0) {	
						echo '+'; 
					} 
					echo $estoque['quantidade'];
					?>
				</td>
			</tr>
		<?php } ?>
		</table>
	</body>
</html>