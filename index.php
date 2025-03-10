<?php
// index.php à la racine du projet

// Activer le chargement automatique des classes (défini via composer.json)
require_once __DIR__ . '/core/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Router;

// Normalisation de l'URL
$uri = trim($_SERVER['REQUEST_URI'], '/');


// Instancier le routeur et traiter la requête en cours
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']) ?? null;
