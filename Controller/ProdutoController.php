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
		if (!empty($_GET['nome'])) {
		 	$produtos = $this->Produto->selecionaTodosProdutos($_GET['nome']);
		 } else {
			$produtos = $this->Produto->selecionaTodosProdutos();
		}

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
			if ($this->Produto->insereProduto($_POST['nome'])) {
				$alerta = 'Produto inserido com sucesso';
				header("Location: produtos_listar.php?message=$alerta");
			}
		}

		include DIRETORIO_VIEWS . '/produtos/inserir.php';
	}

	/**
	 * Exibe a tela de alteração de produto e realiza a sua atualização
	 *
	 * @return void
	 */
	public function alterar()
	{
		$produto = $this->Produto->selecionaProdutoPorId($_GET['id']);

		if (empty($produto)) {
			echo '<h1>Produto não encontrado!</h1>';
			exit;
		}

		if ($_POST) {
			if ($this->Produto->atualizaNomeDoProduto($produto['id'], $_POST['nome'])) {
				$alerta = 'Produto alterado com sucesso';
				header('Location: produtos_listar.php?message=' . $alerta);
			}
		}

		$estoques = $this->Estoque->selecionaMovimentoEstoqueDoProduto($produto['id']);

		include DIRETORIO_VIEWS . '/produtos/alterar.php';
	}
}