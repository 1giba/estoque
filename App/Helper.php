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
		list($controlador, $metodo) = $this->formatRoute($route);

		return "index.php?controlador=$controlador&metodo=$metodo" . ($params ? "&" . http_build_query($params) : "");
	}

	/**
	 * Gera tags html hidden de query string
	 *
	 * @param string $route
	 * @return string
	 */
	public function hiddenTags($route)
	{
		list($controlador, $metodo) = $this->formatRoute($route);

		return '<input type="hidden" name="controlador" value="' . $controlador . '">' .
			'<input type="hidden" name="metodo" value="' . $metodo . '">';
	}

	/**
	 * Formata a rota
	 *
	 * @param string $route
	 * @return array
	 */
	public function formatRoute($route)
	{
		list($controlador, $metodo) = explode('@', $route);

		$controlador = strtolower(str_replace('Controller', '', $controlador));

		return [
			$controlador, 
			$metodo,
		];
	}
}