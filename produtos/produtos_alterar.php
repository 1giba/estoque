<?php
// Disponibiliza a classe
include '../classes/Acesso.php';

// Instancia a classe
$acesso = new Acesso();

// Verifica se o usuário está logado
$acesso->verificaLogin();

// Caso não passe na URL o id do produto, gerar exceção
if (empty($_GET['id'])) {
	throw new Exception('Não possui id de alteração');
}

// Disponibiliza a classe
include '../classes/Conexao.php';

// Instancia a classe
$conexao = new Conexao();

// Captura a conexão aberta
$con = $conexao->getCon();

// Disponibiliza as classes
include '../classes/Produto.php';
include '../classes/Estoque.php';

// Instancia as classes
$p = new Produto($con);
$e = new Estoque($con);

// Captura o produto pelo ID
$produto = $p->selecionaProdutoPorId($_GET['id']);

// Caso não encontre o produto, exibir mensagem
if (empty($produto)) {
	echo '<h1>Produto não encontrado!</h1>';
	exit;
}

// Se vierem dados do post...
if ($_POST) {
	// Atualizar o nome do produto
	if ($p->atualizaNomeDoProduto($produto['id'], $_POST['nome'])) {
		// Disponbiliza a classe
		include '../classes/Mensagem.php';

		// Instancia a classe
		$m = new Mensagem();

		// Armazena a mensagem flash
		$m->flash('Produto alterado com sucesso', 'sucesso');
		
		// Redirecionar para a lista e exibir mensagem
		header('Location: produtos_listar.php');
		exit;
	}
}

// Captura a movimentação do estoque do produto
$estoques = $e->selecionaMovimentoEstoqueDoProduto($produto['id']);
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