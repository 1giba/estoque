<?php
// Verifica se o usuário está logado
include '../verifica_acesso.php';
?>
<html>
	<head>
		<title>Controle de Estoque</title>
	</head>
	<body>
		<h1>Controle de Estoque</h1>
		<hr>
		<li>
			<?php if ($_SESSION['usuario']['perfil'] === 'admin') { ?>
			<ul><a href="usuarios/usuarios_inserir.php">Cadastrar Usuário</a></ul>
			<ul><a href="usuarios/usuarios_listar.php">Listar Usuários</a></ul>
			<?php } ?>
			<ul><a href="usuarios/alterar_senha.php?id=<?php echo $_SESSION['usuario']['id']; ?>">Alterar senha</a></ul>
			<ul><a href="produtos/produtos_inserir.php">Cadastrar Produto</a></ul>
			<ul><a href="produtos/produtos_listar.php">Listar Produtos</a></ul>
			<ul><a href="estoques/estoques.php">Controle de Estoque</a></ul>
			<ul><a href="usuarios/logout.php">Sair</a></ul>
		</li>
	</body>
</html>