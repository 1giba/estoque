<?php
/**
 * Inicia a aplicação
 *
 */
include 'bootstrap.php';

require_once DIRETORIO_APP . '/Aplicacao.php';

$aplicacao = new Aplicacao();

return $aplicacao->iniciar($_REQUEST);