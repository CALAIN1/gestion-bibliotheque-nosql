<?php

namespace App\Models;

use App\Services\Database;
use DateTime;

class Livre
{
    public string $titre;
    public string $auteur;
    public int $annee;
    public DateTime $date_creation;

    public function __construct()
    {
        $this->date_creation = new DateTime();
    }
}
