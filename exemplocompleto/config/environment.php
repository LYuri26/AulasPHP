<?php
// Configurações do ambiente
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Função para sanitizar dados
function sanitize($data)
{
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)));
}
