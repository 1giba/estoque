<?php 

require_once DIRETORIO_CONTROLLERS . '/BaseController.php';
/**
 * Controller da Movimentação do Estoque
 *
 */
class EstoqueController extends BaseController
{
	/**
	 * @var { @inheritdoc }
	 */
	protected $models = ['Produto', 'Estoque'];

	/**
	 * Exibe o estoque atual dos produtos e grava a reposição/baixa
	 * 
	 * @return void
	 */
	public function index()
	{		
		$produtos = $this->Produto->selecionaTodosProdutos();	

		$alerta = '';
		if ($_POST) {
			foreach ($produtos as $key => $produto) {
				if (empty($_POST['produto-' . $produto['id']])) {
					continue;
				}
				if ($this->Estoque->insereEstoque($acesso->getUsuarioId(), $produto['id'], $_POST['produto-' . $produto['id']])) {
					if ($_POST['produto-' . $produto['id']] > 0) {
						$alerta .= "<span style='color:green'>Produto {$produto['nome']}: +" . $_POST["produto-{$produto['id']}"] . "</span><br>";
					} else {
						$alerta .= "<span style='color:red'>Produto {$produto['nome']}: " . $_POST["produto-{$produto['id']}"] . "</span><br>";
					}
					if ($this->Produto->atualizaEstoqueProduto($produto['id'], $_POST['produto-' . $produto['id']])) {
						$alerta .= "<span style='color:blue'>Produto {$produto['nome']} alterado o estoque de {$produto['quantidade']} para " . ($produto['quantidade'] + $_POST['produto-' . $produto['id']]) . "</span><br>";
						$produtos[$key]['quantidade'] += $_POST['produto-' . $produto['id']];
					}
				}		
			}
		}

		include DIRETORIO_VIEWS . '/estoques/index.php';
	}
}