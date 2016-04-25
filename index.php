<?php
/**
 * Inicia a aplicação
 *
 */
require 'vendor/autoload.php';

use Foo\App\Aplicacao;

$aplicacao = new Aplicacao();

return $aplicacao->iniciar($_REQUEST);