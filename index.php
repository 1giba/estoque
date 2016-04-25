<?php
/**
 * Inicia a aplicação
 *
 */
include 'bootstrap.php';

use Foo\App\Aplicacao;

$aplicacao = new Aplicacao();

return $aplicacao->iniciar($_REQUEST);