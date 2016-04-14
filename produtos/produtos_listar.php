<?php
// Disponibiliza a classe
include '../classes/Acesso.php';

// Instancia a classe
$acesso = new Acesso();

// Verifica se o usuário está logado
$acesso->verificaLogin();

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

// Captura os produtos
$produtos = $p->selecionaTodosProdutos(!empty($_GET['nome']) ? $_GET['nome'] : '');
?>
<html>
	<head>
		<title>Produtos :: Listar</title>
	</head>
	<body>
		<h1>Listar Produtos</h1>
		<?php 
			// Disponibiliza a classe
			include '../classes/Mensagem.php';

			// Instancia a classe
			$m = new Mensagem();

			// Exibe mensagem flash se houver
			echo $m->alerta();
		?>
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