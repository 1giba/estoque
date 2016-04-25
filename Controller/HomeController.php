<?php

namespace Foo\Controller;
/**
 * Controller para o menu inicial
 *
 *
 */
class HomeController extends BaseController
{
	/**
	 * Exibe o menu inicial
	 *
	 * @return void
	 */
	public function index()
	{
		// Adiciona a view
		echo $this->view->render('home/index.html', [
			'flash'    			=> $this->mensagem->alerta(),
			'isAdmin'  			=> $this->acesso->isAdmin(),
			'urlUsuarioInserir' => $this->helper->url('UsuarioController@inserir'),
			'urlUsuarioListar'  => $this->helper->url('UsuarioController@listar'),
			'urlAlterarSenha'   => $this->helper->url('UsuarioController@alterarSenha', [
				'id' => $this->acesso->getUsuarioId(),
			]),
			'urlProdutoInserir' => $this->helper->url('ProdutoController@inserir'),
			'urlProdutoListar'  => $this->helper->url('ProdutoController@listar'),
			'urlEstoque' 		=> $this->helper->url('EstoqueController@index'),
			'urlLogout' 		=> $this->helper->url('UsuarioController@logout'),
		]);
	}
}