<html>
	<head>
		<title>Usuários :: Listar</title>
	</head>
	<body>
		<h1>Listar Usuários</h1>
		<?php 
			// Exibe mensagem flash se houver
			echo $this->mensagem->alerta(); 
		?>
		<hr>
		<form method="get" action="<?php echo $this->helper->url('UsuarioController@listar'); ?>">
			<?php echo $this->helper->hiddenTags('UsuarioController@listar'); ?>
			<select name="busca">
				<option value="nome">Procurar por Nome</option>
				<option value="email">Procurar por E-mail</option>
			</select>
			<input type="text" name="palavra_buscada">
			<label>Perfil</label>
			<select name="perfil">
				<option value="">Todos</option>
				<option value="admin">Admin</option>
				<option value="user">Funcionário</option>
			</select>
			<label>Ordenar por</label>
			<select name="ordenar">
				<option value="id">Id</option>
				<option value="nome">Nome</option>
				<option value="email">E-mail</option>
			</select>			
			<input type="submit" value="Buscar">
			<input type="reset" value="Limpar">
		</form>
		<hr>
		<p><a href="<?php echo $this->helper->url('UsuarioController@inserir'); ?>">Inserir Usuário</a>&nbsp;<a href="<?php echo $this->helper->url('HomeController@index'); ?>">Voltar</a></p>
		<table border="1">
			<tr>
				<td>Id</td>
				<td>Usuário</td>
				<td>E-mail</td>
				<td>Perfil</td>
				<td>Ações</td>
			<tr>
			<?php foreach ($usuarios as $usuario) { ?>
				<tr>
					<td><?php echo $usuario['id']; ?></td>
					<td><?php echo $usuario['nome']; ?></td>
					<td><?php echo $usuario['email']; ?></td>
					<td>
						<?php 
							if ($usuario['perfil'] === 'admin') {
								echo 'Administrador';
							} else {
								echo 'Funcionário';
							}
						?>
					</td>
					<td><a href="<?php echo $this->helper->url('UsuarioController@alterar', ['id' => $usuario['id']]); ?>">Alterar</a></td>
				</tr>
			<?php } ?>
		</table>
	</body>
</html>