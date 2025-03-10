<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Route;
use App\Services\Database;
use DateTime;
use Exception;

class LivreController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getCollection("livres");
    }

    #[Route("/livre/recherche/{auteur}", "GET")]
    public function rechercherParAuteur($auteur)
    {
        $result = $this->db->find(["auteur" => $auteur])->toArray();
        return $this->json($result);
    }

    #[Route("/livre/ajout", "POST")]
    public function ajoutLivre()
    {
        $data = $this->getRequestData();

        if (!isset($data['titre']) || !isset($data['auteur']) || !isset($data['annee'])) {
            return $this->json(["error" => "Champs manquants : titre, auteur, annee"], 400);
        }

        try {
            $result = $this->db->insertOne([
                "titre" => $data['titre'],
                "auteur" => $data['auteur'],
                "annee" => (int) $data['annee'],
                "date_creation" => new DateTime()
            ]);

            return $this->json([
                "message" => "Livre ajouté avec succès",
                "livre_id" => (string) $result->getInsertedId()
            ], 201);
        } catch (\Exception $e) {
            return $this->json(["error" => "Erreur MongoDB : " . $e->getMessage()], 500);
        }
    }
}
