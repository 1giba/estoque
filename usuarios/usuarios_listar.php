<?php
// Caso o usuário não esteja logado, redireciona para o login
session_start();
if (empty($_SESSION['usuario'])) {
	header("Location: ../usuarios/login.php");
	exit;
}

// Caso o usuário não tenha o perfil admin, retorna para o index
if ($_SESSION['usuario']['perfil'] !== 'admin') {
	echo '<h1>Acesso não permitido</h1>';
	echo '<p><a href="../index.php">Voltar</a></p>';
	exit;
}

// Fazer a conexão com o banco de dados
$con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

// Verificar se existe erro na conexão
if (mysqli_connect_errno()) {
	die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
}

// Consulta Principal
$sql = "SELECT * FROM usuarios WHERE 1=1";

// Caso tiver a palavra buscada, adicionar o filtro
if(!empty($_GET['palavra_buscada'])){
	if($_GET['busca'] == 'nome'){
		$sql .= " AND nome LIKE '%{$_GET['palavra_buscada']}%'";
	}else{
		if($_GET['busca'] == 'email'){
			$sql .= " AND email = '{$_GET['palavra_buscada']}'";
		}
	}
}

// Caso tiver o perfil do usuário, adicionar o filtro
if (!empty($_GET['perfil'])) {
	$sql .= " AND perfil = '{$_GET['perfil']}'";
}

// Caso tiver ordenação, adicionar na consulta
if (!empty($_GET['ordenar'])) {
	$sql .= " ORDER BY {$_GET['ordenar']}";
}

// Executar a consulta
$qry = mysqli_query($con, $sql);

// Inicializar a variável para os dados da consulta
$usuarios = [];

// Iterar no resultado da consulta
while ($row = mysqli_fetch_array($qry)) {
	// Adicionar os dados do usuário no array
	$usuarios[] = $row;
}
?>
<html>
	<head>
		<title>Usuários :: Listar</title>
	</head>
	<body>
		<h1>Listar Usuários</h1>
		<?php if (!empty($_SESSION['mensagem'])) { ?>
			<h3 style="color:green"><?php echo $_SESSION['mensagem']; ?></h3>
			<?php unset($_SESSION['mensagem']); ?>
		<?php } ?>
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