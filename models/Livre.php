<?php

namespace App\Models;

use DateTime;

class Livre
{
    public string $titre;
    public string $auteur;
    public int $annee;
    public DateTime $date_creation;

    // Constructeur avec initialisation des propriétés
    public function __construct($titre = "", $auteur = "", $annee = 0)
    {
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->annee = $annee;
        $this->date_creation = new DateTime();
    }

    // Méthode pour convertir l'objet en tableau associatif
    public function toArray(): array
    {
        return [
            'titre' => $this->titre,
            'auteur' => $this->auteur,
            'annee' => $this->annee,
            'date_creation' => $this->date_creation->format('Y-m-d H:i:s') // format à enregistrer
        ];
    }
}
