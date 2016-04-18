<?php
/** 
 * Classe responsável por montar as rotas da aplicação
 *
 */
class Helper
{
	/**
	 * Gera a url da aplicação
	 *
	 * @param string $route
	 * @param array $params
	 * @return array
	 */
	public function url($route, $params = [])
	{
		list($controlador, $metodo) = explode('@', $route);

		$controlador = strtolower(str_replace('Controller', '', $controlador));

		return "index.php?controlador=$controlador&metodo=$metodo" . ($params ? "&" . http_build_query($params) : "");
	}
}