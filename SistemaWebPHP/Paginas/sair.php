<?php
session_start(); // Inicia a sessão PHP.

// Destruir a sessão
session_destroy(); // Encerra a sessão, removendo todas as variáveis de sessão.

// Redirecionar para a tela de autenticação (index.php)
header("Location: index.php"); // Envia um cabeçalho de redirecionamento para o navegador, instruindo-o a carregar a página 'index.php'.

exit(); // Encerra o script para garantir que nada mais seja executado após o redirecionamento.
?>
