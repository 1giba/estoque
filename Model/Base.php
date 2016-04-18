<?php
/**
 * Classe que generaliza Estoque, Produto e Usuário
 *
 */
class Base
{
	/**
	 * @var mixed Objeto de Conexão gerado para o MySQL
	 */
	protected $con;

	/**
	 * Método construtor
	 *
	 * @param mixed $con
	 */
	public function __construct($con)
	{
		$this->con = $con;
	}
}