<?php
// Disponibiliza a classe
include 'classes/Acesso.php';

// Instancia a classe
$acesso = new Acesso();

// Verifica se o usuário está logado
$acesso->verificaLogin();

// Disponibiliza a classe
include 'classes/Mensagem.php';

// Instancia a classe
$m = new Mensagem();
?>
<html>
	<head>
		<title>Controle de Estoque</title>
	</head>
	<body>
		<h1>Controle de Estoque</h1>
		<?php
			// Exibe a mensagem flash, caso houver
			echo $m->alerta();
		?>
		<hr>
		<li>
			<?php if ($acesso->isAdmin()) { ?>
			<ul><a href="usuarios/usuarios_inserir.php">Cadastrar Usuário</a></ul>
			<ul><a href="usuarios/usuarios_listar.php">Listar Usuários</a></ul>
			<?php } ?>
			<ul><a href="usuarios/alterar_senha.php?id=<?php echo $acesso->getUsuarioId(); ?>">Alterar senha</a></ul>
			<ul><a href="produtos/produtos_inserir.php">Cadastrar Produto</a></ul>
			<ul><a href="produtos/produtos_listar.php">Listar Produtos</a></ul>
			<ul><a href="estoques/estoques.php">Controle de Estoque</a></ul>
			<ul><a href="usuarios/logout.php">Sair</a></ul>
		</li>
	</body>
</html>