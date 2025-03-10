<?php
// core/autoload.php - Autoloader maison PSR-4

spl_autoload_register(function ($class) {
    // Définition de la racine du projet
    $baseDir = __DIR__ . '/../';

    // Remplacement du namespace en chemin système
    $classPath = str_replace(['\\', 'App/'], ['/', ''], $class) . '.php';

    // Construire le chemin du fichier
    $file = $baseDir . $classPath;

    // Vérifier si le fichier existe avant de l'inclure
    if (file_exists($file)) {
        require $file;
    }
});
