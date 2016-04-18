<html>
	<head>
		<title>Usuários :: inserir</title>
	</head>
	<body>
		<h1>Novo Usuário</h1>
		<?php 
		    // Exibe mensagem flash se houver
			echo $this->mensagem->alerta(); 
		?>
		<hr>
		<form method="post" action="usuarios_inserir.php">
			<label>Nome:</label>
			<input type="text" name="nome" length="100" required="required" value="<?php echo $nome; ?>"><br>
			<label>E-mail:</label>
			<input type="text" name="email" length="255" required="required" value="<?php echo $email; ?>"><br>
			<label>Informe a senha:</label>
			<input type="password" name="senha" length="255" required="required"><br>
			<label>Confirme a senha:</label>
			<input type="password" name="senha_confirmacao" length="255" required="required"><br>
			<label>Perfil:</label>
			<select name="perfil">
				<option value="admin" <?php if ($perfil === 'admin') { echo 'selected="selected"'; } ?>>Administrador</option>
				<option value="user" <?php if ($perfil === 'user') { echo 'selected="selected"'; } ?>>Funcionário</option>
			</select><hr>
			<input type="submit" value="Inserir">
			<input type="button" value="Cancelar" onclick="javascript:window.location='usuarios_listar.php'">
		</form>
	</body>
</html>