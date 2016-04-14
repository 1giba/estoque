<?php
// Verifica se o usuário está logado
include '../verifica_acesso.php';

// Captura a conexão aberta
$con = include '../abre_conexao.php';

// Disponibiliza as funções de operações com banco
include '../operacoes_banco.php';

// Captura os produtos
$produtos = selecionaTodosProdutos($con, !empty($_GET['nome']) ? $_GET['nome'] : '');
?>
<html>
	<head>
		<title>Produtos :: Listar</title>
	</head>
	<body>
		<h1>Listar Produtos</h1>
		<?php 
			// Disponibiliza as funções relacionadas às mensagens flash
			include '../mensagem_flash.php';

			// Exibe mensagem flash se houver
			echo alerta();
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