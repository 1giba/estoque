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
		<form method="post" action="<?php echo $this->helper->url('EstoqueController@index'); ?>">	
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
			<input type="button" value="Cancelar" onclick="javascript:window.location='<?php echo $this->helper->url('HomeController@index'); ?>'">
		</form>		
	</body>
</html>