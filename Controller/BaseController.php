<?php

require_once DIRETORIO_APP . '/Acesso.php';
require_once DIRETORIO_APP . '/Conexao.php';
require_once DIRETORIO_APP . '/Mensagem.php';
require_once DIRETORIO_APP . '/Helper.php';

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
	 * Método construtor
	 *
	 * @return void
	 */
	public function __construct($validarLogin = true)
	{
		$this->acesso    = new Acesso();
		$this->mensagem  = new Mensagem();
		$this->helper    = new Helper();		

		// Verificar se o usuário está logado
		if ($validarLogin && !$this->acesso->verificaLogin()) {
			header('Location: ' . $this->helper->url('UsuarioController@login'));
			exit;
		}

		$this->conexao = new Conexao();		

		// Carregar as models dinamicamente
		foreach ($this->models as $model) {
			if (!array_key_exists(strtolower($model), $this->availableModels)) {
				require_once DIRETORIO_MODELS . '/' . $model . '.php';
				$this->availableModels[strtolower($model)] = new $model($this->conexao->getCon());
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