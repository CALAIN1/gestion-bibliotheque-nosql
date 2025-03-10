<?php

use App\Core\BaseController;
use App\Core\Route;

class EmpruntController extends BaseController
{
    private $db;

    public function __construct()
    {
        //$this->db = (new Database())->getCollection("emprunts");
    }

    #[Route("/livre/{livre_id}/emprunt")]
    public function getEmprunteur($livre_id)
    {
        /*$emprunt = $this->db->findOne(["livre_id" => new MongoDB\BSON\ObjectId($livre_id)]);
        if ($emprunt) {
            echo json_encode($emprunt);
        } else {
            echo json_encode(["message" => "Ce livre n'est pas emprunté."]);
        }*/
    }
}
