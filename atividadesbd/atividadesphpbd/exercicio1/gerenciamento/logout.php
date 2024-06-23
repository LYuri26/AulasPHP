<?php
// Inicia a sessão
session_start();

// Finaliza a sessão (logout)
session_destroy();

// Redireciona para a página de login
header("Location: ../index.html");
exit();
?>
