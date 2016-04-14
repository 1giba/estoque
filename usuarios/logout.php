<?php
// Disponibiliza a classe
include '../classes/Acesso.php';

// Instancia a classe
$acesso = new Acesso();

// Desloga o usuário logado
$acesso->limparSessao();

// Redireciona para a tela de login
header('Location: login.php');