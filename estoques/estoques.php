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

// Disponibiliza as classes
include '../classes/Produto.php';
include '../classes/Estoque.php';

// Instancia as classes
$p = new Produto($con);
$e = new Estoque($con);

// Captura todos os produtos
$produtos = $p->selecionaTodosProdutos();

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

		// Se inserir com sucesso
		if ($e->insereEstoque($_SESSION['usuario']['id'], $produto['id'], $_POST['produto-' . $produto['id']])) {
			// Exibir adição de produto em verde
			if ($_POST['produto-' . $produto['id']] > 0) {
				$alerta .= "<span style='color:green'>Produto {$produto['nome']}: +" . $_POST["produto-{$produto['id']}"] . "</span><br>";
			// Exibir remoção de produto em vermelho
			} else {
				$alerta .= "<span style='color:red'>Produto {$produto['nome']}: " . $_POST["produto-{$produto['id']}"] . "</span><br>";
			}

			// Caso for atualizado com sucesso
			if ($p->atualizaEstoqueProduto($produto['id'], $_POST['produto-' . $produto['id']])) {
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