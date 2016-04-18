<?php

// Devemos usar require_once pois se num mesmo arquivo chamar Estoque e Produto, por exemplo. Vai dar erro de redeclared, ou seja, vai incluir 2 vezes Base.php.
require_once DIRETORIO_MODELS . '/Base.php';

/**
 * Classe responsável pelo Produto
 *
 */
class Produto extends Base
{
	/**
	 * Exibe todos os produtos ou com a condição de nome
	 *
	 * @param string nome
	 * @return array
	 */
	public function selecionaTodosProdutos($nome = '')
	{
		$sql  = "SELECT * FROM produtos";
		if ($nome) {
			$sql .= " WHERE nome like '%$nome%'";
		}
		$qry = mysqli_query($this->con, $sql);
		$produtos = [];
		while ($row = mysqli_fetch_array($qry)) {
			$produtos[] = $row;
		}

		return $produtos;
	}

	/**
	 * Seleciona o produto pelo id
	 *
	 * @param integer $id
	 * @return array
	 */
	public function selecionaProdutoPorId($id)
	{
		$sql = "SELECT * FROM produtos WHERE id = $id";
		$qry = mysqli_query($this->con, $sql);
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
	public function insereProduto($nome)
	{
		return mysqli_query($this->con, "INSERT INTO produtos (nome) VALUES ('$nome')");
	}

	/**
	 * Atualiza o nome do produto pelo id
	 *
	 * @param integer $id
	 * @param string $nome
	 * @return boolean
	 */
	public function atualizaNomeDoProduto($id, $nome)
	{
		return mysqli_query($this->con, "UPDATE produtos SET nome = '$nome' WHERE id = $id");
	}

	/**
	 * Atualiza o estoque do produto
	 *
	 * @param integer $id
	 * @param integer $qtde
	 * @return boolean
	 */
	public function atualizaEstoqueProduto($id, $qtde) 
	{
		return mysqli_query($this->con, "UPDATE produtos SET quantidade = quantidade + $qtde WHERE id = $id");
	}
}