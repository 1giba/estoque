<?php 

require_once DIRETORIO_CONTROLLERS . '/BaseController.php';

/**
 * Controller do Usuário
 *
 */
class UsuarioController extends BaseController
{
	/**
	 * { @inheritdoc }
	 */
	protected $models = ['Usuario'];

	/**
	 * Exibe a listagem de usuários
	 *
	 * @return void
	 */
	public function listar()
	{
		if (!$this->acesso->isAdmin()) {
			echo '<h1>Acesso não permitido</h1>';
			echo '<p><a href="../index.php">Voltar</a></p>';
			exit;
		}

		$campo 	 = '';
		$palavra = '';
		$perfil  = '';
		$ordem   = '';
		if (!empty($_GET['busca'])) {
			$campo   = $_GET['busca'];
		}
		if (!empty($_GET['palavra_buscada'])) {
			$palavra = $_GET['palavra_buscada'];
		}
		if (!empty($_GET['perfil'])) {
			$perfil = $_GET['perfil'];
		}
		if (!empty($_GET['ordenar'])) {
			$ordem = $_GET['ordenar'];
		} 
		$usuarios = $this->Usuario->selecionaUsuarios($campo, $palavra, $perfil, $ordem);

		include DIRETORIO_VIEWS . '/usuarios/listar.php';
	}

	/**
	 * Exibe o cadastro de usuário e realiza a sua inserção
	 *
	 * @return void
	 */
	public function inserir()
	{	
		// Permite apenas o perfil admin
		if (!$this->acesso->isAdmin()) {
			echo '<h1>Acesso não permitido</h1>';
			echo '<p><a href="../index.php">Voltar</a></p>';
			exit;
		}

		// Inicializar variáveis
		$nome   = '';
		$email  = '';
		$perfil = '';

		// Caso vierem variáveis de post
		if ($_POST) {

			// Variáveis recebem dados do post
			$nome   = $_POST['nome'];
			$email  = $_POST['email'];
			$perfil = $_POST['perfil'];

			// Verifica se o cliente já está utilizando o e-mail
			$emailJaCadastrado = !empty($this->Usuario->selecionaUsuarioPorEmail($email));

			// Caso tenha 1 registro já com esse e-mail, criar alerta
			if ($emailJaCadastrado) {
				// Armazena a mensagem flash
				$this->mensagem->flash('E-mail já utilizado, adicione outro.', 'erro');
			// Caso não tenha usuário com esse e-mail...
			} else {
				// Caso as senhas forem diferentes, criar alerta
				if ($_POST['senha'] != $_POST['senha_confirmacao']) {
					// Armazena a mensagem flash
					$this->mensagem->flash('Senhas não conferem!', 'erro');
				// Caso a inclusão for sucesso, redirecionar para a lista com mensagem de sucesso
				} elseif ($this->Usuario->insereUsuario($nome, $email, $perfil, $_POST['senha'])) {

					// Armazena a mensagem flash
					$this->mensagem->flash('Usuário inserido com sucesso!', 'sucesso');

					// Redireciona para a listagem de usuários
					header("Location: usuarios_listar.php");
					exit;
				}
			}
		}

		include DIRETORIO_VIEWS . '/usuarios/inserir.php';
	}

	/**
	 * Exibe a tela de alteração de usuários e realiza a sua atualização
	 *
	 * @return void
	 */
	public function alterar()
	{
		if (!$this->acesso->isAdmin()) {
			echo '<h1>Acesso não permitido</h1>';
			echo '<p><a href="' . header('Location: ' . $this->helper->url('HomeController@index')) . '">Voltar</a></p>';
			exit;
		}

		if (empty($_GET['id'])) {
			throw new Exception('Não possui id de alteração');
		}

		$alerta = '';

		$usuario = $this->Usuario->selecionaUsuarioPorId($_GET['id']);

		if ($_POST) {
			$num = 0;
			if ($usuario['email'] !== $_POST['email']) {
				$usuario['email'] = $_POST['email'];
				$num = !empty($this->Usuario->selecionaUsuarioPorEmail($usuario['email']));
			}

			$usuario['nome'] = $_POST['nome'];
			$usuario['perfil'] = $_POST['perfil'];	

			if ($num) {
				$alerta = 'E-mail já utilizado, adicione outro.';
			} else {
				if ($_POST['senha'] != $_POST['senha_confirmacao']) {
					$alerta = 'Senhas não conferem!';
				} elseif ($this->Usuario->atualizaUsuario($usuario['id'], $usuario['nome'], $usuario['email'], $usuario['perfil'], $_POST['senha'])) {
					$alerta = 'Usuário alterado com sucesso';
					header('Location: ' . $this->helper->url('UsuarioController@listar', ['message' => $alerta]));
				}
			}
		}

		if (empty($usuario)) {
			echo '<h1>Usuário não encontrado!</h1>';
			exit;
		}

		include DIRETORIO_VIEWS . '/usuarios/alterar.php';
	}

	/**
	 * Exibe a tela de alteração de senha e realiza a sua atualização
	 *
	 * @return void
	 */
	public function alterarSenha()
	{
		if (empty($_GET['id'])) {
			throw new Exception('Não possui id de alteração');
		}

		$alerta  = '';
		$usuario = $this->Usuario->selecionaUsuarioPorId($_GET['id']);

		if (empty($usuario)) {
			echo '<h1>Usuário não encontrado!</h1>';
			exit;
		}

		if ($_POST) {
			if ($_POST['senha'] !== $_POST['senha_confirmacao']) {
				$alerta = 'Senhas não conferem!';
			} elseif ($this->Usuario->atualizaSenha($usuario['id'], $_POST['senha'])) {
				$alerta = 'Usuário alterado com sucesso';
				header('Location: ' . $this->helper->url('UsuarioController@listar', ['message' => $alerta]));
			}
		}

		include DIRETORIO_VIEWS . '/usuarios/alterar_senha.php';
	}

	/**
	 * Exibe a tela de login e valida os dados de login
	 *
	 * @return void
	 */
	public function login()
	{ 
		$alerta = '';

		if ($_POST) {
			$usuario = $this->Usuario->selecionaUsuarioPorEmail($_POST['email']);
			if (empty($usuario) || $_POST['senha'] !== $usuario['senha']) {
				$alerta = 'Usuário/Senha inválidos!';
			} else {
				$this->acesso->setUsuario($usuario);
				header('Location: ' . $this->helper->url('HomeController@index'));
				exit;
			}
		}

		include DIRETORIO_VIEWS . '/usuarios/login.php';
	}

	/**
	 * Desloga o usuário do sistema
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->acesso->limparSessao();

		header('Location: ' . $this->helper->url('UsuarioController@login'));
	}
}