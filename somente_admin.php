<?php
// Caso o usuário não for administrador, exibir mensagem
if ($_SESSION['usuario']['perfil'] !== 'admin') {
	echo '<h1>Acesso não permitido</h1>';
	echo '<p><a href="../index.php">Voltar</a></p>';
	exit;
}