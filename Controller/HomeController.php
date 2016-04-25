<?php

require_once DIRETORIO_CONTROLLERS . '/BaseController.php';
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
		// Adiciona a view da home 
		include DIRETORIO_VIEWS . '/home/index.php';
	}
}