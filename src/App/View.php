<?php

namespace Foo\App;

/**
 * Classe responsável por montar as views da aplicação
 *
 */
class View
{
	/**
	 * @var
	 */
	protected $templateEngine;

	/**
	 * Método construtor
	 *
	 */
	public function __construct()
	{
		$loader = new \Twig_Loader_Filesystem(__DIR__ . '/../View');
		$this->templateEngine = new \Twig_Environment($loader);
	}

	/**
	 * Renderiza o template
	 *
	 * @param string $template
	 * @param array $args
	 * @return string
	 */
	public function render($template, $args = [])
	{
		return $this->templateEngine->render($template, $args);
	}
}