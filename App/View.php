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
		require_once DIRETORIO_VENDORS . '/Twig-1.x/lib/Twig/Autoloader.php';
		\Twig_Autoloader::register();
		$loader = new \Twig_Loader_Filesystem(DIRETORIO_VIEWS);
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