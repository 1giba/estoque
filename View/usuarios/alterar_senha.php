<html>
	<head>
		<title>Usuários :: Alterar Senha</title>
	</head>
	<body>
		<h1>Alterar Senha</h1>
		<h3>Usuário #<?php echo $usuario['nome'] . ' - ' . $usuario['email'] . ' [' . $usuario['perfil'] . ']'; ?></h3>
		<?php if ($alerta) { ?>
			<h3 style="color:red"><?php echo $alerta; ?></h3>
		<?php } ?>
		<hr>
		<form method="post" action="alterar_senha.php?id=<?php echo $usuario['id']; ?>">
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255" required="required"><br>
			<label>Confirme a senha:</label>
			<input type="password" name="senha_confirmacao" length="255" required="required"><hr>
			<input type="submit" value="Alterar Senha">
			<input type="button" value="Cancelar" onclick="javascript:window.location='<?php echo $this->helper->url('HomeController@index'); ?>'">
		</form>
	</body>
</html>