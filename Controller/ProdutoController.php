<?php 

require_once DIRETORIO_CONTROLLERS . '/BaseController.php';

/**
 * Controller de Produto
 *
 */
class ProdutoController extends BaseController
{
	/**
	 * { @inheritdoc }
	 */
	protected $models = ['Produto', 'Estoque'];

	/**
	 * Exibe a listagem de produtos
	 *
	 * @return void
	 */
	public function listar()
	{		
		// Captura os produtos
		$produtos = $this->produto->selecionaTodosProdutos(!empty($_GET['nome']) ? $_GET['nome'] : '');

		// Adiciona a view
		include DIRETORIO_VIEWS . '/produtos/listar.php';
	}

	/**
	 * Exibe a tela do cadastro de produto e realiza sua inserção
	 *
	 * @return void
	 */
	public function inserir()
	{
		if ($_POST) {
			// Caso o produto seja incluido com sucesso, criar alerta e redirecionar para a lista
			if ($this->produto->insereProduto($_POST['nome'])) {

				// Armazena a mensagem flash
				$this->mensagem->flash('Produto inserido com sucesso', 'sucesso');

				// Redireciona para a listagem de produtos
				header("Location: " . $this->helper->url('ProdutoController@listar'));
				exit;
			}
		}

		// Adiciona a view
		include DIRETORIO_VIEWS . '/produtos/inserir.php';
	}

	/**
	 * Exibe a tela de alteração de produto e realiza a sua atualização
	 *
	 * @return void
	 */
	public function alterar()
	{
		if (empty($_GET['id'])) {
			throw new Exception('Não possui id de alteração');
		}

		// Captura o produto pelo ID
		$produto = $this->produto->selecionaProdutoPorId($_GET['id']);
		// Caso não encontre o produto, exibir mensagem
		if (empty($produto)) {
			echo '<h1>Produto não encontrado!</h1>';
			exit;
		}
		// Se vierem dados do post...
		if ($_POST) {
			// Atualizar o nome do produto
			if ($this->produto->atualizaNomeDoProduto($produto['id'], $_POST['nome'])) {

				// Armazena a mensagem flash
				$this->mensagem->flash('Produto alterado com sucesso', 'sucesso');
				
				// Redirecionar para a lista e exibir mensagem
				header("Location: " . $this->helper->url('ProdutoController@listar'));
				exit;
			}
		}
		// Captura a movimentação do estoque do produto
		$estoques = $this->estoque->selecionaMovimentoEstoqueDoProduto($produto['id']);

		// Adiciona a view
		include DIRETORIO_VIEWS . '/produtos/alterar.php';
	}
}