<?php

namespace App\Core;

class BaseController
{

    /**
     * Render une vue en concaténant les fichiers HTML.
     *
     * @param string $view Nom du fichier HTML (sans extension)
     * @param array $data Données à injecter (optionnel)
     */
    protected function render(string $view, array $data = [])
    {
        $viewFile = __DIR__ . '/../views/' . $view . '.html';

        if (!file_exists($viewFile)) {
            http_response_code(404);
            echo "Erreur 404 - Vue '{$view}' introuvable.";
            return;
        }

        // Lire le contenu du fichier HTML
        $content = file_get_contents($viewFile);

        // Remplacement des variables {{variable}} dans le template
        foreach ($data as $key => $value) {
            $content = str_replace("{{ $key }}", htmlspecialchars($value), $content);
        }

        echo $content;
    }

    /**
     * Envoie une réponse JSON.
     *
     * @param mixed $data Données à encoder en JSON
     * @param int $statusCode Code HTTP (200 par défaut)
     */
    protected function json($data, int $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * Récupère les données de la requête (POST, JSON).
     *
     * @return array Données sous forme de tableau
     */
    protected function getRequestData(): array
    {
        $data = $_POST;

        // Si c'est une requête JSON, on récupère le body brut
        if (empty($data)) {
            $inputJSON = file_get_contents("php://input");
            $jsonData = json_decode($inputJSON, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $data = $jsonData;
            }
        }

        return $data;
    }
}
