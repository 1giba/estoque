<?php

if ($_SESSION['usuario']['perfil'] !== 'admin') {
	echo '<h1>Acesso não permitido</h1>';
	echo '<p><a href="../index.php">Voltar</a></p>';
	exit;
}