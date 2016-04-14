<?php
// Verifica se o usuário está logado
include '../verifica_acesso.php';

// Permite apenas o perfil admin
include '../somente_admin.php';

// Captura a conexão aberta
$con = include '../abre_conexao.php';

// Disponibiliza as funções de operações com banco
include '../operacoes_banco.php';

// Prepara os parametros da função
$busca 		    = !empty($_GET['busca']) ? $_GET['busca'] : '';
$palavraBuscada = !empty($_GET['palavra_buscada']) ? $_GET['palavra_buscada'] : '';
$perfil         = !empty($_GET['perfil']) ? $_GET['perfil'] : '';
$ordenar        = !empty($_GET['ordenar']) ? $_GET['ordenar'] : '';

// Captura os usuários
$usuarios = selecionaUsuarios($con, $busca, $palavraBuscada, $perfil, $ordenar);
?>
<html>
	<head>
		<title>Usuários :: Listar</title>
	</head>
	<body>
		<h1>Listar Usuários</h1>
		<?php 
			// Disponibiliza as funções relacionadas às mensagens flash
			include '../mensagem_flash.php';

			// Exibe mensagem flash se houver
			echo alerta(); 
		?>
		<hr>
		<form method="get" action="usuarios_listar.php">
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
		<p><a href="usuarios_inserir.php">Inserir Usuário</a>&nbsp;<a href="../index.php">Voltar</a></p>
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
					<td><a href="usuarios_alterar.php?id=<?php echo $usuario['id']; ?>">Alterar</a></td>
				</tr>
			<?php } ?>
		</table>
	</body>
</html>