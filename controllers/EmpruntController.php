<?php

use App\Core\BaseController;
use App\Core\Route;
use App\Services\Database;
use DateTime;

class EmpruntController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getCollection("emprunts");
    }

    #[Route("/livre/emprunter", "POST")]
    public function emprunterLivre()
    {
        $data = $this->getRequestData();

        if (!isset($data['titre'], $data['auteur'], $data['emprunteur'])) {
            return $this->json(["error" => "Champs manquants"], 400);
        }

        $this->db->insertOne([
            "titre" => $data['titre'],
            "auteur" => $data['auteur'],
            "emprunteur" => $data['emprunteur'],
            "date_emprunt" => new DateTime()
        ]);

        return $this->json(["message" => "Livre emprunté avec succès"]);
    }

    #[Route("/emprunts", "GET")]
    public function getAll()
    {
        $emprunts = $this->db->find()->toArray();
        return $this->json($emprunts);
    }
}
