<html>
	<head>
		<title>Produtos :: Listar</title>
	</head>
	<body>
		<h1>Listar Produtos</h1>
		<?php 
			// Exibe mensagem flash se houver
			echo $this->mensagem->alerta();
		?>
		<hr>
		<form method="get" action="<?php echo $this->helper->url('ProdutoController@listar'); ?>">
			<?php echo $this->helper->hiddenTags('ProdutoController@listar'); ?>
			<label>Procurar por nome:</label>
			<input type="text" name="nome" length="100">
			<input type="submit" value="Buscar">
			<input type="reset" value="Limpar">			
		</form>
		<hr>
		<p><a href="<?php echo $this->helper->url('ProdutoController@inserir'); ?>">Inserir Produto</a>&nbsp;<a href="<?php echo $this->helper->url('HomeController@index'); ?>">Voltar</a></p>
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
					<td><a href="<?php echo $this->helper->url('ProdutoController@alterar', ['id' => $produto['id']]); ?>">Alterar</a></td>
				</tr>
			<?php }	?>
		</table>
	</body>
</html>