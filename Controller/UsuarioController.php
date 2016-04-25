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
		// Permite apenas o perfil admin
		if (!$this->acesso->isAdmin()) {
			echo '<h1>Acesso não permitido</h1>';
			echo '<p><a href="../index.php">Voltar</a></p>';
			exit;
		}

		// Prepara os parametros da função
		$busca 		    = !empty($_GET['busca']) ? $_GET['busca'] : '';
		$palavraBuscada = !empty($_GET['palavra_buscada']) ? $_GET['palavra_buscada'] : '';
		$perfil         = !empty($_GET['perfil']) ? $_GET['perfil'] : '';
		$ordenar        = !empty($_GET['ordenar']) ? $_GET['ordenar'] : '';

		// Captura os usuários
		$usuarios = $this->usuario->selecionaUsuarios($busca, $palavraBuscada, $perfil, $ordenar);

		// Adiciona a view
		echo $this->view->render('usuarios/listar.html', [
			'flash'   			=> $this->mensagem->alerta(),
			'action'  			=> $this->helper->url('UsuarioController@listar'),
			'hiddenTags' 		=> $this->helper->hiddenTags('UsuarioController@listar'),
			'usuarios'			=> $usuarios,
			'urlBaseUsuario'    => $this->helper->url('UsuarioController@alterar'),
			'urlUsuarioInserir' => $this->helper->url('UsuarioController@inserir'),
			'urlVoltar' 		=> $this->helper->url('HomeController@index'),
		]);
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
			$emailJaCadastrado = !empty($this->usuario->selecionaUsuarioPorEmail($email));

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
				} elseif ($this->usuario->insereUsuario($nome, $email, $perfil, $_POST['senha'])) {

					// Armazena a mensagem flash
					$this->mensagem->flash('Usuário inserido com sucesso!', 'sucesso');

					// Redireciona para a listagem de usuários
					header('Location: ' . $this->helper->url('UsuarioController@listar'));
					exit;
				}
			}
		}

		// Adiciona a view
		echo $this->view->render('usuarios/inserir.html', [
			'flash'   	=> $this->mensagem->alerta(),
			'action'  	=> $this->helper->url('UsuarioController@inserir'),
			'nome' 	    => $nome,
			'email'	    => $email,
			'perfil'    => $perfil,
			'urlVoltar' => $this->helper->url('UsuarioController@listar'),
		]);
	}

	/**
	 * Exibe a tela de alteração de usuários e realiza a sua atualização
	 *
	 * @return void
	 */
	public function alterar()
	{
		// Permite apenas o perfil admin
		if (!$this->acesso->isAdmin()) {
			echo '<h1>Acesso não permitido</h1>';
			echo '<p><a href="' . header('Location: ' . $this->helper->url('HomeController@index')) . '">Voltar</a></p>';
			exit;
		}

		// Caso não passe na URL o id do usuário, gerar um erro
		if (empty($_GET['id'])) {
			die('Você deve informar o id do usuario');
		}
		
		// Captura o usuário por id
		$usuario = $this->usuario->selecionaUsuarioPorId($_GET['id']);
		// Caso não encontre o usuário, exibir mensagem
		if (empty($usuario)) {
			echo '<h1>Usuário não encontrado!</h1>';
			exit;
		}

		// Se vierem variáveis do post...
		if ($_POST) {
			// Inicializar variável
			$emailJaCadastrado = false;
			// Verificar se o e-mail do usuário cadastro é diferente do post
			if ($usuario['email'] !== $_POST['email']) {
				// atualiza o e-mail do usuário com o e-mail do post
				$usuario['email'] = $_POST['email'];
				// verifica se o e-mail já não está cadastrado
				$emailJaCadastrado = !empty($this->usuario->selecionaUsuarioPorEmail($usuario['email']));
			}
			// Atualizam os dados
			$usuario['nome'] = $_POST['nome'];
			$usuario['perfil'] = $_POST['perfil'];	
			// Caso o e-mail já esteja sendo utilizado, criar alerta
			if ($emailJaCadastrado) {
				// Armazena a mensagem flash
				$this->mensagem->flash('E-mail já utilizado, adicione outro.', 'erro');
			// Senão
			} else {
				// Valida as senhas
				if ($_POST['senha'] != $_POST['senha_confirmacao']) {
					// Armazena a mensagem flash
					$this->mensagem->flash('Senhas não conferem!', 'erro');
				// Caso a atualização for sucesso, redirecionar para a lista com mensagem de sucesso
				} elseif ($this->usuario->atualizaUsuario($usuario['id'], $usuario['nome'], $usuario['email'], $usuario['perfil'], !empty($_POST['senha']) ? $_POST['senha'] : '')) {
					// Armazena a mensagem flash
					$this->mensagem->flash('Usuário alterado com sucesso!', 'sucesso');
					// Redireciona para a listagem de usuários
					header('Location: ' . $this->helper->url('UsuarioController@listar'));
					exit;
				}
			}
		}

		// Adiciona a view
		echo $this->view->render('usuarios/alterar.html', [
			'flash'   	=> $this->mensagem->alerta(),
			'action'  	=> $this->helper->url('UsuarioController@alterar', ['id' => $usuario['id']]),
			'usuario' 	=> $usuario,
			'urlVoltar' => $this->helper->url('UsuarioController@listar'),
		]);
	}

	/**
	 * Exibe a tela de alteração de senha e realiza a sua atualização
	 *
	 * @return void
	 */
	public function alterarSenha()
	{
		
		// Caso não passe na URL o id do usuário, gerar um erro
		if (empty($_GET['id'])) {
			throw new Exception('Não possui id de alteração');
		}
		
		// Captura usuário pelo id
		$usuario = $this->usuario->selecionaUsuarioPorId($_GET['id']);

		// Caso não encontre o usuário, exibir mensagem
		if (empty($usuario)) {
			echo '<h1>Usuário não encontrado!</h1>';
			exit;
		}
		
		// Se vierem variáveis do post...
		if ($_POST) {
			// Valida as senhas
			if ($_POST['senha'] !== $_POST['senha_confirmacao']) {
				// Armazena a mensagem flash
				$this->mensagem->flash('Senhas não conferem!', 'erro');
			// Caso a atualização for sucesso, redireciona para a lista e exibe mensagem de sucesso
			} elseif ($this->usuario->atualizaSenha($usuario['id'], $_POST['senha'])) {
				// Armazena a mensagem flash
				$this->mensagem->flash('Senha alterada com sucesso', 'sucesso');
				// Redireciona para o menu principal
				header('Location: ' . $this->helper->url('HomeController@index'));
				exit;
			}
		}

		// Adiciona a view
		echo $this->view->render('usuarios/alterar_senha.html', [
			'flash'   	=> $this->mensagem->alerta(),
			'action'  	=> $this->helper->url('UsuarioController@alterarSenha', ['id' => $usuario['id']]),
			'usuario' 	=> $usuario,
			'urlVoltar' => $this->helper->url('HomeController@index'),
		]);
	}

	/**
	 * Exibe a tela de login e valida os dados de login
	 *
	 * @return void
	 */
	public function login()
	{ 
		// Se vierem os dados do post
		if ($_POST) {
			// Captura o usuário por e-mail
			$usuario = $this->usuario->selecionaUsuarioPorEmail($_POST['email']);
			// Valida as senhas, cria alerta
			if (empty($usuario) || $_POST['senha'] !== $usuario['senha']) {
				// Armazena a mensagem flash
				$this->mensagem->flash('Usuário/Senha inválidos!', 'erro');
			// Senha ok!
			} else {		
				$this->acesso->setUsuario($usuario);
				// Volta para o menu principal
				header('Location: ' . $this->helper->url('HomeController@index'));
				exit;
			}
		}

		// Adiciona a view
		echo $this->view->render('usuarios/login.html', [
			'flash'  => $this->mensagem->alerta(),
			'action' => $this->helper->url('UsuarioController@login'),
		]);
	}

	/**
	 * Desloga o usuário do sistema
	 *
	 * @return void
	 */
	public function logout()
	{
		// Desloga o usuário logado
		$this->acesso->limparSessao();

		// Redireciona para a tela de login
		header('Location: ' . $this->helper->url('UsuarioController@login'));
	}
}