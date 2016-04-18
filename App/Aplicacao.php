<?php
/**
 * Classe responsável por implementar os métodos do Controller 
 *
 */
class Aplicacao
{

	protected $controlador = 'HomeController';

	protected $metodo = 'index';

	protected $parametros;

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
		$objeto = new $this->controlador($this->metodo !== 'login');
		return $objeto->{$this->metodo}($this->parametros);
	}
}