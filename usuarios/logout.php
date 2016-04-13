<?php
// Inicializa a sessão
session_start();
// Destrói a sessão
session_destroy();

// Redireciona para a tela de login
header('Location: login.php');