<?php

namespace Foo\App;

/**
 * Classe responsável pela conexão com o banco de dados
 *
 */
class Conexao
{	
	/**
	 * @var mixed Objeto de Conexão gerado para o MySQL
	 */
	protected $con;

	/**
	 * Retorna o objeto de conexão do banco de dados
	 *
	 * @return mixed
	 */
	public function getCon()
	{
		if (!$this->con) {
			$this->con = mysqli_connect('mysql.php4devs', 'root', 'docker', 'estoque');

			if (mysqli_connect_errno()) {
				die('Falha ao conectar-se com o MySQL: ' . mysqli_connect_error());
			}
		}

		return $this->con;
	}
}