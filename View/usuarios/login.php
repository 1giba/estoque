<html>
	<head>
		<title>Controle de Estoque</title>
	</head>
	<body>
		<h1>Acesso ao Sistema</h1>
		<?php if ($alerta) { ?>
			<h3 style="color:red"><?php echo $alerta; ?></h3>
		<?php } ?>
		<hr>
		<form method="post" action="<?php echo $this->helper->url('UsuarioController@login'); ?>">
			<label>Informe o e-mail:</label>
			<input type="email" name="email" length="255" required="required"><br>
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255" required="required"><hr>
			<input type="submit" value="Login">
		</form>
	</body>
</html>