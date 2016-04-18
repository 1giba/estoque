<html>
	<head>
		<title>Produtos :: Inserir</title>
	</head>
	<body>
		<h1>Incluir Produto</h1>
		<hr>
		<form method="post" action="produtos_inserir.php">
			<label>Nome:</label>
			<input type="text" name="nome" length="100" required="required"><br>
			<label>Quantidade:</label>
			0<hr>
			<input type="submit" value="Inserir">
			<input type="button" value="Cancelar" onclick="javascript:window.location='<?php echo $this->helper->url('HomeController@index'); ?>'">
		</form>
	</body>
</html>