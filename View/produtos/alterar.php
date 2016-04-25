<html>
	<head>
		<title>Produtos :: Alterar</title>
	</head>
	<body>
		<h1>Alterar Produto</h1>
		<h3>Produto #<?php echo $produto['id']; ?></h3>
		<hr>
		<form method="post" action="<?php echo $this->helper->url('ProdutoController@alterar', ['id' => $produto['id']]); ?>">
			<label>Nome:</label>
			<input type="text" name="nome" length="100" required="required" value="<?php echo $produto['nome']; ?>"><br>
			<label>Quantidade:</label>
			<?php echo $produto['quantidade']; ?><hr>
			<input type="submit" value="Atualizar">
			<input type="button" value="Cancelar" onclick="javascript:window.location='<?php echo $this->helper->url('HomeController@index'); ?>'">
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