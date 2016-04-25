<?php

namespace Foo\App;

/**
 * Classe responsável por implementar os métodos do Controller 
 *
 */
class Aplicacao
{

	/** 
	 * @var string
	 */ 
	protected $controlador = 'HomeController';

	/** 
	 * @var string
	 */ 
	protected $metodo = 'index';

	/** 
	 * @var array
	 */ 
	protected $parametros;

	/**
	 * Método para "startar" a aplicação
	 *
	 * @param array $requisicao
	 * @return html
	 */
	public function iniciar($requisicao = [])
	{
		if (!empty($requisicao['controlador'])) {
			$this->controlador = ucfirst($requisicao['controlador']) . 'Controller';
			unset($requisicao['controlador']);
		}

		if (!empty($requisicao['metodo'])) {
			$this->metodo = $requisicao['metodo'];
			unset($requisicao['metodo']);
		}

		$this->parametros = $requisicao;
		
		require_once DIRETORIO_CONTROLLERS . '/' . $this->controlador . '.php';

		$controlador = '\\Foo\\Controller\\' . $this->controlador;

		$objeto = new $controlador($this->metodo !== 'login');
		return $objeto->{$this->metodo}($this->parametros);
	}
}