<html>
	<head>
		<title>Usuários :: Alterar</title>
	</head>
	<body>
		<h1>Alterar Usuário</h1>
		<h3>Usuário #<?php echo $usuario['id']; ?></h3>
		<?php 
			// Exibe mensagem flash se houver
			echo $this->mensagem->alerta(); 
		?>
		<hr>
		<form method="post" action="<?php echo $this->helper->url('UsuarioController@alterar', ['id' => $usuario['id']]); ?>">
			<input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
			<label>Nome:</label>
			<input type="text" name="nome" length="100" required="required" value="<?php echo $usuario['nome']; ?>"><br>
			<label>E-mail:</label>
			<input type="text" name="email" length="255" required="required" value="<?php echo $usuario['email']; ?>"><br>
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255"><br>
			<label>Confirme a senha:</label>
			<input type="password" name="senha_confirmacao" length="255"><br>
			<label>Perfil:</label>
			<select name="perfil">
				<option value="admin" <?php if ($usuario['perfil'] === 'admin') { echo 'selected="selected"'; } ?>>Administrador</option>
				<option value="user" <?php if ($usuario['perfil'] === 'user') { echo 'selected="selected"'; } ?>>Funcionário</option>
			</select><hr>
			<input type="submit" value="Alterar">
			<input type="button" value="Cancelar" onclick="javascript:window.location='<?php echo $this->helper->url('UsuarioController@listar'); ?>'">
		</form>
	</body>
</html>