<?php
// Caso o usuário não esteja logado, redireciona para o login
session_start();
if (empty($_SESSION['usuario'])) {
	header("Location: ../usuarios/login.php");
	exit;
}

// Fazer a conexao com o banco de dados
$con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

// Verificar se tem erro na conexão
if (mysqli_connect_errno()) {
	die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
}

// Fazer consulta de produtos
$qry = mysqli_query($con, 'SELECT * FROM produtos');
// Inicializar array
$produtos = [];
// Iterar registros
while ($row = mysqli_fetch_array($qry)) {
	// Adicionar dados do produto no array
	$produtos[] = $row;
}

// Inicializar a variável
$alerta = '';

// Se vierem variáveis post...
if ($_POST) {
	// Iterar no resultado na consulta dos produtos	
	foreach ($produtos as $key => $produto) {
		// Caso não vier no post, pular para a próxima iteração
		if (empty($_POST['produto-' . $produto['id']])) {
			continue;
		}

		// Inserir na tabela de estoque
		$sql = "INSERT INTO estoques (usuario_id, produto_id, quantidade) VALUES ({$_SESSION['usuario']['id']}, {$produto['id']}, {$_POST['produto-' . $produto['id']]})";

		// Se inserir com sucesso
		if (mysqli_query($con, $sql)) {
			// Exibir adição de produto em verde
			if ($_POST['produto-' . $produto['id']] > 0) {
				$alerta .= "<span style='color:green'>Produto {$produto['nome']}: +" . $_POST["produto-{$produto['id']}"] . "</span><br>";
			// Exibir remoção de produto em vermelho
			} else {
				$alerta .= "<span style='color:red'>Produto {$produto['nome']}: " . $_POST["produto-{$produto['id']}"] . "</span><br>";
			}

			// Atualizar quantidade do produto
			$sql2 = "UPDATE produtos SET quantidade = quantidade + {$_POST['produto-' . $produto['id']]} WHERE id = {$produto['id']}";
			// Caso for atualizado com sucesso
			if (mysqli_query($con, $sql2)) {
				// Criar mensagem de alerta
				$alerta .= "<span style='color:blue'>Produto {$produto['nome']} alterado o estoque de {$produto['quantidade']} para " . ($produto['quantidade'] + $_POST['produto-' . $produto['id']]) . "</span><br>";
				// Atualizar resultado de produtos que irá iterar no html
				$produtos[$key]['quantidade'] += $_POST['produto-' . $produto['id']];
			}
		}
	}
}
?>
<html>
	<head>
		<title>Estoques :: Controle</title>
	</head>
	<body>
		<h1>Controle de Estoque</h1>
		<?php if ($alerta) { ?>
			<h3><?php echo $alerta; ?></h3>
		<?php } ?>
		<hr>
		<form method="post" action="estoques.php">	
			<table border="1">
				<tr>
					<td>Id</td>
					<td>Produto</td>
					<td>Estoque Atual</td>
					<td>+/-</td>
				<tr>
				<?php foreach ($produtos as $produto) { ?>
				<tr>
					<td><?php echo $produto['id']; ?></td>
					<td><?php echo $produto['nome']; ?></td>
					<td><?php echo $produto['quantidade']; ?></td>
					<td><input type="text" name="produto-<?php echo $produto['id']; ?>" value="0"></td>
				</tr>
				<?php } ?> 
			</table>
			<hr>
			<input type="submit" value="Gravar">
			<input type="button" value="Cancelar" onclick="javascript:window.location='../index.php'">
		</form>		
	</body>
</html>