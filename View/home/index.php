<html>
	<head>
		<title>Controle de Estoque</title>
	</head>
	<body>
		<h1>Controle de Estoque</h1>
		<?php
			// Exibe a mensagem flash, caso houver
			echo $this->mensagem->alerta();
		?>
		<hr>
		<li>
			<?php if ($this->acesso->isAdmin()) { ?>
			<ul><a href="<?php echo $this->helper->url('UsuarioController@inserir'); ?>">Cadastrar Usuário</a></ul>
			<ul><a href="<?php echo $this->helper->url('UsuarioController@listar'); ?>">Listar Usuários</a></ul>
			<?php } ?>
			<ul><a href="<?php echo $this->helper->url('UsuarioController@alterarSenha', ['id' => $this->acesso->getUsuarioId()]); ?>">Alterar senha</a></ul>
			<ul><a href="<?php echo $this->helper->url('ProdutoController@inserir'); ?>">Cadastrar Produto</a></ul>
			<ul><a href="<?php echo $this->helper->url('ProdutoController@listar'); ?>">Listar Produtos</a></ul>
			<ul><a href="<?php echo $this->helper->url('EstoqueController@index'); ?>">Controle de Estoque</a></ul>
			<ul><a href="<?php echo $this->helper->url('UsuarioController@logout'); ?>">Sair</a></ul>
		</li>
	</body>
</html>