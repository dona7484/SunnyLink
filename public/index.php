<?php

// Activer les erreurs PHP pour le débogage
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Définir le chemin de base pour éviter les erreurs de chemin
define('BASE_PATH', dirname(__DIR__));

// Inclure le fichier du routeur
require_once BASE_PATH . '/routes/web.php';
?>
