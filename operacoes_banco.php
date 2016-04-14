<?php
/*
 *
 * Operações com a tabela de produtos
 * 
 */

/**
 * Exibe todos os produtos ou com a condição de nome
 *
 * @param mixed $con
 * @param string nome
 * @return array
 */
function selecionaTodosProdutos($con, $nome = '')
{
	$sql  = "SELECT * FROM produtos";
	if ($nome) {
		$sql .= " WHERE nome like '%$nome%'";
	}
	$qry = mysqli_query($con, $sql);
	$produtos = [];
	while ($row = mysqli_fetch_array($qry)) {
		$produtos[] = $row;
	}

	return $produtos;
}

/**
 * Seleciona o produto pelo id
 *
 * @param mixed $con
 * @param integer $id
 * @return array
 */
function selecionaProdutoPorId($con, $id)
{
	$sql = "SELECT * FROM produtos WHERE id = $id";
	$qry = mysqli_query($con, $sql);
	$produto = mysqli_fetch_array($qry);
	return $produto;
}

/**
 * Insere o produto
 *
 * @param mixed $con
 * @param string $nome
 * @return boolean
 */
function insereProduto($con, $nome)
{
	return mysqli_query($con, "INSERT INTO produtos (nome) VALUES ('$nome')");
}

/**
 * Atualiza o nome do produto pelo id
 *
 * @param mixed $con
 * @param integer $id
 * @param string $nome
 * @return boolean
 */
function atualizaNomeDoProduto($con, $id, $nome)
{
	return mysqli_query($con, "UPDATE produtos SET nome = '$nome' WHERE id = $id");
}

/**
 * Atualiza o estoque do produto
 *
 * @param mixed $con
 * @param integer $id
 * @param integer $qtde
 * @return boolean
 */
function atualizaEstoqueProduto($con, $id, $qtde) 
{
	return mysqli_query($con, "UPDATE produtos SET quantidade = quantidade + $qtde WHERE id = $id");
}

/*
 *
 * Operações com a tabela de usuarios
 * 
 */

function selecionaUsuarios($con, $campo = '', $palavra = '', $perfil = '', $ordenar = '')
{
	$sql = "SELECT * FROM usuarios";
	$operador = 'WHERE';
	if ($palavra) {
		$sql .= " {$operador} {$campo} LIKE '%{$palavra}%'";
		$operador = 'AND';
	}
	if ($perfil) {
		$sql .= " $operador perfil = '{$perfil}'";
	}
	if ($ordenar) {
		$sql .= " ORDER BY {$ordenar}";
	}
	$qry = mysqli_query($con, $sql);
	$usuarios = [];

	while ($row = mysqli_fetch_array($qry)) {
		$usuarios[] = $row;
	}
	
	return $usuarios;
}

function selecionaUsuarioPorId($con, $id)
{
	$qry = mysqli_query($con, 'SELECT * FROM usuarios WHERE id = ' . $id);
	return mysqli_fetch_array($qry);
}

function selecionaUsuarioPorEmail($con, $email)
{
	$qry = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
	return mysqli_fetch_array($qry);
}

function insereUsuario($con, $nome, $email, $perfil, $senha)
{
	return mysqli_query($con, "INSERT INTO usuarios (nome, email, senha, perfil) VALUES ('{$nome}', '{$email}', '{$senha}', '{$perfil}')");
}

function atualizaUsuario($con, $id, $nome, $email, $perfil, $senha = '')
{
	$sql  = "UPDATE usuarios SET nome='$nome', email='$email', perfil='$perfil'";
	if ($senha) {
		$sql .= ", senha='$senha'";
	}
	$sql .= " WHERE id=$id";
	return mysqli_query($con, $sql);
}

function atualizaSenha($con, $id, $senha)
{
	return mysqli_query($con, "UPDATE usuarios SET senha='$senha' WHERE id=$id");
}

/*
 *
 * Operações com a tabela de estoques
 * 
 */

function selecionaMovimentoEstoqueDoProduto($con, $id)
{
	$estoques = [];
	$qry2 = mysqli_query($con, "SELECT e.*, u.nome as nome_usuario FROM estoques e INNER JOIN usuarios u ON u.id = e.usuario_id WHERE e.produto_id = $id ORDER BY e.criado_em DESC");
	while ($row = mysqli_fetch_array($qry2)) {
		$estoques[] = $row;
	}
	return $estoques;
}

/**
 * Cadastra a movimentação do estoque
 *
 * @param mixed $con
 * @param integer $usuarioId
 * @param integer $produtoId
 * @param integer $qtde
 * @return boolean
 */
function insereEstoque($con, $usuarioId, $produtoId, $qtde)
{
	return mysqli_query($con, "INSERT INTO estoques (usuario_id, produto_id, quantidade) VALUES ($usuarioId, $produtoId, $qtde)");
}