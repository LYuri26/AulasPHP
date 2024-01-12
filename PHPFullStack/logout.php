<?php
session_start(); // Inicia a sessão

// Destruir a sessão
session_destroy();

// Redirecionar para a página Index.php
header('Location: Index.php');
exit();
?>
