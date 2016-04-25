<?php
/*
 *
 * Definição dos caminhos da aplicação
 *
 */
define('DIRETORIO_MODELS', __DIR__ . '/Model');
define('DIRETORIO_VIEWS', __DIR__ . '/View');
define('DIRETORIO_CONTROLLERS', __DIR__ . '/Controller');
define('DIRETORIO_APP', __DIR__ . '/App');
define('DIRETORIO_VENDORS', __DIR__ . '/Vendor');

/*
 *
 * Disponibilizando o CORE da aplicação
 *
 */
require_once DIRETORIO_APP . '/Aplicacao.php';
require_once DIRETORIO_APP . '/Acesso.php';
require_once DIRETORIO_APP . '/Conexao.php';
require_once DIRETORIO_APP . '/Mensagem.php';
require_once DIRETORIO_APP . '/Helper.php';
require_once DIRETORIO_APP . '/View.php';

/*
 *
 * Disponibilizando as models
 *
 */
require_once DIRETORIO_MODELS . '/Base.php';
require_once DIRETORIO_MODELS . '/Estoque.php';
require_once DIRETORIO_MODELS . '/Produto.php';
require_once DIRETORIO_MODELS . '/Usuario.php';

/*
 *
 * Disponibilizando a classe base do Controller
 *
 */
require_once DIRETORIO_CONTROLLERS . '/BaseController.php';