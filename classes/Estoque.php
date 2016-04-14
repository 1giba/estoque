<?php

// Devemos usar require_once pois se num mesmo arquivo chamar Estoque e Produto, por exemplo. Vai dar erro de redeclared, ou seja, vai incluir 2 vezes Base.php.
require_once 'Base.php';

/**
 * Classe responsável pela movimentação do estoque
 *
 */
class Estoque extends Base
{
	/**
	 * Busca a movimentação do estoque pelo id do produto
	 *
	 * @param integer $id
	 * @return array
	 */
	function selecionaMovimentoEstoqueDoProduto($id)
	{
		$estoques = [];
		$qry2 = mysqli_query($this->con, "SELECT e.*, u.nome as nome_usuario FROM estoques e INNER JOIN usuarios u ON u.id = e.usuario_id WHERE e.produto_id = $id ORDER BY e.criado_em DESC");
		while ($row = mysqli_fetch_array($qry2)) {
			$estoques[] = $row;
		}
		return $estoques;
	}

	/**
	 * Cadastra a movimentação do estoque
	 *
	 * @param integer $usuarioId
	 * @param integer $produtoId
	 * @param integer $qtde
	 * @return boolean
	 */
	function insereEstoque($usuarioId, $produtoId, $qtde)
	{
		return mysqli_query($this->con, "INSERT INTO estoques (usuario_id, produto_id, quantidade) VALUES ($usuarioId, $produtoId, $qtde)");
	}
}