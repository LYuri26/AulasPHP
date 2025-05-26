<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Redireciona para login ou dashboard dependendo do status
if (isLoggedIn()) {
    redirect('./dashboard.php');
} else {
    redirect('./dashboard.php');
}
