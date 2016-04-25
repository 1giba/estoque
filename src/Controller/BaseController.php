<?php

namespace Foo\Controller;

use Foo\App\Acesso;
use Foo\App\Mensagem;
use Foo\App\Helper;
use Foo\App\View;
use Foo\App\Conexao;

class BaseController
{
	/**
	 * @var \App\Acesso 
	 */ 
	protected $acesso;

	/**
	 * @var \App\Conexao 
	 */ 
	protected $conexao;

	/**
	 * @var \App\Helper
	 */ 
	protected $helper;

	/**
	 * @var \App\Mensagem
	 */ 
	protected $mensagem;

	/**
	 * @var array
	 */ 
	protected $models = [];

	/**
	 * @var array
	 */ 
	protected $availableModels = [];

	/**
	 * @var \App\View
	 */
	protected $view;

	/**
	 * Método construtor
	 *
	 * @return void
	 */
	public function __construct($validarLogin = true)
	{
		$this->acesso    = new Acesso();
		$this->mensagem  = new Mensagem();
		$this->helper    = new Helper();	
		$this->view      = new View();	

		// Verificar se o usuário está logado
		if ($validarLogin && !$this->acesso->verificaLogin()) {
			header('Location: ' . $this->helper->url('UsuarioController@login'));
			exit;
		}

		$this->conexao = new Conexao();		

		// Carregar as models dinamicamente
		foreach ($this->models as $model) {
			if (!array_key_exists(strtolower($model), $this->availableModels)) {
				$class = '\\Foo\\Model\\' . $model;
				$this->availableModels[strtolower($model)] = new $class($this->conexao->getCon());
			}			
		}
	}

	/**
	 * Método mágico __get para tudo que for jogado no atributo $models virar atributo
	 *
	 * @return \App\Base
	 */
	public function __get($model)
	{
		if (array_key_exists($model, $this->availableModels)) {
            return $this->availableModels[$model];
        }

        return false;
	}
}