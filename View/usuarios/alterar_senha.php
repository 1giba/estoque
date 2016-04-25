<html>
	<head>
		<title>Usuários :: Alterar Senha</title>
	</head>
	<body>
		<h1>Alterar Senha</h1>
		<h3>Usuário #<?php echo $usuario['nome'] . ' - ' . $usuario['email'] . ' [' . $usuario['perfil'] . ']'; ?></h3>
		<?php
			// Exibe a mensagem flash, caso houver
			echo $this->mensagem->alerta();
		?>
		<hr>
		<form method="post" action="<?php echo $this->helper->url('UsuarioController@alterarSenha', ['id' => $usuario['id']]); ?>">
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255" required="required"><br>
			<label>Confirme a senha:</label>
			<input type="password" name="senha_confirmacao" length="255" required="required"><hr>
			<input type="submit" value="Alterar Senha">
			<input type="button" value="Cancelar" onclick="javascript:window.location='<?php echo $this->helper->url('HomeController@index'); ?>'">
		</form>
	</body>
</html>