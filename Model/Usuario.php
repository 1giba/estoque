<?php

// Devemos usar require_once pois se num mesmo arquivo chamar Estoque e Produto, por exemplo. Vai dar erro de redeclared, ou seja, vai incluir 2 vezes Base.php.
require_once DIRETORIO_MODELS . '/Base.php';

/**
 * Classe responsável pelo Usuário
 *
 */
class Usuario extends Base
{
	/**
	 * Exibe os usuários de acordo com os parâmetros
	 *
	 * @param string $campo
	 * @param string $palavra
	 * @param string $perfil
	 * @param string $ordenar
	 * @return array
	 */
	public function selecionaUsuarios($campo = '', $palavra = '', $perfil = '', $ordenar = '')
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
		$qry = mysqli_query($this->con, $sql);
		$usuarios = [];

		while ($row = mysqli_fetch_array($qry)) {
			$usuarios[] = $row;
		}
		
		return $usuarios;
	}

	/**
	 * Busca o usuário pelo id
	 *
	 * @param integer $id
	 * @return array
	 */
	 public function selecionaUsuarioPorId($id)
	{
		$qry = mysqli_query($this->con, 'SELECT * FROM usuarios WHERE id = ' . $id);
		return $qry ? mysqli_fetch_array($qry) : array();
	}

	/**
	 * Busca o usuário pelo e-mail
	 *
	 * @param integer $id
	 * @return array
	 */
	public function selecionaUsuarioPorEmail($email)
	{
		$qry = mysqli_query($this->con, "SELECT * FROM usuarios WHERE email = '$email'");
		return $qry ? mysqli_fetch_array($qry) : array();
	}

	/**
	 * Insere o usuário
	 *
	 * @param string $nome
	 * @param string $email
	 * @param string $perfil
	 * @param string $senha
	 * @return boolean
	 */
	public function insereUsuario($nome, $email, $perfil, $senha)
	{
		return mysqli_query($this->con, "INSERT INTO usuarios (nome, email, senha, perfil) VALUES ('{$nome}', '{$email}', '{$senha}', '{$perfil}')");
	}

	/**
	 * Atualiza os dados do usuário
	 *
	 * @param integer $id
	 * @param string $nome
	 * @param string $email
	 * @param string $perfil
	 * @param string $senha
	 * @return boolean
	 */
	public function atualizaUsuario($id, $nome, $email, $perfil, $senha = '')
	{
		$sql  = "UPDATE usuarios SET nome='$nome', email='$email', perfil='$perfil'";
		if ($senha) {
			$sql .= ", senha='$senha'";
		}
		$sql .= " WHERE id=$id";
		return mysqli_query($this->con, $sql);
	}

	/**
	 * Atualiza a senha do usuário
	 *
	 * @param integer $id
	 * @param string $senha
	 * @return boolean
	 */
	public function atualizaSenha($id, $senha)
	{
		return mysqli_query($this->con, "UPDATE usuarios SET senha='$senha' WHERE id=$id");
	}
}