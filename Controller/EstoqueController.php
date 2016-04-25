<?php 

namespace Foo\Controller;
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
		// Captura todos os produtos
		$produtos = $this->produto->selecionaTodosProdutos();

		// Inicializar a variável
		$alerta = '';
		// Se vierem variáveis post...
		if ($_POST) {
			// Iterar no resultado na consulta dos produtos	
			foreach ($produtos as $key => $produto) {
				// Caso não vier no post, pular para a próxima iteração
				if (empty($_POST['produto-' . $produto['id']])) {
					continue;
				}
				// Se inserir com sucesso
				if ($this->estoque->insereEstoque($_SESSION['usuario']['id'], $produto['id'], $_POST['produto-' . $produto['id']])) {
					// Exibir adição de produto em verde
					if ($_POST['produto-' . $produto['id']] > 0) {
						$alerta .= "<span style='color:green'>Produto {$produto['nome']}: +" . $_POST["produto-{$produto['id']}"] . "</span><br>";
					// Exibir remoção de produto em vermelho
					} else {
						$alerta .= "<span style='color:red'>Produto {$produto['nome']}: " . $_POST["produto-{$produto['id']}"] . "</span><br>";
					}
					// Caso for atualizado com sucesso
					if ($this->produto->atualizaEstoqueProduto($produto['id'], $_POST['produto-' . $produto['id']])) {
						// Criar mensagem de alerta
						$alerta .= "<span style='color:blue'>Produto {$produto['nome']} alterado o estoque de {$produto['quantidade']} para " . ($produto['quantidade'] + $_POST['produto-' . $produto['id']]) . "</span><br>";
						// Atualizar resultado de produtos que irá iterar no html
						$produtos[$key]['quantidade'] += $_POST['produto-' . $produto['id']];
					}
				}
			}
		}

		// Adiciona a view
		echo $this->view->render('estoques/index.html', [
			'alerta'    => $alerta,
			'action'    => $this->helper->url('EstoqueController@index'),
			'produtos'  => $produtos,
			'urlVoltar' => $this->helper->url('HomeController@index')
		]);
	}
}