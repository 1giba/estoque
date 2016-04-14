<?php
/**
 * Classe responsável pelo controle de acesso
 *
 */
class Acesso
{
	/**
	 * Método construtor
	 *
	 * @return void
	 */
	public function __construct()
	{
		session_start();
	}

	/**
	 * Verifica se o usuário está logado
	 *
	 * @return boolean
	 */
	public function verificaLogin()
	{		
		if (empty($_SESSION['usuario'])) {
			require_once 'Mensagem.php';

			$mensagem = new Mensagem();
			$mensagem->flash('Você deve estar logado no sistema', 'erro');

			header("Location: ../usuarios/login.php");
			exit;
		}
		return true;
	}

	/**
	 * Verifica se o usuário é administrador
	 *
	 * @return boolean
	 */
	public function isAdmin()
	{
		return $_SESSION['usuario']['perfil'] === 'admin';
	}

	/**
	 * Armazena o usuário logado
	 *
	 * @return void
	 */
	public function setUsuario($usuario)
	{
		$_SESSION['usuario'] = $usuario;
	}

	/**
	 * Recupera o id do usuário logado
	 *
	 * @return void
	 */
	public function getUsuarioId()
	{
		return $_SESSION['usuario']['id'];
	}

	/**
	 * Limpa a sessão
	 *
	 * @return void
	 */
	public function limparSessao()
	{
		session_destroy();
	}
}